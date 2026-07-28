@extends('layouts.app')
@section('title', 'ተመዝገቡ / Register')
@push('styles')
<style>
.auth-wrap { min-height:calc(100vh - 140px); display:flex; align-items:center; justify-content:center; padding:40px 24px; }
.auth-card { background:var(--bg2); border:1px solid var(--border); border-radius:20px; padding:48px; width:100%; max-width:480px; }
.social-btn { display:flex; align-items:center; justify-content:center; gap:12px; width:100%; padding:13px; border-radius:10px; font-weight:600; font-size:0.95rem; cursor:pointer; border:1px solid var(--border); background:var(--bg3); color:var(--text); text-decoration:none; transition:.2s; margin-bottom:12px; }
.social-btn:hover { transform:translateY(-2px); }
.social-btn.google:hover { border-color:#ea4335; background:rgba(234,67,53,.08); color:var(--text); }
.social-btn.github:hover { border-color:#fff; background:rgba(255,255,255,.08); color:var(--text); }
.social-btn svg { width:22px; height:22px; flex-shrink:0; }
.divider { display:flex; align-items:center; gap:12px; margin:20px 0; }
.divider::before,.divider::after { content:''; flex:1; height:1px; background:var(--border); }
.divider span { color:var(--muted); font-size:0.8rem; white-space:nowrap; }
</style>
@endpush
@section('content')
<div class="auth-wrap">
<div class="auth-card">
    <div style="text-align:center;margin-bottom:28px;">
        <div style="font-size:2.5rem;font-weight:900;background:linear-gradient(135deg,var(--indigo),var(--cyan));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">🎓 EduPlatform</div>
    </div>
    <h1 style="font-size:1.6rem;font-weight:800;margin-bottom:6px;">አካውንት ፍጠሩ / Create Account</h1>
    <p style="color:var(--muted);font-size:0.9rem;margin-bottom:28px;">ዛሬ ጀምሩ — ነፃ ምዝገባ / Start learning today</p>

    @if($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
    @endif

    {{-- Social Buttons --}}
    <a href="{{ route('auth.google') }}" class="social-btn google">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Google ጋር ተመዝገቡ / Sign up with Google
    </a>

    <a href="{{ route('auth.github') }}" class="social-btn github">
        <svg viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
        </svg>
        GitHub ጋር ተመዝገቡ / Sign up with GitHub
    </a>

    <div class="divider"><span>ወይም email ተጠቀም / or use email</span></div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">ሙሉ ስም / Full Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="አበበ ቢቀለ" required>
        </div>
        <div class="form-group">
            <label class="form-label">ኢሜይል / Email *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required>
        </div>
        <div class="form-group">
            <label class="form-label">ስልክ ቁጥር / Phone *</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+251912345678" required>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label class="form-label">የይለፍ ቃል *</label>
                <input type="password" name="password" class="form-control" placeholder="Min 8 chars" required>
            </div>
            <div class="form-group">
                <label class="form-label">አረጋግጥ *</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat" required>
            </div>
        </div>
        <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;padding:14px;font-size:1rem;margin-top:8px;">🚀 ተመዝገቡ / Create Account</button>
    </form>

    <p style="text-align:center;color:var(--muted);font-size:0.9rem;margin-top:24px;">
        አካውንት አለዎት? <a href="{{ route('login') }}" style="color:var(--indigo);font-weight:600;">ግባ / Login</a>
    </p>
</div>
</div>
@endsection
