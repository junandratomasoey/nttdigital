<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSlide extends Model
{
    protected $fillable = [
        'judul', 'subjudul', 'deskripsi', 'warna_tema',
        'emoji_icon', 'gambar',
        'teks_tombol_utama', 'link_tombol_utama',
        'teks_tombol_kedua', 'link_tombol_kedua',
        'urutan', 'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    public function getWarnaBgClass(): string
    {
        return match($this->warna_tema) {
            'biru'  => 'slide-biru',
            'ungu'  => 'slide-ungu',
            default => 'slide-teal',
        };
    }
}
