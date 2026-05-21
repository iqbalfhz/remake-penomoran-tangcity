<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Sembunyikan teknologi yang digunakan
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // Cegah browser menebak tipe konten (MIME sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Cegah halaman dimuat dalam iframe dari domain lain (clickjacking)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Paksa HTTPS selama 1 tahun (hanya aktif di production)
        if (app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Kontrol informasi referer yang dikirim ke situs lain
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Batasi fitur browser yang bisa diakses oleh halaman
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}
