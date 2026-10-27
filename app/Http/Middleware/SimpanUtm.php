<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menyimpan parameter UTM (utm_source, utm_medium, utm_campaign) dari URL
 * kampanye ke session, supaya ketika pengunjung mengisi form kontak
 * kita tahu dari iklan/posting mana dia datang.
 */
class SimpanUtm
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && $request->hasAny(['utm_source', 'utm_medium', 'utm_campaign'])) {
            $request->session()->put('utm', array_map(
                fn ($v) => $v ? mb_substr((string) $v, 0, 100) : null,
                $request->only(['utm_source', 'utm_medium', 'utm_campaign'])
            ));
        }

        return $next($request);
    }
}
