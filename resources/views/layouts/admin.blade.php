<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --bg:#0a0a0f; --bg2:#13131a; --bg3:#1a1a24; --border:#2a2a3a; --indigo:#6366f1; --cyan:#22d3ee; --text:#e2e8f0; --muted:#64748b; --success:#10b981; --danger:#ef4444; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'Inter',sans-serif; display:flex; min-height:100vh; }
        a { color:var(--cyan); text-decoration:none; }
        .btn { display:inline-flex; align-items:center; gap:8px; padding:8px 18px; border-radius:8px; font-weight:600; font-size:0.85rem; cursor:pointer; border:none; transition:all .2s; }
        .btn-primary { background:linear-gradient(135deg,var(--indigo),#8b5cf6); color:#fff; }
        .btn-cyan { background:linear-gradient(135deg,var(--cyan),#0891b2); color:#000; font-weight:700; }
        .btn-danger { background:var(--danger); color:#fff; }
        .btn-secondary { background:var(--bg3); border:1px solid var(--border); color:var(--text); }
        .btn-sm { padding:5px 12px; font-size:0.78rem; }
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:600; }
        .badge-success { background:rgba(16,185,129,.2); color:var(--success); }
        .badge-danger { background:rgba(239,68,68,.2); color:var(--danger); }
        .badge-indigo { background:rgba(99,102,241,.2); color:var(--indigo); }
        .badge-muted { background:var(--bg3); color:var(--muted); }

        /* Sidebar */
        .admin-sidebar { width:240px; background:var(--bg2); border-right:1px solid var(--border); display:flex; flex-direction:column; padding:24px 0; position:sticky; top:0; height:100vh; overflow-y:auto; flex-shrink:0; }
        .sidebar-logo { padding:0 24px 24px; border-bottom:1px solid var(--border); margin-bottom:16px; }
        .sidebar-logo a { font-size:1.2rem; font-weight:800; background:linear-gradient(135deg,var(--indigo),var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .sidebar-logo p { font-size:0.75rem; color:var(--muted); margin-top:2px; }
        .nav-section { padding:0 12px 8px; font-size:0.7rem; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; margin-top:16px; }
        .admin-nav a { display:flex; align-items:center; gap:10px; padding:10px 16px; border-radius:8px; margin:2px 12px; color:var(--muted); font-size:0.875rem; font-weight:500; transition:.15s; }
        .admin-nav a:hover { background:rgba(99,102,241,.1); color:var(--text); }
        .admin-nav a.active { background:rgba(99,102,241,.15); color:var(--indigo); }
        .sidebar-bottom { margin-top:auto; padding:16px 24px; border-top:1px solid var(--border); }

        /* Main */
        .admin-main { flex:1; overflow-x:hidden; }
        .admin-topbar { background:var(--bg2); border-bottom:1px solid var(--border); padding:16px 28px; display:flex; align-items:center; justify-content:space-between; sticky; top:0; z-index:50; }
        .admin-content { padding:32px 28px; max-width:1200px; }
        .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; }
        .page-title { font-size:1.5rem; font-weight:800; }

        /* Stats grid */
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; margin-bottom:32px; }
        .stat-box { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:24px; }
        .stat-box:hover { border-color:var(--indigo); }
        .stat-value { font-size:2rem; font-weight:800; background:linear-gradient(135deg,var(--indigo),var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .stat-label { color:var(--muted); font-size:0.8rem; margin-top:4px; }

        /* Table */
        .table-wrap { background:var(--bg2); border:1px solid var(--border); border-radius:12px; overflow:hidden; }
        .table { width:100%; border-collapse:collapse; }
        .table th { background:var(--bg3); color:var(--muted); font-size:0.75rem; text-transform:uppercase; letter-spacing:.05em; padding:12px 16px; text-align:left; }
        .table td { padding:13px 16px; border-bottom:1px solid var(--border); font-size:0.875rem; }
        .table tr:last-child td { border-bottom:none; }
        .table tbody tr:hover { background:var(--bg3); }

        /* Form */
        .form-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:28px; }
        .form-group { margin-bottom:20px; }
        .form-label { display:block; margin-bottom:6px; font-size:0.8rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.03em; }
        .form-control { width:100%; background:var(--bg3); border:1px solid var(--border); color:var(--text); padding:11px 14px; border-radius:8px; font-size:0.9rem; outline:none; transition:border-color .2s; }
        .form-control:focus { border-color:var(--indigo); }
        .form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .flash { padding:12px 18px; border-radius:8px; margin-bottom:20px; font-size:0.875rem; font-weight:500; }
        .flash-success { background:rgba(16,185,129,.15); border:1px solid var(--success); color:var(--success); }
        .flash-error { background:rgba(239,68,68,.15); border:1px solid var(--danger); color:var(--danger); }
    </style>
    @stack('styles')
</head>
<body>
<aside class="admin-sidebar">
    <div class="sidebar-logo">
        <a href="/admin/dashboard">🎓 EduPlatform</a>
        <p>Admin Panel</p>
    </div>
    <nav class="admin-nav">
        <div class="nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>

        <div class="nav-section">Content</div>
        <a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses*') ? 'active' : '' }}">📚 Courses</a>

        <div class="nav-section">Business</div>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">💰 Orders</a>
        <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">🏷️ Coupons</a>

        <div class="nav-section">Users</div>
        <a href="{{ route('admin.students.index') }}" class="{{ request()->routeIs('admin.students*') ? 'active' : '' }}">👥 Students</a>
        <a href="{{ route('admin.students.enroll-form') }}">➕ Manual Enroll</a>
    </nav>
    <div class="sidebar-bottom">
        <div style="font-size:0.8rem;font-weight:600;margin-bottom:4px;">{{ auth()->user()->name }}</div>
        <div style="color:var(--muted);font-size:0.75rem;margin-bottom:12px;">{{ auth()->user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;">Logout</button>
        </form>
    </div>
</aside>

<div class="admin-main">
    <div class="admin-topbar">
        <h1 style="font-size:1rem;font-weight:700;">@yield('title', 'Dashboard')</h1>
        <div style="display:flex;align-items:center;gap:16px;">
            <span style="color:var(--muted);font-size:0.85rem;">{{ now()->format('M d, Y') }}</span>
            <a href="/" style="color:var(--muted);font-size:0.85rem;">← View Site</a>
        </div>
    </div>
    <div class="admin-content">
        @if(session('success'))
            <div class="flash flash-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">❌ {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>
@stack('scripts')
</body>
</html>
