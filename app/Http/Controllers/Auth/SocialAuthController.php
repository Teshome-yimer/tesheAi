<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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

    public function githubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();
            $email = $githubUser->getEmail() ?? $githubUser->getId() . '@github.local';

            // Find existing user by email or github_id
            $user = User::where('email', $email)
                        ->orWhere('github_id', $githubUser->getId())
                        ->first();

            if ($user) {
                // Update existing user with GitHub info if missing
                $user->update([
                    'github_id' => $githubUser->getId(),
                    'github_token' => $githubUser->token,
                    'avatar' => $user->avatar ?? $githubUser->getAvatar(),
                ]);
            } else {
                // Create brand new user
                $user = User::create([
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'email' => $email,
                    'github_id' => $githubUser->getId(),
                    'github_token' => $githubUser->token,
                    'avatar' => $githubUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)),
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/');
        } catch (\Throwable $e) {
            \Log::error('GitHub Auth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'GitHub login failed: ' . $e->getMessage());
        }
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
