<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use Carbon\Carbon;

class SevenDaysSalesSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data transaksi lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sale_details')->truncate();
        DB::table('sales')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $menus = Menu::all()->keyBy('nama_menu');

        // Data hari 24 Mar '26
        $date0 = Carbon::today()->subDays(6)->format('Y-m-d');
        $saleId0 = DB::table('sales')->insertGetId([
            'user_id' => 1,
            'total_harga' => 0,
            'tanggal_transaksi' => $date0,
            'created_at' => Carbon::today()->subDays(6),
            'updated_at' => Carbon::today()->subDays(6)
        ]);
        $details = [];
        if (isset($menus['Chicken Katsu + Nasi + Sambal'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Chicken Katsu + Nasi + Sambal']->id,
                'jumlah_beli' => 5,
                'subtotal' => $menus['Chicken Katsu + Nasi + Sambal']->harga * 5,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Cireng Gemoy'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Cireng Gemoy']->id,
                'jumlah_beli' => 5,
                'subtotal' => $menus['Cireng Gemoy']->harga * 5,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Indomie'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Indomie']->id,
                'jumlah_beli' => 35,
                'subtotal' => $menus['Indomie']->harga * 35,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Nasi Ayam Penyet'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Nasi Ayam Penyet']->id,
                'jumlah_beli' => 21,
                'subtotal' => $menus['Nasi Ayam Penyet']->harga * 21,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Roti Bakar'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Roti Bakar']->id,
                'jumlah_beli' => 11,
                'subtotal' => $menus['Roti Bakar']->harga * 11,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Sate Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Sate Jelly Ball']->id,
                'jumlah_beli' => 5,
                'subtotal' => $menus['Sate Jelly Ball']->harga * 5,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Sate Taichan'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Sate Taichan']->id,
                'jumlah_beli' => 25,
                'subtotal' => $menus['Sate Taichan']->harga * 25,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Seblak Komplit'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Seblak Komplit']->id,
                'jumlah_beli' => 22,
                'subtotal' => $menus['Seblak Komplit']->harga * 22,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Es Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Es Jelly Ball']->id,
                'jumlah_beli' => 25,
                'subtotal' => $menus['Es Jelly Ball']->harga * 25,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Es Kopi Gula Aren'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Es Kopi Gula Aren']->id,
                'jumlah_beli' => 16,
                'subtotal' => $menus['Es Kopi Gula Aren']->harga * 16,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Es Teller Sultan'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Es Teller Sultan']->id,
                'jumlah_beli' => 9,
                'subtotal' => $menus['Es Teller Sultan']->harga * 9,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (isset($menus['Teh Raden'])) {
            $details[] = [
                'sale_id' => $saleId0,
                'menu_id' => $menus['Teh Raden']->id,
                'jumlah_beli' => 6,
                'subtotal' => $menus['Teh Raden']->harga * 6,
                'created_at' => Carbon::today()->subDays(6),
                'updated_at' => Carbon::today()->subDays(6)
            ];
        }
        if (count($details) > 0) {
            DB::table('sale_details')->insert($details);
        }

        // Data hari 25 Mar '26
        $date1 = Carbon::today()->subDays(5)->format('Y-m-d');
        $saleId1 = DB::table('sales')->insertGetId([
            'user_id' => 1,
            'total_harga' => 0,
            'tanggal_transaksi' => $date1,
            'created_at' => Carbon::today()->subDays(5),
            'updated_at' => Carbon::today()->subDays(5)
        ]);
        $details = [];
        if (isset($menus['Chicken Katsu + Nasi + Sambal'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Chicken Katsu + Nasi + Sambal']->id,
                'jumlah_beli' => 22,
                'subtotal' => $menus['Chicken Katsu + Nasi + Sambal']->harga * 22,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Cireng Gemoy'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Cireng Gemoy']->id,
                'jumlah_beli' => 21,
                'subtotal' => $menus['Cireng Gemoy']->harga * 21,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Indomie'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Indomie']->id,
                'jumlah_beli' => 18,
                'subtotal' => $menus['Indomie']->harga * 18,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Nasi Ayam Penyet'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Nasi Ayam Penyet']->id,
                'jumlah_beli' => 12,
                'subtotal' => $menus['Nasi Ayam Penyet']->harga * 12,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Roti Bakar'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Roti Bakar']->id,
                'jumlah_beli' => 6,
                'subtotal' => $menus['Roti Bakar']->harga * 6,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Sate Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Sate Jelly Ball']->id,
                'jumlah_beli' => 20,
                'subtotal' => $menus['Sate Jelly Ball']->harga * 20,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Sate Taichan'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Sate Taichan']->id,
                'jumlah_beli' => 12,
                'subtotal' => $menus['Sate Taichan']->harga * 12,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Seblak Komplit'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Seblak Komplit']->id,
                'jumlah_beli' => 24,
                'subtotal' => $menus['Seblak Komplit']->harga * 24,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Es Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Es Jelly Ball']->id,
                'jumlah_beli' => 11,
                'subtotal' => $menus['Es Jelly Ball']->harga * 11,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Es Kopi Gula Aren'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Es Kopi Gula Aren']->id,
                'jumlah_beli' => 7,
                'subtotal' => $menus['Es Kopi Gula Aren']->harga * 7,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Es Teller Sultan'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Es Teller Sultan']->id,
                'jumlah_beli' => 20,
                'subtotal' => $menus['Es Teller Sultan']->harga * 20,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (isset($menus['Teh Raden'])) {
            $details[] = [
                'sale_id' => $saleId1,
                'menu_id' => $menus['Teh Raden']->id,
                'jumlah_beli' => 17,
                'subtotal' => $menus['Teh Raden']->harga * 17,
                'created_at' => Carbon::today()->subDays(5),
                'updated_at' => Carbon::today()->subDays(5)
            ];
        }
        if (count($details) > 0) {
            DB::table('sale_details')->insert($details);
        }

        // Data hari 26 Mar '26
        $date2 = Carbon::today()->subDays(4)->format('Y-m-d');
        $saleId2 = DB::table('sales')->insertGetId([
            'user_id' => 1,
            'total_harga' => 0,
            'tanggal_transaksi' => $date2,
            'created_at' => Carbon::today()->subDays(4),
            'updated_at' => Carbon::today()->subDays(4)
        ]);
        $details = [];
        if (isset($menus['Chicken Katsu + Nasi + Sambal'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Chicken Katsu + Nasi + Sambal']->id,
                'jumlah_beli' => 35,
                'subtotal' => $menus['Chicken Katsu + Nasi + Sambal']->harga * 35,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Cireng Gemoy'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Cireng Gemoy']->id,
                'jumlah_beli' => 9,
                'subtotal' => $menus['Cireng Gemoy']->harga * 9,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Indomie'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Indomie']->id,
                'jumlah_beli' => 35,
                'subtotal' => $menus['Indomie']->harga * 35,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Nasi Ayam Penyet'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Nasi Ayam Penyet']->id,
                'jumlah_beli' => 14,
                'subtotal' => $menus['Nasi Ayam Penyet']->harga * 14,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Roti Bakar'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Roti Bakar']->id,
                'jumlah_beli' => 26,
                'subtotal' => $menus['Roti Bakar']->harga * 26,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Sate Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Sate Jelly Ball']->id,
                'jumlah_beli' => 30,
                'subtotal' => $menus['Sate Jelly Ball']->harga * 30,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Sate Taichan'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Sate Taichan']->id,
                'jumlah_beli' => 7,
                'subtotal' => $menus['Sate Taichan']->harga * 7,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Seblak Komplit'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Seblak Komplit']->id,
                'jumlah_beli' => 15,
                'subtotal' => $menus['Seblak Komplit']->harga * 15,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Es Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Es Jelly Ball']->id,
                'jumlah_beli' => 18,
                'subtotal' => $menus['Es Jelly Ball']->harga * 18,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Es Kopi Gula Aren'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Es Kopi Gula Aren']->id,
                'jumlah_beli' => 31,
                'subtotal' => $menus['Es Kopi Gula Aren']->harga * 31,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Es Teller Sultan'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Es Teller Sultan']->id,
                'jumlah_beli' => 16,
                'subtotal' => $menus['Es Teller Sultan']->harga * 16,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (isset($menus['Teh Raden'])) {
            $details[] = [
                'sale_id' => $saleId2,
                'menu_id' => $menus['Teh Raden']->id,
                'jumlah_beli' => 13,
                'subtotal' => $menus['Teh Raden']->harga * 13,
                'created_at' => Carbon::today()->subDays(4),
                'updated_at' => Carbon::today()->subDays(4)
            ];
        }
        if (count($details) > 0) {
            DB::table('sale_details')->insert($details);
        }

        // Data hari 27 Mar '26
        $date3 = Carbon::today()->subDays(3)->format('Y-m-d');
        $saleId3 = DB::table('sales')->insertGetId([
            'user_id' => 1,
            'total_harga' => 0,
            'tanggal_transaksi' => $date3,
            'created_at' => Carbon::today()->subDays(3),
            'updated_at' => Carbon::today()->subDays(3)
        ]);
        $details = [];
        if (isset($menus['Chicken Katsu + Nasi + Sambal'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Chicken Katsu + Nasi + Sambal']->id,
                'jumlah_beli' => 20,
                'subtotal' => $menus['Chicken Katsu + Nasi + Sambal']->harga * 20,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Cireng Gemoy'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Cireng Gemoy']->id,
                'jumlah_beli' => 22,
                'subtotal' => $menus['Cireng Gemoy']->harga * 22,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Indomie'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Indomie']->id,
                'jumlah_beli' => 7,
                'subtotal' => $menus['Indomie']->harga * 7,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Nasi Ayam Penyet'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Nasi Ayam Penyet']->id,
                'jumlah_beli' => 8,
                'subtotal' => $menus['Nasi Ayam Penyet']->harga * 8,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Roti Bakar'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Roti Bakar']->id,
                'jumlah_beli' => 27,
                'subtotal' => $menus['Roti Bakar']->harga * 27,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Sate Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Sate Jelly Ball']->id,
                'jumlah_beli' => 24,
                'subtotal' => $menus['Sate Jelly Ball']->harga * 24,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Sate Taichan'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Sate Taichan']->id,
                'jumlah_beli' => 25,
                'subtotal' => $menus['Sate Taichan']->harga * 25,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Seblak Komplit'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Seblak Komplit']->id,
                'jumlah_beli' => 32,
                'subtotal' => $menus['Seblak Komplit']->harga * 32,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Es Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Es Jelly Ball']->id,
                'jumlah_beli' => 24,
                'subtotal' => $menus['Es Jelly Ball']->harga * 24,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Es Kopi Gula Aren'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Es Kopi Gula Aren']->id,
                'jumlah_beli' => 15,
                'subtotal' => $menus['Es Kopi Gula Aren']->harga * 15,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Es Teller Sultan'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Es Teller Sultan']->id,
                'jumlah_beli' => 32,
                'subtotal' => $menus['Es Teller Sultan']->harga * 32,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (isset($menus['Teh Raden'])) {
            $details[] = [
                'sale_id' => $saleId3,
                'menu_id' => $menus['Teh Raden']->id,
                'jumlah_beli' => 8,
                'subtotal' => $menus['Teh Raden']->harga * 8,
                'created_at' => Carbon::today()->subDays(3),
                'updated_at' => Carbon::today()->subDays(3)
            ];
        }
        if (count($details) > 0) {
            DB::table('sale_details')->insert($details);
        }

        // Data hari 28 Mar '26
        $date4 = Carbon::today()->subDays(2)->format('Y-m-d');
        $saleId4 = DB::table('sales')->insertGetId([
            'user_id' => 1,
            'total_harga' => 0,
            'tanggal_transaksi' => $date4,
            'created_at' => Carbon::today()->subDays(2),
            'updated_at' => Carbon::today()->subDays(2)
        ]);
        $details = [];
        if (isset($menus['Chicken Katsu + Nasi + Sambal'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Chicken Katsu + Nasi + Sambal']->id,
                'jumlah_beli' => 14,
                'subtotal' => $menus['Chicken Katsu + Nasi + Sambal']->harga * 14,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Cireng Gemoy'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Cireng Gemoy']->id,
                'jumlah_beli' => 28,
                'subtotal' => $menus['Cireng Gemoy']->harga * 28,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Indomie'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Indomie']->id,
                'jumlah_beli' => 33,
                'subtotal' => $menus['Indomie']->harga * 33,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Nasi Ayam Penyet'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Nasi Ayam Penyet']->id,
                'jumlah_beli' => 33,
                'subtotal' => $menus['Nasi Ayam Penyet']->harga * 33,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Roti Bakar'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Roti Bakar']->id,
                'jumlah_beli' => 35,
                'subtotal' => $menus['Roti Bakar']->harga * 35,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Sate Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Sate Jelly Ball']->id,
                'jumlah_beli' => 19,
                'subtotal' => $menus['Sate Jelly Ball']->harga * 19,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Sate Taichan'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Sate Taichan']->id,
                'jumlah_beli' => 20,
                'subtotal' => $menus['Sate Taichan']->harga * 20,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Seblak Komplit'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Seblak Komplit']->id,
                'jumlah_beli' => 30,
                'subtotal' => $menus['Seblak Komplit']->harga * 30,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Es Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Es Jelly Ball']->id,
                'jumlah_beli' => 31,
                'subtotal' => $menus['Es Jelly Ball']->harga * 31,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Es Kopi Gula Aren'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Es Kopi Gula Aren']->id,
                'jumlah_beli' => 27,
                'subtotal' => $menus['Es Kopi Gula Aren']->harga * 27,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Es Teller Sultan'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Es Teller Sultan']->id,
                'jumlah_beli' => 34,
                'subtotal' => $menus['Es Teller Sultan']->harga * 34,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (isset($menus['Teh Raden'])) {
            $details[] = [
                'sale_id' => $saleId4,
                'menu_id' => $menus['Teh Raden']->id,
                'jumlah_beli' => 15,
                'subtotal' => $menus['Teh Raden']->harga * 15,
                'created_at' => Carbon::today()->subDays(2),
                'updated_at' => Carbon::today()->subDays(2)
            ];
        }
        if (count($details) > 0) {
            DB::table('sale_details')->insert($details);
        }

        // Data hari 29 Mar '26
        $date5 = Carbon::today()->subDays(1)->format('Y-m-d');
        $saleId5 = DB::table('sales')->insertGetId([
            'user_id' => 1,
            'total_harga' => 0,
            'tanggal_transaksi' => $date5,
            'created_at' => Carbon::today()->subDays(1),
            'updated_at' => Carbon::today()->subDays(1)
        ]);
        $details = [];
        if (isset($menus['Chicken Katsu + Nasi + Sambal'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Chicken Katsu + Nasi + Sambal']->id,
                'jumlah_beli' => 5,
                'subtotal' => $menus['Chicken Katsu + Nasi + Sambal']->harga * 5,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Cireng Gemoy'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Cireng Gemoy']->id,
                'jumlah_beli' => 8,
                'subtotal' => $menus['Cireng Gemoy']->harga * 8,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Indomie'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Indomie']->id,
                'jumlah_beli' => 7,
                'subtotal' => $menus['Indomie']->harga * 7,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Nasi Ayam Penyet'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Nasi Ayam Penyet']->id,
                'jumlah_beli' => 33,
                'subtotal' => $menus['Nasi Ayam Penyet']->harga * 33,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Roti Bakar'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Roti Bakar']->id,
                'jumlah_beli' => 32,
                'subtotal' => $menus['Roti Bakar']->harga * 32,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Sate Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Sate Jelly Ball']->id,
                'jumlah_beli' => 34,
                'subtotal' => $menus['Sate Jelly Ball']->harga * 34,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Sate Taichan'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Sate Taichan']->id,
                'jumlah_beli' => 29,
                'subtotal' => $menus['Sate Taichan']->harga * 29,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Seblak Komplit'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Seblak Komplit']->id,
                'jumlah_beli' => 27,
                'subtotal' => $menus['Seblak Komplit']->harga * 27,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Es Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Es Jelly Ball']->id,
                'jumlah_beli' => 21,
                'subtotal' => $menus['Es Jelly Ball']->harga * 21,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Es Kopi Gula Aren'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Es Kopi Gula Aren']->id,
                'jumlah_beli' => 18,
                'subtotal' => $menus['Es Kopi Gula Aren']->harga * 18,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Es Teller Sultan'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Es Teller Sultan']->id,
                'jumlah_beli' => 17,
                'subtotal' => $menus['Es Teller Sultan']->harga * 17,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (isset($menus['Teh Raden'])) {
            $details[] = [
                'sale_id' => $saleId5,
                'menu_id' => $menus['Teh Raden']->id,
                'jumlah_beli' => 10,
                'subtotal' => $menus['Teh Raden']->harga * 10,
                'created_at' => Carbon::today()->subDays(1),
                'updated_at' => Carbon::today()->subDays(1)
            ];
        }
        if (count($details) > 0) {
            DB::table('sale_details')->insert($details);
        }

        // Data hari 30 Mar '26
        $date6 = Carbon::today()->subDays(0)->format('Y-m-d');
        $saleId6 = DB::table('sales')->insertGetId([
            'user_id' => 1,
            'total_harga' => 0,
            'tanggal_transaksi' => $date6,
            'created_at' => Carbon::today()->subDays(0),
            'updated_at' => Carbon::today()->subDays(0)
        ]);
        $details = [];
        if (isset($menus['Chicken Katsu + Nasi + Sambal'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Chicken Katsu + Nasi + Sambal']->id,
                'jumlah_beli' => 19,
                'subtotal' => $menus['Chicken Katsu + Nasi + Sambal']->harga * 19,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Cireng Gemoy'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Cireng Gemoy']->id,
                'jumlah_beli' => 7,
                'subtotal' => $menus['Cireng Gemoy']->harga * 7,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Indomie'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Indomie']->id,
                'jumlah_beli' => 11,
                'subtotal' => $menus['Indomie']->harga * 11,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Nasi Ayam Penyet'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Nasi Ayam Penyet']->id,
                'jumlah_beli' => 25,
                'subtotal' => $menus['Nasi Ayam Penyet']->harga * 25,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Roti Bakar'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Roti Bakar']->id,
                'jumlah_beli' => 7,
                'subtotal' => $menus['Roti Bakar']->harga * 7,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Sate Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Sate Jelly Ball']->id,
                'jumlah_beli' => 9,
                'subtotal' => $menus['Sate Jelly Ball']->harga * 9,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Sate Taichan'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Sate Taichan']->id,
                'jumlah_beli' => 34,
                'subtotal' => $menus['Sate Taichan']->harga * 34,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Seblak Komplit'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Seblak Komplit']->id,
                'jumlah_beli' => 6,
                'subtotal' => $menus['Seblak Komplit']->harga * 6,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Es Jelly Ball'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Es Jelly Ball']->id,
                'jumlah_beli' => 11,
                'subtotal' => $menus['Es Jelly Ball']->harga * 11,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Es Kopi Gula Aren'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Es Kopi Gula Aren']->id,
                'jumlah_beli' => 23,
                'subtotal' => $menus['Es Kopi Gula Aren']->harga * 23,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Es Teller Sultan'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Es Teller Sultan']->id,
                'jumlah_beli' => 35,
                'subtotal' => $menus['Es Teller Sultan']->harga * 35,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (isset($menus['Teh Raden'])) {
            $details[] = [
                'sale_id' => $saleId6,
                'menu_id' => $menus['Teh Raden']->id,
                'jumlah_beli' => 5,
                'subtotal' => $menus['Teh Raden']->harga * 5,
                'created_at' => Carbon::today()->subDays(0),
                'updated_at' => Carbon::today()->subDays(0)
            ];
        }
        if (count($details) > 0) {
            DB::table('sale_details')->insert($details);
        }
    }
}
