<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 🔐 No hardcoded credentials — admin login is checked ONLY against the
     * database (the single account with role = admin). Change your email and
     * password anytime from Admin → Students; nobody else knows them.
     */
    public function showLoginForm()
    {
        // Already signed in as admin? Go straight to dashboard.
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $email = strtolower(trim($request->email));

        // Check against the admin account in the database (editable in Admin → Students)
        $user = User::whereRaw('LOWER(email) = ?', [$email])->where('role', 'admin')->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withErrors(['email' => 'ኢሜይል ወይም የይለፍ ቃሉ ትክክል አይደለም / Invalid admin credentials.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
