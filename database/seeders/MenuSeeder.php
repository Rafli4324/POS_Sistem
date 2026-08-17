<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['nama_menu' => 'Indomie', 'kategori' => 'Makanan', 'harga' => 15000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Seblak Komplit', 'kategori' => 'Makanan', 'harga' => 17000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Chicken Katsu + Nasi + Sambal', 'kategori' => 'Makanan', 'harga' => 17000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Sate Jelly Ball', 'kategori' => 'Makanan', 'harga' => 12000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Cireng Gemoy', 'kategori' => 'Makanan', 'harga' => 12000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Sate Taichan', 'kategori' => 'Makanan', 'harga' => 20000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Nasi Ayam Penyet', 'kategori' => 'Makanan', 'harga' => 20000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Roti Bakar', 'kategori' => 'Makanan', 'harga' => 12000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Teh Raden', 'kategori' => 'Minuman', 'harga' => 7000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Es Kopi Gula Aren', 'kategori' => 'Minuman', 'harga' => 15000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Es Teller Sultan', 'kategori' => 'Minuman', 'harga' => 17000, 'stok_saat_ini' => 50],
            ['nama_menu' => 'Es Jelly Ball', 'kategori' => 'Minuman', 'harga' => 14000, 'stok_saat_ini' => 50],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['nama_menu' => $menu['nama_menu']],
                [
                    'kategori' => $menu['kategori'],
                    'harga' => $menu['harga'],
                    'stok_saat_ini' => $menu['stok_saat_ini']
                ]
            );
        }
    }
}
