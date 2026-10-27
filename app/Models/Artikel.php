<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    protected $fillable = [
        'judul', 'slug', 'kategori', 'ringkasan', 'konten', 'gambar', 'tags',
        'penulis', 'status', 'dipublikasikan_pada', 'dilihat',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'tags'                => 'array',
        'dipublikasikan_pada' => 'datetime',
    ];

    public const KATEGORI = [
        'Tips'           => 'Tips',
        'Panduan'        => 'Panduan',
        'Digitalisasi Desa' => 'Digitalisasi Desa',
        'Sekolah'        => 'Sekolah',
        'UMKM'           => 'UMKM',
        'Undangan'       => 'Undangan',
        'Berita'         => 'Berita',
    ];

    protected static function booted(): void
    {
        static::saving(function (Artikel $artikel) {
            if (blank($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul);
            }
            if ($artikel->status === 'terbit' && blank($artikel->dipublikasikan_pada)) {
                $artikel->dipublikasikan_pada = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Artikel yang sudah terbit dan tanggal terbitnya sudah lewat. */
    public function scopeTerbit(Builder $query): Builder
    {
        return $query->where('status', 'terbit')
            ->whereNotNull('dipublikasikan_pada')
            ->where('dipublikasikan_pada', '<=', now())
            ->orderByDesc('dipublikasikan_pada');
    }

    public function getRingkasanOtomatisAttribute(): string
    {
        return $this->ringkasan ?: Str::limit(trim(strip_tags($this->konten)), 160);
    }

    public function getMenitBacaAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags($this->konten)) / 200));
    }
}
