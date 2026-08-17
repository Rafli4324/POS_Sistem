<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExcelMenuSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $menus = [
            ['nama_menu' => 'Indomie', 'kategori' => 'Makanan', 'harga' => 15000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Seblak Komplit', 'kategori' => 'Makanan', 'harga' => 15000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Chicken Katsu + Nasi + Sambal', 'kategori' => 'Makanan', 'harga' => 12000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Sate Jelly Ball', 'kategori' => 'Makanan', 'harga' => 5000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Cireng Gemoy', 'kategori' => 'Makanan', 'harga' => 10000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Sate Taichan', 'kategori' => 'Makanan', 'harga' => 15000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Nasi Ayam Penyet', 'kategori' => 'Makanan', 'harga' => 15000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Roti Bakar', 'kategori' => 'Makanan', 'harga' => 8000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Teh Raden', 'kategori' => 'Minuman', 'harga' => 3000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Es Kopi Gula Aren', 'kategori' => 'Minuman', 'harga' => 15000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Es Teller Sultan', 'kategori' => 'Minuman', 'harga' => 10000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['nama_menu' => 'Es Jelly Ball', 'kategori' => 'Minuman', 'harga' => 10000, 'stok_saat_ini' => 0, 'created_at' => $now, 'updated_at' => $now],
        ];
        
        DB::table('menus')->insert($menus);
    }
}
