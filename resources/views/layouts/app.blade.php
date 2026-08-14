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
        html, body { 
            background: var(--bg); 
            color: var(--text); 
            font-family: 'Inter', sans-serif; 
            min-height: 100vh;
            width: 100%;
        }

        a { color: var(--cyan); text-decoration: none; }
        a:hover { color: var(--indigo); }

        /* Navbar Header */
        .navbar {
            background: #0a0a0f;
            border-bottom: 1px solid var(--border);
            position: sticky; 
            top: 0; 
            z-index: 1000;
        }
        .nav-inner { 
            max-width: 1280px; 
            margin: 0 auto; 
            padding: 10px 20px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .nav-logo { font-size: 1.35rem; font-weight: 800; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Nav menu Desktop */
        .nav-menu { display: flex; align-items: center; gap: 10px; }
        .nav-item { position: relative; }
        .nav-item > .nav-top-link { 
            display: flex; 
            align-items: center; 
            gap: 5px; 
            padding: 10px 14px; 
            border-radius: 8px; 
            color: var(--text); 
            font-size: 0.9rem; 
            font-weight: 600; 
            cursor: pointer; 
            background: none; 
            border: none; 
            font-family: inherit; 
            width: 100%;
            text-align: left;
        }
        .nav-item > .nav-top-link:hover { background: var(--bg3); }
        .nav-caret { font-size: 0.6rem; color: var(--muted); }
        
        /* Dropdowns */
        .dropdown-menu { display: none; position: absolute; top: 100%; left: 0; min-width: 240px; background: var(--bg2); border: 1px solid var(--border); border-radius: 12px; padding: 8px; box-shadow: 0 16px 40px rgba(0,0,0,.5); z-index: 200; }
        .nav-item.open .dropdown-menu { display: block !important; }
        .dropdown-menu a { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; color: var(--text); font-size: 0.875rem; font-weight: 500; }
        .dropdown-menu a:hover { background: rgba(99,102,241,.12); color: var(--cyan); }
        .dropdown-menu .dd-label { padding: 8px 14px 4px; font-size: 0.68rem; text-transform: uppercase; color: var(--muted); font-weight: 700; }
        .dropdown-menu .dd-divider { height: 1px; background: var(--border); margin: 6px 8px; }

        /* Mega panel */
        .mega-panel { display: none; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); width: min(760px, 92vw); background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 20px 60px rgba(0,0,0,.6); z-index: 200; }
        .nav-item.open .mega-panel { display: block !important; }
        .mega-title { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 16px; }
        .mega-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; }
        .mega-card { border: 1px solid var(--border); border-radius: 12px; padding: 20px 16px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 8px; background: var(--bg); }
        .mega-card .mc-icon { font-size: 1.8rem; }
        .mega-card h4 { font-size: 0.95rem; font-weight: 700; color: var(--text); }
        .mega-card p { font-size: 0.76rem; color: var(--muted); flex: 1; }

        .nav-actions { display: flex; align-items: center; gap: 12px; }
        .nav-actions .nav-plain-link { color: var(--muted); font-size: 0.875rem; font-weight: 600; }
        
        /* Buttons */
        .subnav { background: var(--bg2); border-bottom: 1px solid var(--border); }
        .subnav-inner { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 4px; overflow-x: auto; }
        .subnav-inner a { color: var(--muted); font-size: 0.8rem; font-weight: 600; text-transform: uppercase; padding: 11px 14px; white-space: nowrap; }
        .subnav-inner a:hover { color: var(--cyan); }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 22px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; text-decoration: none; }
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
        .hamburger { display: none; background: none; border: none; cursor: pointer; flex-direction: column; gap: 5px; padding: 8px; }
        .hamburger span { display: block; width: 25px; height: 3px; background: var(--text); border-radius: 2px; }

        /* =========================================================
           SIMPLE & CLEAN MOBILE MENU (100% WORKING - NO OVERLAY)
           ========================================================= */
        @media (max-width: 900px) {
            .hamburger { display: flex !important; }

            .nav-menu { 
                display: none; /* በ default የተሸሸገ ነው */
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding-top: 15px;
                padding-bottom: 15px;
                border-top: 1px solid var(--border);
                margin-top: 10px;
            }
            
            .nav-menu.show { 
                display: flex !important; /* ሲነካ በግልጽ ይወጣል */
            }

            .dropdown-menu, .mega-panel { 
                position: static; 
                transform: none; 
                width: 100%; 
                box-shadow: none; 
                background: var(--bg3); 
                border: 1px solid var(--border); 
                border-radius: 8px; 
                margin-top: 5px; 
                padding: 10px; 
            }
            
            .nav-item > .nav-top-link { 
                background: var(--bg2); 
                border: 1px solid var(--border);
                justify-content: space-between;
            }

            .nav-actions { 
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px solid var(--border);
            }

            .nav-actions a, .nav-actions button {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }

        footer { background: var(--bg2); border-top: 1px solid var(--border); padding: 40px 0; margin-top: 80px; text-align: center; color: var(--muted); }
    </style>
    
    @stack('styles')
</head>
<body>
@php $navCourses = \App\Models\Course::where('is_published', true)->orderBy('title')->take(10)->get(); @endphp

<nav class="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">🎓 EduPlatform</a>

        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle Navigation">
            <span></span>
            <span></span>
            <span></span>
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

            {{-- Actions / Authentication Buttons --}}
            <div class="nav-actions">
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
                    <form method="POST" action="{{ route('logout') }}" style="width:100%;">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="width:100%;">Logout</button>
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
</footer>

@stack('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var hamburgerBtn = document.getElementById('hamburgerBtn');
    var navMenu = document.getElementById('navMenu');

    // 1. Hamburger Toggle (ለመክፈት እና ለመዝጋት)
    if (hamburgerBtn && navMenu) {
        hamburgerBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            navMenu.classList.toggle('show');
        });
    }

    // 2. Sub-menu Toggles (ትምህርቶች፣ መርጃዎች...)
    var dropdownBtns = document.querySelectorAll('[data-dd]');
    dropdownBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            var item = btn.closest('.nav-item');
            
            // ሌሎቹን መዝጋት
            document.querySelectorAll('.nav-item.open').forEach(function(other) {
                if (other !== item) other.classList.remove('open');
            });

            item.classList.toggle('open');
        });
    });
});
</script>
</body>
</html>
