@extends('layouts.app')
@section('title', 'Set New Password')
@section('content')
<div class="auth-wrap">
<div class="auth-card">
    <h1 style="font-size:1.3rem;font-weight:800;margin-bottom:8px;">Choose a new password</h1>

    @if($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="{{ $email ?? old('email') }}">
        </div>

        <div class="form-group">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-cyan" style="width:100%;">Reset password</button>
    </form>

    <p style="text-align:center;color:var(--muted);margin-top:12px;">
        Back to <a href="{{ route('login') }}" style="color:var(--indigo);font-weight:600;">Sign in</a>
    </p>
</div>
</div>
@endsection
