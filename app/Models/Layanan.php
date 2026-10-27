<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    protected $fillable = [
        'nama', 'tagline', 'slug', 'emoji_icon', 'warna_bg',
        'deskripsi', 'konten', 'fitur', 'gambar', 'harga_mulai',
        'meta_title', 'meta_description', 'urutan', 'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'fitur' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Layanan $layanan) {
            if (blank($layanan->slug)) {
                $layanan->slug = Str::slug($layanan->nama);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    /**
     * Kata kunci untuk mencocokkan portofolio, contoh: "Website Desa" -> "Desa".
     */
    public function getKataKunciKategoriAttribute(): string
    {
        $kata = trim(Str::of($this->nama)->replace('Website', '')->before('/'));

        return $kata === 'Undangan Digital' ? 'Undangan' : $kata;
    }
}
