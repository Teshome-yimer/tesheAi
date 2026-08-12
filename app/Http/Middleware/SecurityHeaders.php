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

        // Security headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        //grade A
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' https: data:; connect-src 'self' https:;");
        
    // ለ Dynamic ገጾች የትክክለኛ Cache ቁጥጥር (እንደ አስፈላጊነቱ)
       $response->headers->set('Cache-Control', 'no-cache, private');



 
        // PHP ቨርዥን የሚናገረውን የ Header መረጃ ማስወገድ
        header_remove('X-Powered-By');
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
