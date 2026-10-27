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
        // Alet Cloud ዶሜን ሆኖ ሲመጣ ወደ tesheai.com በራስ ሰር ማዞሪያ
        if ($request->getHost() === 'tesheai-4313.app.aletcloud.com') {
            return redirect()->to('https://tesheai.com' . $request->getRequestUri(), 301);
           
 } // <--- ይህ የ } ምልክት ጠፍቶ ነበር!
        $response = $next($request);

        // Standard Security Headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Content Security Policy (CSP) - Full Mobile & Desktop PDF Support
        $csp = "default-src 'self'; "
             . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https: https://pagead2.googlesyndication.com https://www.googletagservices.com https://adservice.google.com https://www.google.com; "
             . "style-src 'self' 'unsafe-inline' https:; "
             . "img-src 'self' data: blob: https: https://pagead2.googlesyndication.com https://www.google.com; "
             . "font-src 'self' https: data:; "
             . "connect-src 'self' https: https://pagead2.googlesyndication.com https://ep2.adtrafficquality.google; "
            // manifest-src እዚህ ጋር ተጨምሯል (የ site.webmanifest ስህተትን ለማስተካከል)
             . "manifest-src 'self'; "
             // frame-src እና child-src በስልክ ላይ PDF viewer በ blob: እና data: እንዳይታገድ ይፈቅዳሉ
             . "frame-src 'self' data: blob: https://www.youtube.com https://www.youtube-nocookie.com https://drive.google.com https://docs.google.com https://player.vimeo.com https://*.bunnycdn.com https://googleads.g.doubleclick.net https://tpc.googlesyndication.com https://ep2.adtrafficquality.google https://www.google.com; "
             . "child-src 'self' data: blob: https://docs.google.com https://drive.google.com; "
             . "object-src 'self' data: blob: https://docs.google.com https://drive.google.com;";

        $response->headers->set('Content-Security-Policy', $csp);

        // PDF እና የስታቲክ ፋይል መስመሮች (Static files/PDFs) ከሆኑ Cache-Control እንዳይበላሽ ማድረግ
        if (!$request->is('storage/*') && !$request->is('documents/*')) {
            $response->headers->set('Cache-Control', 'no-cache, private');
        }

        // Remove PHP version disclosure
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
