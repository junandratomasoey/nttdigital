<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Portofolio extends Model
{
    protected $fillable = [
        'nama_proyek', 'slug', 'kategori', 'klien', 'lokasi', 'tahun',
        'emoji_icon', 'warna_thumb', 'deskripsi', 'konten', 'fitur', 'teknologi',
        'gambar_thumbnail', 'galeri', 'link_demo', 'meta_description',
        'tampilkan_demo', 'urutan', 'aktif',
    ];

    protected $casts = [
        'aktif'          => 'boolean',
        'tampilkan_demo' => 'boolean',
        'fitur'          => 'array',
        'teknologi'      => 'array',
        'galeri'         => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Portofolio $porto) {
            if (blank($porto->slug)) {
                $base = Str::slug($porto->nama_proyek) ?: 'proyek';
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->where('id', '!=', $porto->id ?? 0)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $porto->slug = $slug;
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

    public function testimonis(): HasMany
    {
        return $this->hasMany(Testimoni::class);
    }
}
