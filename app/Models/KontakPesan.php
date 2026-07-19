<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakPesan extends Model
{
    protected $fillable = [
        'nama', 'whatsapp', 'jenis_website', 'pesan', 'status', 'dibaca_pada',
    ];

    protected $casts = [
        'dibaca_pada' => 'datetime',
    ];

    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    public function getLabelStatusAttribute(): string
    {
        return match($this->status) {
            'baru'      => 'Baru',
            'dibaca'    => 'Dibaca',
            'diproses'  => 'Diproses',
            'selesai'   => 'Selesai',
            default     => 'Baru',
        };
    }

    public function getWarnaStatusAttribute(): string
    {
        return match($this->status) {
            'baru'      => 'danger',
            'dibaca'    => 'warning',
            'diproses'  => 'info',
            'selesai'   => 'success',
            default     => 'danger',
        };
    }
}
