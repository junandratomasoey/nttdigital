<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketHarga extends Model
{
    protected $fillable = [
        'nama', 'label_badge', 'harga', 'satuan',
        'fitur', 'unggulan', 'urutan', 'aktif',
    ];

    protected $casts = [
        'fitur'    => 'array',
        'unggulan' => 'boolean',
        'aktif'    => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
