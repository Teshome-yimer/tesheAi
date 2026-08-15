@extends('layouts.app')
@section('title', 'ግባ | Login')

@push('styles')
<style>
.auth-wrap { min-height: calc(100vh - 140px); display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
.auth-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 20px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
.auth-logo { text-align: center; margin-bottom: 24px; }
.auth-logo .logo { font-size: 2.2rem; font-weight: 900; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

.auth-header { text-align: center; margin-bottom: 24px; }
.auth-header h1 { font-size: 1.5rem; font-weight: 800; margin-bottom: 4px; }
.auth-header p { color: var(--muted); font-size: 0.88rem; }

.social-btn { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 11px; border-radius: 10px; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: 1px solid var(--border); background: var(--bg3); color: var(--text); text-decoration: none; transition: .2s; margin-bottom: 10px; }
.social-btn:hover { transform: translateY(-2px); }
.social-btn.google:hover { border-color: #ea4335; background: rgba(234,67,53,.08); }
.social-btn.github:hover { border-color: #fff; background: rgba(255,255,255,.08); }
.social-btn svg { width: 20px; height: 20px; flex-shrink: 0; }

.divider { display: flex; align-items: center; gap: 12px; margin: 18px 0; }
.divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
.divider span { color: var(--muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; }

.form-group { margin-bottom: 16px; }
.form-label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--text); }
.form-control { width: 100%; padding: 12px 14px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 0.9rem; outline: none; transition: border-color 0.2s; }
.form-control:focus { border-color: var(--cyan); }

.auth-footer { text-align: center; color: var(--muted); font-size: 0.85rem; margin-top: 20px; }
.auth-footer a { color: var(--cyan); font-weight: 600; text-decoration: none; }
.auth-footer a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo">🎓 Tesheai Academy </div>
        </div>

        <div class="auth-header">
           <h1>እንኳን ደህና መጡ <span style="font-size: 0.7em; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">tesheai</span></h1>
            <p>Welcome Back • Sign in to continue</p>
        </div>

        @if($errors->any())
            <div class="flash flash-error" style="margin-bottom: 16px; padding: 10px; border-radius: 8px; font-size: 0.85rem;">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Social Logins --}}
        <a href="{{ route('auth.google') }}" class="social-btn google">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Google
        </a>

        <a href="{{ route('auth.github') }}" class="social-btn github">
            <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
            </svg>
            GitHub
        </a>

        <div class="divider"><span>ወይም / OR</span></div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">ኢሜይል / Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
            </div>
            
            <div class="form-group">
                <label class="form-label">የይለፍ ቃል / Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; font-size:0.82rem;">
                <label style="display:flex; align-items:center; gap:6px; cursor:pointer; color:var(--muted);">
                    <input type="checkbox" name="remember" id="remember" style="accent-color:var(--indigo);">
                    ያስታውሰኝ
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color:var(--cyan); text-decoration:none;">ረስተዋል?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-cyan" style="width:100%; justify-content:center; padding:12px; font-size:0.95rem; font-weight:700;">
                🔑 ግባ / Sign In
            </button>
        </form>

        <div class="auth-footer">
            መለያ የለዎትም? <a href="{{ route('register') }}">ተመዝገቡ / Register</a>
        </div>
    </div>
</div>
@endsection
