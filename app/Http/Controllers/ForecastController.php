<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Forecast;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForecastController extends Controller
{
    public function index()
    {
        $forecasts = Forecast::with('menu')->orderBy('tanggal_prediksi', 'desc')->paginate(20);
        $menus = Menu::all();

        // Cari menu paling laku untuk besok (dari prediksi terbaru)
        $topMenu = null;
        if ($forecasts->count() > 0) {
            $latestDate = Forecast::max('tanggal_prediksi');
            $topMenu = Forecast::with('menu')
                ->where('tanggal_prediksi', $latestDate)
                ->orderBy('prediksi_terjual', 'desc')
                ->first();
        }

        return view('forecasts.index', compact('forecasts', 'menus', 'topMenu'));
    }

    public function generate()
    {
        $menus = Menu::all();
        $targetDate = Carbon::tomorrow();
        $n_days = 7; // Menggunakan 7 hari untuk SMA
        
        DB::beginTransaction();
        try {
            // Delete existing prediction for tomorrow to avoid duplicates
            Forecast::whereDate('tanggal_prediksi', $targetDate->format('Y-m-d'))->delete();

            foreach ($menus as $menu) {
                // 1. Ambil data penjualan aktual untuk n hari terakhir
                $actualSales = [];
                for ($i = $n_days; $i >= 1; $i--) {
                    $date = $targetDate->copy()->subDays($i)->format('Y-m-d');
                    $sales = SaleDetail::where('menu_id', $menu->id)
                        ->whereHas('sale', function($q) use ($date) {
                            $q->whereDate('tanggal_transaksi', $date);
                        })->sum('jumlah_beli');
                    $actualSales[] = $sales;
                }

                // 2. Hitung Prediksi SMA untuk besok
                $totalSales = array_sum($actualSales);
                $predictedSales = round($totalSales / $n_days);

                // 3. Hitung MAD dan MSE (Simulasi error untuk data historis)
                // Kita ambil 7 hari aktual sebelumnya untuk dibandingkan dengan prediksi
                $absErrors = [];
                $sqErrors = [];
                
                for ($day = 1; $day <= 7; $day++) {
                    $historicalActualForTarget = $actualSales[7 - $day] ?? 0;
                    
                    // Hitung prediksi SMA untuk hari tersebut menggunakan n hari sblmnya
                    $pastSalesForSMA = [];
                    for ($j = 1; $j <= $n_days; $j++) {
                        $pastDate = $targetDate->copy()->subDays($day + $j)->format('Y-m-d');
                        $pSale = SaleDetail::where('menu_id', $menu->id)
                            ->whereHas('sale', function($q) use ($pastDate) {
                                $q->whereDate('tanggal_transaksi', $pastDate);
                            })->sum('jumlah_beli');
                        $pastSalesForSMA[] = $pSale;
                    }
                    $pastPrediction = round(array_sum($pastSalesForSMA) / $n_days);
                    
                    $error = $historicalActualForTarget - $pastPrediction;
                    $absErrors[] = abs($error);
                    $sqErrors[] = pow($error, 2);
                }
                
                $mad = 0;
                $mse = 0;
                if (count($absErrors) > 0) {
                    $mad = array_sum($absErrors) / count($absErrors);
                    $mse = array_sum($sqErrors) / count($sqErrors);
                }

                // 4. Hitung Rekomendasi Stok
                $safetyStock = ceil($predictedSales * 0.2);
                $totalKebutuhan = $predictedSales + $safetyStock;
                
                $stokSaatIni = $menu->stok_saat_ini;
                
                if ($stokSaatIni < $totalKebutuhan) {
                    $rekomendasiStokTambahan = $totalKebutuhan - $stokSaatIni;
                    $saranAksi = 'Tambah Stok';
                } elseif ($stokSaatIni > ($totalKebutuhan * 1.5) && $stokSaatIni > 0) { 
                    // Jika stok lebih dari 150% kebutuhan, sarankan kurangi
                    $rekomendasiStokTambahan = 0; // Tidak perlu tambah
                    $saranAksi = 'Kurangi Stok';
                } else {
                    $rekomendasiStokTambahan = 0;
                    $saranAksi = 'Stok Aman';
                }

                Forecast::create([
                    'menu_id' => $menu->id,
                    'tanggal_prediksi' => $targetDate->format('Y-m-d'),
                    'prediksi_terjual' => $predictedSales,
                    'rekomendasi_stok_tambahan' => $rekomendasiStokTambahan,
                    'saran_aksi' => $saranAksi,
                    'mad' => $mad,
                    'mse' => $mse
                ]);
            }
            DB::commit();
            return redirect()->route('forecasts.index')->with('success', 'Peramalan SMA untuk besok berhasil di-generate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan peramalan: ' . $e->getMessage());
        }
    }

    public function predictManual(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('excel_file');
        $filename = 'upload_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/temp'), $filename);
        $fullPath = storage_path('app/temp/' . $filename);

        $scriptPath = base_path('sma_from_excel.py');
        $escapedPath = escapeshellarg($fullPath);
        
        $command = "python \"$scriptPath\" $escapedPath";
        $output = shell_exec($command);
        
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        
        if (!$output) {
            return back()->with('error', 'Gagal mengeksekusi script Python pembaca Excel.');
        }

        $result = json_decode($output, true);
        
        if (!$result || isset($result['error'])) {
            return back()->with('error', 'Error dari script pembaca: ' . ($result['error'] ?? 'Unknown error'));
        }

        $augmentedPredictions = [];
        foreach ($result['predictions'] as $pred) {
            $menu = Menu::where('nama_menu', $pred['menu_nama'])->first();
            $stokSaatIni = $menu ? $menu->stok_saat_ini : 0;
            $predictedSales = $pred['prediksi'];

            $safetyStock = ceil($predictedSales * 0.2);
            $totalKebutuhan = $predictedSales + $safetyStock;
            
            if ($stokSaatIni < $totalKebutuhan) {
                $rekomendasiStokTambahan = $totalKebutuhan - $stokSaatIni;
                $saranAksi = 'Tambah Stok';
            } elseif ($stokSaatIni > ($totalKebutuhan * 1.5) && $stokSaatIni > 0) { 
                $rekomendasiStokTambahan = 0;
                $saranAksi = 'Kurangi Stok';
            } else {
                $rekomendasiStokTambahan = 0;
                $saranAksi = 'Stok Aman';
            }

            $augmentedPredictions[] = [
                'menu_nama' => $pred['menu_nama'],
                'prediksi' => $predictedSales,
                'stok_saat_ini' => $stokSaatIni,
                'saran_aksi' => $saranAksi,
                'rekomendasi_stok_tambahan' => $rekomendasiStokTambahan,
                'mad' => $pred['mad'] ?? 0,
                'mse' => $pred['mse'] ?? 0
            ];
        }
        $result['predictions'] = $augmentedPredictions;

        return back()->with('manual_result', $result);
    }
}
