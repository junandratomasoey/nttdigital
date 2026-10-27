<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'pertanyaan', 'jawaban', 'kategori', 'tampil_di_beranda', 'urutan', 'aktif',
    ];

    protected $casts = [
        'aktif'             => 'boolean',
        'tampil_di_beranda' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
