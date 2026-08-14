<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NL0B9Y2V3T"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-NL0B9Y2V3T');
    </script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5100957100493180" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
        html, body { 
            background: var(--bg); 
            color: var(--text); 
            font-family: 'Inter', sans-serif; 
            min-height: 100vh;
            width: 100%;
        }
        
        /* body overflow guard for mobile */
        body.menu-open {
            overflow: hidden !important;
        }

        a { color: var(--cyan); text-decoration: none; }
        a:hover { color: var(--indigo); }

        /* Navbar Header */
        .navbar {
            background: rgba(10,10,15,0.98);
            border-bottom: 1px solid var(--border);
            position: sticky; 
            top: 0; 
            z-index: 1000;
        }
        .nav-inner { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 6px; min-height: 60px; }
        .nav-logo { font-size: 1.35rem; font-weight: 800; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-right: 10px; flex-shrink: 0; }

        /* Nav items + dropdowns Desktop */
        .nav-menu { display: flex; align-items: center; gap: 2px; flex: 1; }
        .nav-utilities { display: flex; align-items: center; gap: 12px; margin-left: auto; flex-shrink: 0; }
        .nav-item { position: relative; width: 100%; }
        .nav-item > .nav-top-link { 
            display: flex; 
            align-items: center; 
            justify-content: space-between;
            gap: 5px; 
            padding: 12px 14px; 
            border-radius: 8px; 
            color: var(--text); 
            font-size: 0.9rem; 
            font-weight: 600; 
            cursor: pointer; 
            background: none; 
            border: none; 
            font-family: inherit; 
            transition: background .15s; 
            white-space: nowrap; 
            width: 100%; 
            text-align: left; 
        }
        .nav-item > .nav-top-link:hover, .nav-item.open > .nav-top-link { background: var(--bg3); color: var(--text); }
        .nav-caret { font-size: 0.6rem; color: var(--muted); transition: transform .15s; }
        .nav-item.open .nav-caret { transform: rotate(180deg); }
        
        .dropdown-menu { display: none; position: absolute; top: 100%; left: 0; min-width: 240px; background: var(--bg2); border: 1px solid var(--border); border-radius: 12px; padding: 8px; box-shadow: 0 16px 40px rgba(0,0,0,.5); z-index: 200; }
        .nav-item.open .dropdown-menu { display: block !important; }
        .dropdown-menu a { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; color: var(--text); font-size: 0.875rem; font-weight: 500; }
        .dropdown-menu a:hover { background: rgba(99,102,241,.12); color: var(--cyan); }
        .dropdown-menu .dd-label { padding: 8px 14px 4px; font-size: 0.68rem; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); font-weight: 700; }
        .dropdown-menu .dd-divider { height: 1px; background: var(--border); margin: 6px 8px; }

        /* Mega panel */
        .mega-panel { display: none; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); width: min(760px, 92vw); background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 20px 60px rgba(0,0,0,.6); z-index: 200; }
        .nav-item.open .mega-panel { display: block !important; }
        .mega-title { font-size: 0.72rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 16px; }
        .mega-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; }
        .mega-card { border: 1px solid var(--border); border-radius: 12px; padding: 20px 16px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 8px; transition: border-color .15s, transform .15s; background: var(--bg); }
        .mega-card:hover { border-color: var(--indigo); transform: translateY(-2px); }
        .mega-card .mc-icon { font-size: 1.8rem; }
        .mega-card h4 { font-size: 0.95rem; font-weight: 700; color: var(--text); }
        .mega-card p { font-size: 0.76rem; color: var(--muted); flex: 1; }

        .nav-actions { display: flex; align-items: center; gap: 16px; margin-left: 20px; flex-shrink: 0; }
        .nav-actions .nav-plain-link { color: var(--muted); font-size: 0.875rem; font-weight: 600; white-space: nowrap; }
        .nav-actions .nav-plain-link:hover { color: var(--text); }
        .mobile-menu-actions { display: none; }

        /* Mobile Backdrop Overlay */
        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9990 !important;
            pointer-events: none;
        }
        .mobile-menu-overlay.open {
            display: block !important;
            pointer-events: auto !important;
        }

        /* Buttons & Utility */
        .subnav { background: var(--bg2); border-bottom: 1px solid var(--border); }
        .subnav-inner { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 4px; overflow-x: auto; scrollbar-width: none; }
        .subnav-inner::-webkit-scrollbar { display: none; }
        .subnav-inner a { color: var(--muted); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; padding: 11px 14px; white-space: nowrap; border-bottom: 2px solid transparent; transition: color .15s, border-color .15s; }
        .subnav-inner a:hover { color: var(--cyan); border-bottom-color: var(--cyan); }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 22px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, var(--indigo), #8b5cf6); color: #fff; }
        .btn-secondary { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-cyan { background: linear-gradient(135deg, var(--cyan), #0891b2); color: #000; font-weight: 700; }
        .btn-sm { padding: 6px 14px; font-size: 0.8rem; }
        .btn-danger { background: var(--danger); color: #fff; }

        /* Flash & Container */
        .flash { padding: 14px 20px; border-radius: 8px; margin: 16px 0; font-weight: 500; }
        .flash-success { background: rgba(16,185,129,.15); border: 1px solid var(--success); color: var(--success); }
        .flash-error { background: rgba(239,68,68,.15); border: 1px solid var(--danger); color: var(--danger); }
        .flash-info { background: rgba(99,102,241,.15); border: 1px solid var(--indigo); color: var(--indigo); }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* Hamburger */
        .hamburger { display: none; background: none; border: none; cursor: pointer; flex-direction: column; gap: 5px; margin-left: auto; flex-shrink: 0; padding: 8px; z-index: 10001; }
        .hamburger span { display: block; width: 24px; height: 2px; background: var(--text); }

        /* =========================================================
           MOBILE DRAWER (ከፍተኛ ግልጽነት እና ንክኪ ጥበቃ የተደረገለት)
           ========================================================= */
        @media (max-width: 900px) {
            .nav-inner { position: relative; display: flex; align-items: center; justify-content: space-between; padding-top: 10px; padding-bottom: 10px; }
            .nav-logo { margin-right: 0; font-size: 1.15rem; }
            .nav-utilities { display: none; }
            .hamburger { display: flex !important; }

            .nav-menu { 
                display: flex !important;
                position: fixed !important; 
                top: 0 !important; 
                left: 0 !important; 
                height: 100vh !important;
                height: 100dvh !important; /* Mobile Screen standard */
                width: 80% !important; 
                max-width: 300px !important;
                background: #13131a !important; 
                border-right: 1px solid var(--border); 
                flex-direction: column; 
                align-items: stretch; 
                padding: 30px 18px 40px 18px;
                gap: 14px; 
                box-shadow: 10px 0 40px rgba(0,0,0,0.95); 
                z-index: 99999 !important; /* ማንኛውንም ኤለመንት ይበልጣል */
                pointer-events: none;
                transform: translateX(-100%);
                transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .nav-menu.open { 
                transform: translateX(0) !important; 
                pointer-events: auto !important;
            }

            /* ቁልፎቹ ከፊት እንዲሆኑ እና ንክኪን 100% እንዲቀበሉ ማድረግ */
            .nav-item, 
            .mobile-menu-actions, 
            .mobile-menu-actions a, 
            .mobile-menu-actions button,
            .dropdown-menu a {
                position: relative !important;
                z-index: 100000 !important;
                pointer-events: auto !important;
            }

            .dropdown-menu, .mega-panel { 
                position: static; 
                transform: none; 
                width: 100%; 
                min-width: 0; 
                box-shadow: none; 
                background: var(--bg3); 
                border: 1px solid var(--border); 
                border-radius: 10px; 
                margin-top: 6px; 
                padding: 10px; 
            }
            
            .nav-item > .nav-top-link { 
                width: 100%; 
                background: var(--bg3); 
                border-radius: 8px; 
            }
            
            .nav-actions { display: none !important; }
            
            .mobile-menu-actions { 
                display: flex !important; 
                flex-direction: column; 
                gap: 12px; 
                margin-top: auto; 
                padding-top: 20px; 
                border-top: 1px solid var(--border); 
                width: 100%;
            }

            .mobile-menu-actions a, 
            .mobile-menu-actions button { 
                width: 100% !important; 
                display: flex !important;
                justify-content: center; 
                align-items: center;
                text-align: center;
                padding: 12px 16px !important;
                font-size: 0.95rem !important;
                border-radius: 8px;
                box-sizing: border-box;
                font-weight: 700;
            }

            .subnav { display: block; overflow-x: auto; }
            .subnav-inner { gap: 0; }
            .subnav-inner a { font-size: 0.75rem; padding: 10px 12px; }
        }

        footer { background: var(--bg2); border-top: 1px solid var(--border); padding: 40px 0; margin-top: 80px; text-align: center; color: var(--muted); }
    </style>
    
    @stack('styles')
</head>
<body>
@php $navCourses = \App\Models\Course::where('is_published', true)->orderBy('title')->take(10)->get(); @endphp

<!-- Mobile Backdrop Overlay -->
<div class="mobile-menu-overlay" id="menuOverlay"></div>

<nav class="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">🎓 EduPlatform</a>

        <button class="hamburger" id="hamburgerBtn" aria-label="Menu" type="button">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-menu" id="navMenu">
            {{-- Courses dropdown --}}
            <div class="nav-item">
                <button type="button" class="nav-top-link" data-dd>ትምህርቶች / Courses <span class="nav-caret">▼</span></button>
                <div class="dropdown-menu">
                    <div class="dd-label">Premium Courses</div>
                    @forelse($navCourses as $navCourse)
                        <a href="{{ route('course.show', $navCourse) }}">📚 {{ $navCourse->title }}</a>
                    @empty
                        <a href="/#courses">📚 ኮርሶች በቅርቡ ይመጣሉ</a>
                    @endforelse
                    <div class="dd-divider"></div>
                    <a href="/#courses">🗂️ ሁሉንም ኮርሶች ይመልከቱ / Browse All</a>
                </div>
            </div>

            {{-- Resources dropdown --}}
            <div class="nav-item">
                <button type="button" class="nav-top-link" data-dd>መርጃዎች / Resources <span class="nav-caret">▼</span></button>
                <div class="dropdown-menu">
                    <div class="dd-label">Free for members</div>
                    <a href="{{ route('documents.index') }}">📄 ነጻ ሰነዶች / Free PDFs</a>
                    <a href="{{ route('quizzes.index') }}">📝 ፈተናዎች / Quizzes</a>
                    <div class="dd-divider"></div>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">🛠️ Admin Panel</a>
                        @else
                            <a href="{{ route('student.dashboard') }}">🎯 የእኔ ትምህርቶች / My Learning</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}">✨ ተመዝገብና በነጻ ተጠቀም</a>
                    @endauth
                </div>
            </div>

            {{-- Practice mega panel --}}
            <div class="nav-item">
                <button type="button" class="nav-top-link" data-dd>ልምምድ / Practice <span class="nav-caret">▼</span></button>
                <div class="mega-panel">
                    <div class="mega-title">EduPlatform Practice</div>
                    <div class="mega-grid">
                        <div class="mega-card">
                            <div class="mc-icon">📝</div>
                            <h4>Quizzes</h4>
                            <p>እውቀትዎን በ A–D ምርጫ ፈተናዎች ይፈትሹ</p>
                            <a href="{{ route('quizzes.index') }}" class="btn btn-primary btn-sm">Browse Quizzes</a>
                        </div>
                        <div class="mega-card">
                            <div class="mc-icon">📄</div>
                            <h4>Free PDFs</h4>
                            <p>ነጻ የትምህርት ሰነዶችን ያንብቡ እና ያውርዱ</p>
                            <a href="{{ route('documents.index') }}" class="btn btn-primary btn-sm">Browse PDFs</a>
                        </div>
                        <div class="mega-card">
                            <div class="mc-icon">📚</div>
                            <h4>Courses</h4>
                            <p>ሙሉ የቪዲዮ ኮርሶች በፕሪሚየም ጥራት</p>
                            <a href="/#courses" class="btn btn-primary btn-sm">Browse Courses</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Actions --}}
            <div class="mobile-menu-actions">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-secondary">🔑 Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-cyan">✨ Sign Up</a>
                @endguest
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Admin Dashboard</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">Student Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @endauth
            </div>
        </div>

        <div class="nav-utilities">
            <div class="nav-actions">
                @guest
                    <a href="{{ route('login') }}" class="nav-plain-link">🔑 Login</a>
                    <a href="{{ route('register') }}" class="btn btn-cyan btn-sm" style="border-radius: 20px;">✨Sign up</a>
                @endguest
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-plain-link" style="color:var(--indigo);">⚙️ Admin</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="nav-plain-link">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm"> Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Subnav --}}
<div class="subnav">
    <div class="subnav-inner">
        <a href="/">Home</a>
        <a href="{{ route('documents.index') }}">Free PDFs</a>
        <a href="{{ route('quizzes.index') }}">Quizzes</a>
        @auth
            @if(!auth()->user()->isAdmin())
                <a href="{{ route('student.dashboard') }}">My Learning</a>
            @endif
        @endauth
    </div>
