<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleAuthService
{
    private string $clientId;
    private string $clientSecret;
    private string $redirectUrl;

    public function __construct()
    {
        $this->clientId     = config('services.google.client_id');
        $this->clientSecret = config('services.google.client_secret');
        $this->redirectUrl  = config('services.google.redirect');
    }

    public function getAuthUrl(): string
    {
        $params = http_build_query([
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUrl,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'access_type'   => 'online',
        ]);
        return 'https://accounts.google.com/o/oauth2/v2/auth?' . $params;
    }

    public function getUserFromCode(string $code): ?array
    {
        // Exchange code for token
        $tokenRes = Http::withoutVerifying()->post('https://oauth2.googleapis.com/token', [
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUrl,
            'grant_type'    => 'authorization_code',
        ]);

        if (!$tokenRes->successful()) return null;

        $accessToken = $tokenRes->json('access_token');

        // Get user info
        $userRes = Http::withoutVerifying()
            ->withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if (!$userRes->successful()) return null;

        return $userRes->json();
    }
}
