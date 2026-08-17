<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $menus = Menu::where('stok_saat_ini', '>', 0)->get();
        return view('transactions.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|string', // JSON string from frontend
        ]);

        $cartItems = json_decode($request->cart, true);

        if (empty($cartItems)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            $totalHarga = 0;
            
            // Calculate total first
            foreach ($cartItems as $item) {
                $totalHarga += $item['harga'] * $item['qty'];
            }

            // Create Sale record
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total_harga' => $totalHarga,
                'tanggal_transaksi' => now(),
            ]);

            // Create Sale details and reduce stock
            foreach ($cartItems as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'menu_id' => $item['id'],
                    'jumlah_beli' => $item['qty'],
                    'subtotal' => $item['harga'] * $item['qty'],
                ]);

                // Reduce stock
                $menu = Menu::lockForUpdate()->find($item['id']);
                if ($menu->stok_saat_ini < $item['qty']) {
                    throw new \Exception("Stok tidak mencukupi untuk menu: " . $menu->nama_menu);
                }
                $menu->stok_saat_ini -= $item['qty'];
                $menu->save();
            }

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
        }
    }
}
