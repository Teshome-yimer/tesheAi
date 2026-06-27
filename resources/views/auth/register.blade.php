@extends('layouts.app')
@section('title', 'ተመዝገቡ / Register')
@push('styles')
<style>
.auth-wrap { min-height:calc(100vh - 140px); display:flex; align-items:center; justify-content:center; padding:40px 24px; }
.auth-card { background:var(--bg2); border:1px solid var(--border); border-radius:20px; padding:48px; width:100%; max-width:480px; }
.auth-logo { text-align:center; margin-bottom:32px; }
.auth-logo .logo { font-size:2.5rem; font-weight:900; background:linear-gradient(135deg,var(--indigo),var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
</style>
@endpush
@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo"><div class="logo">🎓 EduPlatform</div></div>
        <h1 style="font-size:1.6rem;font-weight:800;margin-bottom:6px;">አካውንት ፍጠሩ / Create Account</h1>
        <p style="color:var(--muted);font-size:0.9rem;margin-bottom:32px;">ዛሬ ጀምሩ — ነፃ ምዝገባ / Start learning today</p>

        @if($errors->any())
            <div class="flash flash-error">{{ $errors->first() }}</div>
        @endif

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
                    <label class="form-label">የይለፍ ቃል / Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="Min 8 chars" required>
                </div>
                <div class="form-group">
                    <label class="form-label">አረጋግጥ / Confirm *</label>
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
