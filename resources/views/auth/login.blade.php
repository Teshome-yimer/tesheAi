@extends('layouts.app')
@section('title', 'ግባ / Login')
@push('styles')
<style>
.auth-wrap { min-height: calc(100vh - 140px); display:flex; align-items:center; justify-content:center; padding:40px 24px; }
.auth-card { background:var(--bg2); border:1px solid var(--border); border-radius:20px; padding:48px; width:100%; max-width:440px; }
.auth-logo { text-align:center; margin-bottom:32px; }
.auth-logo .logo { font-size:2.5rem; font-weight:900; background:linear-gradient(135deg,var(--indigo),var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.auth-title { font-size:1.6rem; font-weight:800; margin-bottom:6px; }
.auth-sub { color:var(--muted); font-size:0.9rem; margin-bottom:32px; }
.divider { display:flex; align-items:center; gap:12px; margin:24px 0; }
.divider::before, .divider::after { content:''; flex:1; height:1px; background:var(--border); }
.divider span { color:var(--muted); font-size:0.8rem; }
</style>
@endpush
@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo">🎓 EduPlatform</div>
        </div>
        <h1 class="auth-title">እንኳን ደህና መጡ / Welcome Back</h1>
        <p class="auth-sub">መለያዎን ያስገቡ / Sign in to your account</p>

        @if($errors->any())
            <div class="flash flash-error">{{ $errors->first() }}</div>
        @endif

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
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
                <input type="checkbox" name="remember" id="remember" style="accent-color:var(--indigo);">
                <label for="remember" style="font-size:0.85rem;color:var(--muted);">ያስታውሰኝ / Remember me</label>
            </div>
            <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;padding:14px;font-size:1rem;">ግባ / Sign In</button>
        </form>

        <div class="divider"><span>or</span></div>
        <p style="text-align:center;color:var(--muted);font-size:0.9rem;">
            አካውንት የለዎትም? <a href="{{ route('register') }}" style="color:var(--indigo);font-weight:600;">ተመዝገቡ / Register</a>
        </p>
    </div>
</div>
@endsection
