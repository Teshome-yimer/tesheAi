@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
<div class="auth-wrap">
<div class="auth-card">
    <h1 style="font-size:1.3rem;font-weight:800;margin-bottom:8px;">Reset your password</h1>
    <p style="color:var(--muted);margin-bottom:18px;">Enter your email and we will send a password reset link.</p>

    @if(session('status'))
        <div class="flash" style="margin-bottom:12px;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}" autofocus>
        </div>
        <button type="submit" class="btn btn-cyan" style="width:100%;">Send reset link</button>
    </form>

    <p style="text-align:center;color:var(--muted);margin-top:12px;">
        Remembered? <a href="{{ route('login') }}" style="color:var(--indigo);font-weight:600;">Sign in</a>
    </p>
</div>
</div>
@endsection
