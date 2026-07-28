<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Teshome Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0a0f; --card:#13131a; --input:#1e2130; --border:#2a2a3a; --text:#e2e8f0; --muted:#64748b; --orange:#f5a623; --danger:#ef4444; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
        .login-card { background:var(--card); border:1px solid var(--border); border-radius:12px; padding:40px 44px; width:100%; max-width:560px; }
        .brand { text-align:center; font-size:1.5rem; font-weight:800; margin-bottom:10px; }
        .headline { text-align:center; font-size:2rem; font-weight:800; margin-bottom:32px; }
        .form-group { margin-bottom:22px; }
        .form-label { display:block; font-size:0.95rem; font-weight:600; margin-bottom:8px; }
        .form-label .req { color:var(--danger); }
        .form-control { width:100%; background:var(--input); border:1px solid var(--border); border-radius:8px; padding:13px 14px; color:var(--text); font-size:0.95rem; font-family:inherit; outline:none; transition:border .15s, box-shadow .15s; }
        .form-control:focus { border-color:var(--orange); box-shadow:0 0 0 2px rgba(245,166,35,.25); }
        .pw-wrap { position:relative; display:flex; }
        .pw-wrap .form-control { padding-right:56px; }
        .pw-toggle { position:absolute; right:0; top:0; bottom:0; width:52px; background:#2a2f42; border:1px solid var(--border); border-left:none; border-radius:0 8px 8px 0; color:var(--text); cursor:pointer; font-size:1rem; display:flex; align-items:center; justify-content:center; }
        .remember { display:flex; align-items:center; gap:10px; margin-bottom:26px; font-size:0.95rem; cursor:pointer; user-select:none; }
        .remember input { width:18px; height:18px; accent-color:var(--orange); cursor:pointer; }
        .btn-signin { width:100%; background:var(--orange); color:#1a1a1a; border:none; border-radius:8px; padding:14px; font-size:1rem; font-weight:700; font-family:inherit; cursor:pointer; transition:filter .15s; }
        .btn-signin:hover { filter:brightness(1.08); }
        .error-box { background:rgba(239,68,68,.12); border:1px solid rgba(239,68,68,.4); color:#fca5a5; border-radius:8px; padding:12px 14px; font-size:0.85rem; margin-bottom:20px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">Teshome Admin</div>
        <div class="headline">Sign in</div>

        @if($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email address<span class="req">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Password<span class="req">*</span></label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button type="button" class="pw-toggle" onclick="togglePw()" aria-label="Show password">👁</button>
                </div>
            </div>
            <label class="remember">
                <input type="checkbox" name="remember" value="1">
                Remember me
            </label>
            <button type="submit" class="btn-signin">Sign in</button>
        </form>
    </div>

    <script>
    function togglePw() {
        const pw = document.getElementById('password');
        pw.type = pw.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>
</html>
