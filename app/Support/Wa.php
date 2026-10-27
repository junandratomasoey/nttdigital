<?php

namespace App\Support;

use App\Models\SiteSetting;

class Wa
{
    public static function nomor(): string
    {
        return ltrim((string) SiteSetting::get('site_whatsapp', ''), '+');
    }

    /** Link wa.me dengan pesan pembuka yang sudah terisi. */
    public static function link(?string $pesan = null): string
    {
        $pesan ??= 'Halo NTT Digital, saya ingin konsultasi pembuatan website';

        return 'https://wa.me/' . static::nomor() . '?text=' . rawurlencode($pesan);
    }
}
