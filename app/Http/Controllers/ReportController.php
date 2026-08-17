<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalRevenue = Sale::sum('total_harga');
        
        $startDate = Carbon::now()->subDays(13)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $sales = Sale::whereBetween('tanggal_transaksi', [$startDate, $endDate])
                     ->select(DB::raw('DATE(tanggal_transaksi) as date'), DB::raw('SUM(total_harga) as total'))
                     ->groupBy('date')
                     ->orderBy('date', 'ASC')
                     ->get();
                     
        $labels = [];
        $data = [];
        
        $currentDate = clone $startDate;
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $labels[] = $currentDate->format('d M');
            
            $sale = $sales->firstWhere('date', $dateString);
            $data[] = $sale ? $sale->total : 0;
            
            $currentDate->addDay();
        }
        
        return view('reports.index', compact('totalRevenue', 'labels', 'data'));
    }
    public function exportCsv()
    {
        $fileName = 'transaksi_pos_' . date('Y_m_d') . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $details = SaleDetail::with(['sale', 'menu'])->get();

        $columns = ['ID Transaksi', 'Tanggal', 'Kasir ID', 'Menu', 'Kategori', 'Jumlah Beli', 'Subtotal'];

        $callback = function() use($details, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($details as $detail) {
                $row['ID Transaksi']  = $detail->sale_id;
                $row['Tanggal']    = $detail->sale->tanggal_transaksi;
                $row['Kasir ID']  = $detail->sale->user_id;
                $row['Menu']  = $detail->menu->nama_menu;
                $row['Kategori']  = $detail->menu->kategori;
                $row['Jumlah Beli']  = $detail->jumlah_beli;
                $row['Subtotal']  = $detail->subtotal;

                fputcsv($file, array($row['ID Transaksi'], $row['Tanggal'], $row['Kasir ID'], $row['Menu'], $row['Kategori'], $row['Jumlah Beli'], $row['Subtotal']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
