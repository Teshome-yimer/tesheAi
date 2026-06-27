<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f;
            --bg2: #13131a;
            --bg3: #1a1a24;
            --border: #2a2a3a;
            --indigo: #6366f1;
            --cyan: #22d3ee;
            --text: #e2e8f0;
            --muted: #64748b;
            --success: #10b981;
            --danger: #ef4444;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; min-height: 100vh; }
        a { color: var(--cyan); text-decoration: none; }
        a:hover { color: var(--indigo); }

        /* Navbar */
        .navbar {
            background: rgba(10,10,15,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
            position: sticky; top: 0; z-index: 100;
        }
        .nav-inner { max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; }
        .nav-logo { font-size: 1.4rem; font-weight: 800; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .nav-links { display: flex; gap: 24px; align-items: center; }
        .nav-links a { color: var(--muted); font-size: 0.9rem; font-weight: 500; transition: color .2s; }
        .nav-links a:hover { color: var(--text); }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, var(--indigo), #8b5cf6); color: #fff; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(99,102,241,.4); color: #fff; }
        .btn-secondary { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-secondary:hover { border-color: var(--indigo); color: var(--indigo); }
        .btn-cyan { background: linear-gradient(135deg, var(--cyan), #0891b2); color: #000; font-weight: 700; }
        .btn-cyan:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(34,211,238,.4); color: #000; }
        .btn-sm { padding: 6px 14px; font-size: 0.8rem; }
        .btn-danger { background: var(--danger); color: #fff; }

        /* Flash messages */
        .flash { padding: 14px 20px; border-radius: 8px; margin: 16px 0; font-weight: 500; }
        .flash-success { background: rgba(16,185,129,.15); border: 1px solid var(--success); color: var(--success); }
        .flash-error { background: rgba(239,68,68,.15); border: 1px solid var(--danger); color: var(--danger); }
        .flash-info { background: rgba(99,102,241,.15); border: 1px solid var(--indigo); color: var(--indigo); }

        /* Cards */
        .card { background: var(--bg2); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .card:hover { border-color: var(--indigo); }

        /* Container */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: 500; color: var(--muted); }
        .form-control { width: 100%; background: var(--bg3); border: 1px solid var(--border); color: var(--text); padding: 12px 16px; border-radius: 8px; font-size: 0.95rem; outline: none; transition: border-color .2s; }
        .form-control:focus { border-color: var(--indigo); }
        .form-control::placeholder { color: var(--muted); }
        .invalid-feedback { color: var(--danger); font-size: 0.8rem; margin-top: 4px; }

        /* Badges */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-indigo { background: rgba(99,102,241,.2); color: var(--indigo); }
        .badge-cyan { background: rgba(34,211,238,.2); color: var(--cyan); }
        .badge-success { background: rgba(16,185,129,.2); color: var(--success); }
        .badge-danger { background: rgba(239,68,68,.2); color: var(--danger); }

        /* Hamburger */
        .hamburger { display: none; background: none; border: none; cursor: pointer; flex-direction: column; gap: 5px; }
        .hamburger span { display: block; width: 24px; height: 2px; background: var(--text); }
        @media (max-width: 768px) {
            .hamburger { display: flex; }
            .nav-links { display: none; position: absolute; top: 65px; left: 0; right: 0; background: var(--bg2); border-bottom: 1px solid var(--border); flex-direction: column; padding: 20px; gap: 16px; }
            .nav-links.open { display: flex; }
        }

        /* Progress bar */
        .progress-bar { background: var(--bg3); border-radius: 99px; height: 6px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, var(--indigo), var(--cyan)); border-radius: 99px; transition: width .4s ease; }

        /* Table */
        .table { width: 100%; border-collapse: collapse; }
        .table th { background: var(--bg3); color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: .05em; padding: 12px 16px; text-align: left; }
        .table td { padding: 14px 16px; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
        .table tr:last-child td { border-bottom: none; }
        .table tbody tr:hover { background: var(--bg3); }

        /* Footer */
        footer { background: var(--bg2); border-top: 1px solid var(--border); padding: 40px 0; margin-top: 80px; text-align: center; color: var(--muted); }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">🎓 EduPlatform</a>
        <button class="hamburger" onclick="this.nextElementSibling.classList.toggle('open')">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-links">
            <a href="/">መነሻ / Home</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
                @else
                    <a href="{{ route('student.dashboard') }}">Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">ውጣ / Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">ግባ / Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">ተመዝገብ / Register</a>
            @endauth
        </div>
    </div>
</nav>

<main>
    <div class="container" style="padding-top:20px;">
        @if(session('success'))
            <div class="flash flash-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">❌ {{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="flash flash-info">ℹ️ {{ session('info') }}</div>
        @endif
    </div>
    @yield('content')
</main>

<footer>
    <div class="container">
        <p style="font-size:0.9rem;">© {{ date('Y') }} EduPlatform. All rights reserved. | Made with ❤️ for Ethiopian learners</p>
    </div>
</footer>
@stack('scripts')
</body>
</html>
