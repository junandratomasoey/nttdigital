<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimoni extends Model
{
    protected $fillable = [
        'nama', 'jabatan', 'instansi', 'foto', 'isi', 'rating',
        'portofolio_id', 'urutan', 'aktif',
    ];

    protected $casts = [
        'aktif'  => 'boolean',
        'rating' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    public function portofolio(): BelongsTo
    {
        return $this->belongsTo(Portofolio::class);
    }

    public function getInisialAttribute(): string
    {
        return collect(explode(' ', $this->nama))
            ->filter()->take(2)
            ->map(fn ($k) => mb_strtoupper(mb_substr($k, 0, 1)))
            ->implode('');
    }
}