</div>

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
    <div class="flex justify-center space-x-4 text-sm text-gray-400 mt-4 mb-2">
        <a href="{{ route('privacy') }}" class="hover:underline">Privacy Policy</a>
        <span>|</span>
        <a href="{{ route('terms') }}" class="hover:underline">Terms of Service</a>
        <span>|</span>
        <a href="{{ route('contact') }}" class="hover:underline">Contact Us</a>
    </div>
</footer>

@stack('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const navMenu = document.getElementById('navMenu');
    const menuOverlay = document.getElementById('menuOverlay');

    function openMobileMenu() {
        if (navMenu) navMenu.classList.add('open');
        if (menuOverlay) menuOverlay.classList.add('open');
        document.body.classList.add('menu-open');
    }

    function closeMobileMenu() {
        if (navMenu) navMenu.classList.remove('open');
        if (menuOverlay) menuOverlay.classList.remove('open');
        document.body.classList.remove('menu-open');
        document.querySelectorAll('.nav-item.open').forEach(function(item) {
            item.classList.remove('open');
        });
    }

    // 1. Hamburger Toggle (ለ Touch እና Click አሊያንስ)
    if (hamburgerBtn) {
        const toggleMenu = function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (navMenu && navMenu.classList.contains('open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        };
        hamburgerBtn.addEventListener('click', toggleMenu);
    }

    // 2. ከሜኑው ውጭ ጥቁሩ ቦታ ሲነካ ብቻ እንዲዘጋ ማድረግ
    if (menuOverlay) {
        menuOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileMenu();
        });
    }

    // 3. Drawer Menuው ውስጥ የሚደረግ ማንኛውም ንክኪ ገጹን እንዳይዘጋ ፍጹም መከላከል
    if (navMenu) {
        navMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        navMenu.addEventListener('touchstart', function(e) {
            e.stopPropagation();
        }, {passive: true});
    }

    // 4. Dropdown Toggles (ትምህርቶች/Courses, Resource ወዘተ...)
    document.querySelectorAll('[data-dd]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var item = btn.closest('.nav-item');
            var isOpen = item.classList.contains('open');

            document.querySelectorAll('.nav-item.open').forEach(function (o) {
                if (o !== item) o.classList.remove('open');
            });

            if (isOpen) {
                item.classList.remove('open');
            } else {
                item.classList.add('open');
            }
        });
    });

    // 5. ESC Key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });
});
</script>
</body>
</html>
