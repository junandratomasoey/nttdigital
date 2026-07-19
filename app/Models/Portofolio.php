<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    protected $fillable = [
        'nama_proyek', 'kategori', 'emoji_icon', 'warna_thumb',
        'deskripsi', 'gambar_thumbnail', 'link_demo',
        'tampilkan_demo', 'urutan', 'aktif',
    ];

    protected $casts = [
        'aktif'          => 'boolean',
        'tampilkan_demo' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
