<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // ── GOOGLE ─────────────────────────────────────────────

    public function googleRedirect(GoogleAuthService $google)
    {
        return redirect($google->getAuthUrl());
    }

    public function googleCallback(Request $request, GoogleAuthService $google)
    {
        if ($request->has('error') || !$request->has('code')) {
            return redirect()->route('login')->with('error', 'Google login cancelled.');
        }

        $googleUser = $google->getUserFromCode($request->code);

        if (!$googleUser || empty($googleUser['email'])) {
            return redirect()->route('login')->with('error', 'Could not get user info from Google.');
        }

        $user = $this->findOrCreateUser([
            'name'     => $googleUser['name'] ?? $googleUser['email'],
            'email'    => $googleUser['email'],
            'avatar'   => $googleUser['picture'] ?? null,
            'provider' => 'google',
        ]);

        Auth::login($user, true);
        return $this->redirectAfterLogin($user);
    }

    // ── GITHUB ─────────────────────────────────────────────

    public function githubRedirect()
    {
        $params = http_build_query([
            'client_id' => config('services.github.client_id'),
            'redirect_uri' => config('services.github.redirect'),
            'scope'     => 'user:email',
        ]);
        return redirect('https://github.com/login/oauth/authorize?' . $params);
    }

    public function githubCallback(Request $request)
    {
        if ($request->has('error') || !$request->has('code')) {
            return redirect()->route('login')->with('error', 'GitHub login cancelled.');
        }

        // Exchange code for token
        $tokenRes = Http::withoutVerifying()->post('https://github.com/login/oauth/access_token', [
            'client_id'     => config('services.github.client_id'),
            'client_secret' => config('services.github.client_secret'),
            'code'          => $request->code,
            'redirect_uri'  => config('services.github.redirect'),
        ])->withHeaders(['Accept' => 'application/json']);

        $accessToken = null;
        // Github returns form-encoded by default
        $body = $tokenRes->body();
        parse_str($body, $parsed);
        $accessToken = $parsed['access_token'] ?? $tokenRes->json('access_token');

        if (!$accessToken) {
            return redirect()->route('login')->with('error', 'GitHub authentication failed.');
        }

        // Get user
        $userRes = Http::withoutVerifying()
            ->withToken($accessToken)
            ->withHeaders(['Accept' => 'application/vnd.github+json'])
            ->get('https://api.github.com/user');

        $githubUser = $userRes->json();

        // Get email if not public
        $email = $githubUser['email'] ?? null;
        if (!$email) {
            $emails = Http::withoutVerifying()
                ->withToken($accessToken)
                ->get('https://api.github.com/user/emails')
                ->json();
            foreach ($emails as $e) {
                if ($e['primary'] && $e['verified']) {
                    $email = $e['email'];
                    break;
                }
            }
        }

        if (!$email) {
            return redirect()->route('login')->with('error', 'Could not get email from GitHub.');
        }

        $user = $this->findOrCreateUser([
            'name'     => $githubUser['name'] ?? $githubUser['login'],
            'email'    => $email,
            'provider' => 'github',
        ]);

        Auth::login($user, true);
        return $this->redirectAfterLogin($user);
    }

    // ── Helpers ─────────────────────────────────────────────

    private function findOrCreateUser(array $data): User
    {
        return User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name'     => $data['name'],
                'password' => bcrypt(Str::random(32)),
                'role'     => 'student',
            ]
        );
    }

    private function redirectAfterLogin(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect()->intended(route('student.dashboard'));
    }
}
