<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $fillable = [
        'menu_id',
        'tanggal_prediksi',
        'prediksi_terjual',
        'rekomendasi_stok_tambahan',
        'saran_aksi',
        'mad',
        'mse',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
