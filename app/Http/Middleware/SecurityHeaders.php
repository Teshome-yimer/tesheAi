<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Standard Security Headers for Grade A
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Content Security Policy (CSP) configured for Grade A Security + Google AdSense Support
        $csp = "default-src 'self'; "
             . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https: https://pagead2.googlesyndication.com https://www.googletagservices.com https://adservice.google.com https://www.google.com; "
             . "style-src 'self' 'unsafe-inline' https:; "
             . "img-src 'self' data: https: https://pagead2.googlesyndication.com https://www.google.com; "
             . "font-src 'self' https: data:; "
             . "connect-src 'self' https: https://pagead2.googlesyndication.com https://ep2.adtrafficquality.google; "
             . "frame-src 'self' https://googleads.g.doubleclick.net https://tpc.googlesyndication.com https://ep2.adtrafficquality.google https://www.google.com;";

        $response->headers->set('Content-Security-Policy', $csp);

        // Cache control for dynamic pages
        $response->headers->set('Cache-Control', 'no-cache, private');

        // Remove PHP version disclosure
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
