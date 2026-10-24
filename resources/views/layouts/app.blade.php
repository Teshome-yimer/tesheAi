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

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5100957100493180"
     crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===== የ SEO META TAGS (በዚህ ቦታ ይተካ/ይግባ) ===== -->
    <meta name="description" content="Tesheai Academy - የቴክኖሎጂ፣ የፕሮግራሚንግ እና የኮምፒዩተር ሳይንስ ኮርሶችን እና መጻሕፍትን በነጻ እና በቅናሽ የሚያገኙበት የኢትዮጵያውያን የትምህርት መድረክ።">
    <meta name="keywords" content="Khilx Academy,Tesheai, evangadi,honasmuhe,ethiocoder,5 million coder,Tesheai Academy, Teshe AI, Programming Courses Ethiopia, Computer Science Amharic, Web Development Amharic, የሶፍትዌር ትምህርት, የፕሮግራሚንግ ኮርስ">
    <meta name="author" content="Tesheai Academy">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags (ለ Facebook፣ Telegram እና WhatsApp Link Share ሲደረግ እንዲያምር) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Tesheai Academy - Educational Platform & Courses">
    <meta property="og:description" content="የቴክኖሎጂ፣ የፕሮግራሚንግ እና የኮምፒዩተር ሳይንስ ኮርሶችን በነጻ እና በቅናሽ የሚያገኙበት መድረክ።">
    <meta property="og:url" content="https://tesheai.com">
    <meta property="og:site_name" content="Tesheai Academy">
    <meta property="og:image" content="{{ asset('images/favicon-32x32.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Tesheai Academy - Educational Platform & Courses">
    <meta name="twitter:description" content="የቴክኖሎጂ፣ የፕሮግራሚንግ እና የኮምፒዩተር ሳይንስ ኮርሶችን በነጻ እና በቅናሽ የሚያገኙበት መድረክ።">
    <!-- ======================================================= -->

    <title>@yield('title', config('app.name', 'Tesheai Academy'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Favicon tags for Google and Browsers -->
    <!-- Canonical URL -->
    <link rel="canonical" href="https://tesheai.com{{ request()->getRequestUri() }}">
<link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('images/site.webmanifest') }}">
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
        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; min-height: 100vh; overflow-x: hidden; }
        a { color: var(--cyan); text-decoration: none; }
        a:hover { color: var(--indigo); }

        /* Navbar */
        .navbar {
            background: rgba(10,10,15,0.98);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-inner { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 6px; min-height: 60px; }
        .nav-logo { font-size: 1.35rem; font-weight: 800; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-right: 10px; flex-shrink: 0; }

        /* Nav items + dropdowns */
        .nav-menu { display: flex; align-items: center; gap: 2px; flex: 1; }
        .nav-utilities { display: flex; align-items: center; gap: 12px; margin-left: auto; flex-shrink: 0; }
        .nav-item { position: relative; }
        .nav-item > .nav-top-link { display: flex; align-items: center; gap: 5px; padding: 10px 14px; border-radius: 8px; color: var(--text); font-size: 0.9rem; font-weight: 600; cursor: pointer; background: none; border: none; font-family: inherit; transition: background .15s; white-space: nowrap; }
        .nav-item > .nav-top-link:hover, .nav-item.open > .nav-top-link { background: var(--bg3); color: var(--text); }
        .nav-caret { font-size: 0.6rem; color: var(--muted); transition: transform .15s; }
        .nav-item.open .nav-caret { transform: rotate(180deg); }
        .dropdown-menu { display: none; position: absolute; top: 100%; left: 0; min-width: 240px; background: var(--bg2); border: 1px solid var(--border); border-radius: 12px; padding: 8px; box-shadow: 0 16px 40px rgba(0,0,0,.5); z-index: 200; }
        .nav-item.open .dropdown-menu { display: block; }
        .dropdown-menu a { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 8px; color: var(--text); font-size: 0.875rem; font-weight: 500; }
        .dropdown-menu a:hover { background: rgba(99,102,241,.12); color: var(--cyan); }
        .dropdown-menu .dd-label { padding: 8px 14px 4px; font-size: 0.68rem; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); font-weight: 700; }
        .dropdown-menu .dd-divider { height: 1px; background: var(--border); margin: 6px 8px; }

        /* Mega panel (Exercises style) */
        .mega-panel { display: none; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); width: min(760px, 92vw); background: var(--bg2); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 20px 60px rgba(0,0,0,.6); z-index: 200; }
        .nav-item.open .mega-panel { display: block; }
        .mega-title { font-size: 0.72rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; background: linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 16px; }
        .mega-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; }
        .mega-card { border: 1px solid var(--border); border-radius: 12px; padding: 20px 16px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 8px; transition: border-color .15s, transform .15s; background: var(--bg); }
        .mega-card:hover { border-color: var(--indigo); transform: translateY(-2px); }
        .mega-card .mc-icon { font-size: 1.8rem; }
        .mega-card h4 { font-size: 0.95rem; font-weight: 700; color: var(--text); }
        .mega-card p { font-size: 0.76rem; color: var(--muted); flex: 1; }

        /* Search */
        .nav-search { display: flex; align-items: center; margin-left: auto; flex-shrink: 0; }
        .nav-search input { background: var(--bg3); border: 1px solid var(--border); border-radius: 24px 0 0 24px; border-right: none; color: var(--text); padding: 8px 16px; font-size: 0.85rem; outline: none; width: 220px; transition: border-color .2s; font-family: inherit; }
        .nav-search input:focus { border-color: var(--indigo); }
        .nav-search input::placeholder { color: var(--muted); font-style: italic; }
        .nav-search button { background: var(--bg3); border: 1px solid var(--border); border-left: none; border-radius: 0 24px 24px 0; color: var(--muted); padding: 8px 14px 8px 8px; cursor: pointer; font-size: 0.85rem; flex-shrink: 0; }
        .nav-search button:hover { color: var(--cyan); }

        .nav-actions { display: flex; align-items: center; gap: 16px; margin-left: 20px; flex-shrink: 0; }
        .nav-actions .nav-plain-link { color: var(--muted); font-size: 0.875rem; font-weight: 600; white-space: nowrap; }
        .nav-actions .nav-plain-link:hover { color: var(--text); }
        .mobile-menu-actions { display: none; }

        /* Topic bar (second tier) */
        /* Topic bar (second tier) - የተስተካከለ አዝራር ስታይል */
/* Topic bar (subnav) - የወርቃማ አዝራር እና የነጭ ጽሑፍ ስታይል */
.subnav { background: var(--bg2); border-bottom: 1px solid var(--border); padding: 8px 0; }
.subnav-inner { max-width: 1280px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 8px; overflow-x: auto; scrollbar-width: none; }
.subnav-inner::-webkit-scrollbar { display: none; }

/* ነባር አዝራሮች - የወርቃማ አጥር (Border) + ነጭ ጽሑፍ */
.subnav-inner a {
    background: rgba(245, 158, 11, 0.12); /* ቀለል ያለ የወርቃማ tint background */
    color: #ffffff !important;            /* የውስጡ ጽሑፍ ነጭ */
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 700;
    border: 1px solid #f59e0b;            /* ወርቃማ Border */
    text-transform: none; 
    letter-spacing: normal;
    transition: all 0.3s ease;
    margin-right: 8px;
    text-decoration: none;
    white-space: nowrap;
}

/* Mouse ሲያርፍበት (Hover Effect) - ሙሉ በሙሉ ወርቃማ ሆኖ ነጭ ጽሑፍ */
.subnav-inner a:hover {
    background: #f59e0b;
    color: #ffffff !important;            /* ጽሑፉ ነጭ ሆኖ ይቆያል */
    border-color: #f59e0b;
    box-shadow: 0 0 14px rgba(245, 158, 11, 0.6); /* ደመቅ ያለ ወርቃማ Glow */
    transform: translateY(-2px);
}

/* ተጠቃሚው ያለበት ገጽ ሲሆን (Active State) - ሙሉ በሙሉ ወርቃማ + ነጭ ጽሑፍ */
.subnav-inner a.active {
    background: #f59e0b;
    color: #ffffff !important;            /* ጽሑፉ ነጭ */
    border-color: #f59e0b;
    box-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
}
        /* VIP Button Special Styling */
.subnav-inner a.vip-btn {
    background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    color: #ffffff !important;
    border: 1px solid #fbbf24 !important;
    font-weight: 800;
    box-shadow: 0 0 12px rgba(245, 158, 11, 0.5);
    letter-spacing: 0.5px;
}

.subnav-inner a.vip-btn:hover {
    background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
    color: #000000 !important;
    box-shadow: 0 0 18px rgba(251, 191, 36, 0.8);
    transform: translateY(-2px);
}
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 22px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, var(--indigo), #8b5cf6); color: #fff; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(99,102,241,.4); color: #fff; }
        .btn-secondary { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-secondary:hover { border-color: var(--indigo); color: var(--indigo); }
        .btn-cyan { background: linear-gradient(135deg, var(--cyan), #0891b2); color: #000; font-weight: 700; }
        .btn-cyan:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(34,211,238,.4); color: #000; }
        .btn-gold { background: linear-gradient(135deg, #fffbeb, #fde68a); color: #1a1a24; font-weight: 700; border: 1px solid #fcd34d; }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(253, 230, 138, 0.3); color: #000; }
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

        /* Progress bar */
        .progress-bar { background: var(--bg3); border-radius: 99px; height: 6px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, var(--indigo), var(--cyan)); border-radius: 99px; transition: width .4s ease; }

        /* Table */
        .table { width: 100%; border-collapse: collapse; }
        .table th { background: var(--bg3); color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: .05em; padding: 12px 16px; text-align: left; }
        .table td { padding: 14px 16px; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
        .table tr:last-child td { border-bottom: none; }
        .table tbody tr:hover { background: var(--bg3); }

        /* Hamburger */
        .hamburger { display: none; background: none; border: none; cursor: pointer; flex-direction: column; gap: 5px; margin-left: 16px; flex-shrink: 0; padding: 4px; }
        .hamburger span { display: block; width: 24px; height: 2px; background: var(--text); }
        
        /* Mobile responsive adjustments - Side Drawer Style */
       @media (max-width: 900px) {
   

    .nav-inner { 
        position: relative; 
        flex-wrap: wrap; 
        row-gap: 10px; 
        padding-top: 10px; 
        padding-bottom: 10px; 
    }
    .nav-logo { margin-right: 0; font-size: 1.15rem; }
    .nav-utilities { order: 2; margin-left: auto; gap: 10px; }
    .hamburger { display: flex; }

    /* የከፈትከው የ nav-menu ሌላው ክፍል ይቀጥላል... */
            /* Admin Style Side Drawer Navigation */
  .nav-menu { 
    display: flex !important;
    position: fixed; 
    top: 0; 
    left: 0; 
    bottom: 0;
    height: 100vh;
    width: 80%; 
    max-width: 320px;
    background: var(--bg2); 
    border-right: 1px solid var(--border); 
    border-radius: 0 16px 16px 0; 
    flex-direction: column; 
    justify-content: flex-start; /* ከላይ ጀምሮ በቅደም ተከተል እንዲያወርደው */
    align-items: stretch; 
    padding: 24px 18px; 
    gap: 8px; /* ክፍተቱን ትንሽ መቀነስ */
    box-shadow: 10px 0 30px rgba(0,0,0,0.6); 
    z-index: 9999;
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
    overflow-y: auto;
}
}
            /* Slide-in Effect */
            .nav-menu.open { 
                transform: translateX(0); 
            }

            /* Inner sub-menus */
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
                justify-content: space-between; 
                padding: 12px 14px; 
                background: var(--bg3); 
                border-radius: 8px; 
            }
            
            .nav-search { margin-left: 0; width: 100%; }
            .nav-search input { width: 100%; }
            .nav-search input:focus { width: 100%; }
            .nav-actions { margin-left: 0; gap: 10px; }
            .nav-actions .nav-plain-link { display: none; }
            .nav-actions form { display: none !important; }
.mobile-menu-actions {
    display: none ;
}

@media (max-width: 900px) {
    .mobile-menu-actions { 
        display: flex; 
        flex-direction: column; 
        gap: 10px; 
        margin-top: 20px; 
        padding-top: 16px; 
        padding-bottom: 40px; 
        border-top: 1px solid var(--border); 
    }
    .mobile-menu-actions .btn { width: 100%; justify-content: center; }
}

            /* Topic bar responsive */
            .subnav { display: block; overflow-x: auto; }
            .subnav-inner { gap: 0; }
            .subnav-inner a { font-size: 0.75rem; padding: 10px 12px; }
        }

        /* Footer */
        footer { background: var(--bg2); border-top: 1px solid var(--border); padding: 40px 0; margin-top: 80px; text-align: center; color: var(--muted); }
    </style>
    
    @stack('styles')
    <!-- Font Awesome for Chatbot Icons -->
<link href="[https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css](https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css)" rel="stylesheet">
</head>
<body>
@php $navCourses = \App\Models\Course::where('is_published', true)->orderBy('title')->take(10)->get(); @endphp

<nav class="navbar">
    <div class="nav-inner">
        <a href="/" class="nav-logo">🎓 Tesheai Academy</a>

        <div class="nav-menu" id="navMenu">
            {{-- Courses dropdown --}}
            <div class="nav-item">
                <button type="button" class="nav-top-link" data-dd>Courses <span class="nav-caret">▼</span></button>
                <div class="dropdown-menu">
                    <div class="dd-label">Premium Courses(VIP)</div>
                    @forelse($navCourses as $navCourse)
                        <a href="{{ route('course.show', $navCourse) }}">📚 {{ $navCourse->title }}</a>
                    @empty
                        <a href="/#courses">📚 ኮርሶች በቅርቡ ይመጣሉ</a>
                    @endforelse
                    <div class="dd-divider"></div>
                    <a href="/#courses"> Browse All</a>
                </div>
            </div>

            {{-- Resources dropdown --}}
            <div class="nav-item">
                <button type="button" class="nav-top-link" data-dd> Resources <span class="nav-caret">▼</span></button>
                <div class="dropdown-menu">
                    <div class="dd-label">Free for members</div>
                    <a href="{{ route('documents.index') }}">  books</a>
                    <a href="{{ route('quizzes.index') }}"> Quizzes</a>
                    <div class="dd-divider"></div>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"> Post Skills</a>
                        @else
                            <a href="{{ route('student.dashboard') }}">  My Learning</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"> ተመዝገብና በነጻ ተጠቀም</a>
                    @endauth
                </div>
            </div>

            {{-- Practice mega panel --}}
            <div class="nav-item">
                <button type="button" class="nav-top-link" data-dd> Practice <span class="nav-caret">▼</span></button>
                <div class="mega-panel">
                    <div class="mega-title">TesheAi Academy practices </div>
                    <div class="mega-grid">
                        <div class="mega-card">
                            <div class="mc-icon">📝</div>
                            <h4>Quizzes</h4>
                            <p>እውቀትዎን በ A–D ምርጫ ፈተናዎች ይፈትሹ</p>
                            <a href="{{ route('quizzes.index') }}" class="btn btn-primary btn-sm">Browse Quizzes</a>
                        </div>
                        <div class="mega-card">
                            <div class="mc-icon">📄</div>
                            <h4> Books</h4>
                            <p>ነፃ አስተማሪ books በነፃ ተጠቀሙ</p>
                            <a href="{{ route('documents.index') }}" class="btn btn-primary btn-sm">Browse Books</a>
                        </div>
                        <div class="mega-card">
                            <div class="mc-icon">📚</div>
                            <h4>Courses</h4>
                            <p>ሙሉ የ Video ኮርሶች Premiume ጥራት (VIP ROOM)</p>
                            <a href="/#courses" class="btn btn-primary btn-sm">Browse Courses</a>
                        </div>
                    </div>
                </div>
            </div>

           <div class="mobile-menu-actions">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-cyan btn-sm" style="width: 100%; justify-content: center;">Sign in</a>
                @endguest
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm" style="width:100%; justify-content:center;">Post your skills</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary btn-sm" style="width:100%; justify-content:center;">📚 My Learning</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" style="width: 100%; justify-content:center;">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
<div class="nav-utilities">
            <div class="nav-actions">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-cyan btn-sm" style="border-radius: 20px; padding: 6px 16px; font-weight: 700; font-size: 0.85rem; white-space: nowrap;">Sign in</a>
                @endguest
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-plain-link" style="color:var(--indigo); white-space: nowrap;">Dashboard</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="nav-plain-link" style="white-space: nowrap;">My Learning</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm" style="white-space: nowrap;">Logout</button>
                    </form>
                @endauth
            </div>

            <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

{{-- Topic bar --}}
{{-- Topic bar --}}
<div class="subnav">
    <div class="subnav-inner">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.*') ? 'active' : '' }}">books</a>
        <a href="{{ route('quizzes.index') }}" class="{{ request()->routeIs('quizzes.*') ? 'active' : '' }}">Quizzes</a>
        @auth
            @if(!auth()->user()->isAdmin())
                <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">My Learning</a>
            @endif
        @endauth

        {{-- አዲሱ VIP አዝራር (ወደ ቴሌግራም ቻናል የሚወስድ) 
        <a href="https://t.me/+qDjJMxPexn03NmQ8" target="_blank" rel="noopener noreferrer" class="vip-btn">
            👑 VIP 
        </a>--}}
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
        <p style="font-size:0.9rem;">© {{ date('Y') }} Tesheai Academy. All rights reserved. | Made with ❤️ for Ethiopian learners</p>
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
// Mobile Menu - Only Hamburger Button Toggles Menu
const hamburgerBtn = document.getElementById('hamburgerBtn');
const navMenu = document.getElementById('navMenu');

if (hamburgerBtn && navMenu) {
    hamburgerBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        navMenu.classList.toggle('open');
    });
}

// Submenu Accordions (ትምህርቶች፣ መርጃዎች፣ ልምምድ የሚሉትን ሲነኩ በሜኑው ውስጥ ለመክፈት)
document.querySelectorAll('[data-dd]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        var item = btn.closest('.nav-item');
        var wasOpen = item.classList.contains('open');
        
        // ሌሎችን መዝጋት
        document.querySelectorAll('.nav-item.open').forEach(function (o) { 
            o.classList.remove('open'); 
        });
        
        // የተነካውን መክፈት
        if (!wasOpen) {
            item.classList.add('open');
        }
    });
});

// Search functionality
function scrollToCourses(e, form) {
    var q = document.getElementById('nav-search-input').value.trim();
    var onHome = window.location.pathname === '/';
    if (onHome) {
        e.preventDefault();
        var section = document.getElementById('courses');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (q) {
                var cards = document.querySelectorAll('.course-card');
                cards.forEach(function(card) {
                    var title = card.querySelector('.course-title')?.textContent.toLowerCase() || '';
                    card.style.display = title.includes(q.toLowerCase()) ? '' : 'none';
                });
            }
        }
    }
}
</script>
    <!-- Chatbase AI Widget -->
<!-- ===== TESHEAI CHATBOT WIDGET ===== -->
<style>
#chatbot-btn {
    position:fixed; bottom:24px; right:20px; z-index:9998;
    height:52px; border-radius:50px; border:none; cursor:pointer;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    box-shadow:0 8px 25px rgba(99,102,241,0.5);
    display:flex; align-items:center; gap:10px; padding:0 18px 0 6px;
    transition:all 0.3s; animation:pulse-btn 2.5s infinite;
}
#chatbot-btn:hover { transform:scale(1.1); box-shadow:0 12px 35px rgba(99,102,241,0.7); }
@keyframes pulse-btn {
    0%,100%{ box-shadow:0 8px 25px rgba(99,102,241,0.5); }
    50%{ box-shadow:0 8px 35px rgba(99,102,241,0.8),0 0 0 8px rgba(99,102,241,0.15); }
}
#chatbot-window {
    position:fixed; bottom:90px; right:20px; z-index:9997;
    width:min(380px, calc(100vw - 24px));
    height:min(560px, calc(100vh - 120px));
    border-radius:24px;
    background:#fff; box-shadow:0 20px 60px rgba(0,0,0,0.25);
    display:none; flex-direction:column; overflow:hidden;
    animation:slideUp 0.3s ease;
}
@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.chat-header {
    background:linear-gradient(135deg,#1e1b4b,#4c1d95);
    padding:18px 20px; display:flex; align-items:center; gap:12px;
}
.chat-header-info { flex:1; }
.chat-header-name { color:#fff; font-weight:700; font-size:0.95rem; }
.chat-header-status { color:rgba(255,255,255,0.7); font-size:0.72rem; display:flex; align-items:center; gap:4px; }
.chat-header-status::before { content:''; width:7px; height:7px; background:#22c55e; border-radius:50%; display:inline-block; }
.chat-close { background:none; border:none; color:rgba(255,255,255,0.7); cursor:pointer; font-size:1.1rem; padding:4px; }
.chat-close:hover { color:#fff; }
.chat-messages {
    flex:1; overflow-y:auto; padding:16px; display:flex;
    flex-direction:column; gap:12px; background:#f8f7ff;
}
.chat-messages::-webkit-scrollbar { width:4px; }
.chat-messages::-webkit-scrollbar-thumb { background:#c4b5fd; border-radius:4px; }
.msg { max-width:82%; display:flex; flex-direction:column; gap:3px; }
.msg.bot { align-self:flex-start; }
.msg.user { align-self:flex-end; }
.msg-bubble {
    padding:10px 14px; border-radius:16px; font-size:0.85rem; line-height:1.5;
}
.msg.bot .msg-bubble { background:#fff; color:#1e1b4b; border-bottom-left-radius:4px; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
.msg.user .msg-bubble { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-bottom-right-radius:4px; }
.msg-time { font-size:0.65rem; color:#9ca3af; padding:0 4px; }
.msg.user .msg-time { text-align:right; }
.typing-indicator { display:flex; gap:4px; padding:10px 14px; background:#fff; border-radius:16px; border-bottom-left-radius:4px; width:fit-content; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
.typing-dot { width:7px; height:7px; background:#a5b4fc; border-radius:50%; animation:typing 1.2s infinite; }
.typing-dot:nth-child(2) { animation-delay:0.2s; }
.typing-dot:nth-child(3) { animation-delay:0.4s; }
@keyframes typing { 0%,60%,100%{transform:translateY(0);opacity:0.4} 30%{transform:translateY(-6px);opacity:1} }
.chat-input-area {
    padding:14px 16px; background:#fff; border-top:1px solid #f3f4f6;
    display:flex; gap:10px; align-items:center;
}
#chat-input {
    flex:1; padding:10px 14px; border:1.5px solid #e5e7eb; border-radius:50px;
    font-size:0.88rem; outline:none; transition:all 0.2s; color:#1e1b4b;
}
#chat-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
#chat-send {
    width:40px; height:40px; border-radius:50%; border:none;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition:all 0.2s; flex-shrink:0;
}
#chat-send:hover { transform:scale(1.1); }
</style>

<!-- Chatbot Toggle Button -->
<button id="chatbot-btn" onclick="toggleChat()" title="ድጋፍ ያግኙ" style="padding:0 18px 0 6px;overflow:visible;">
    <span id="chat-icon-wrap" style="display:flex;align-items:center;gap:10px;">
       <img src="{{ asset('images/tesheai_partial_2_half_shadow.webp') }}" id="chat-photo"
             style="width:40px;height:40px;object-fit:cover;object-position:top;border-radius:50%;border:2px solid rgba(255,255,255,0.5);" alt="Teshome">
        <span id="chat-label" style="color:#fff;font-weight:700;font-size:0.88rem;white-space:nowrap;">Chat</span>
        <i class="fas fa-times" id="chat-icon" style="color:#fff;font-size:1rem;display:none;"></i>
    </span>
</button>

<!-- Chatbot Window -->
<div id="chatbot-window">
    <div class="chat-header">
        <div style="width:42px;height:42px;border-radius:50%;overflow:hidden;border:2px solid rgba(255,255,255,0.4);flex-shrink:0;">
            <img src="{{ asset('images/tesheai_partial_2_half_shadow.webp') }}" style="width:100%;height:100%;object-fit:cover;object-position:top;" alt="Teshome">
        </div>
        <div class="chat-header-info">
            <div class="chat-header-name">TesheAi Assistant</div>
            <div class="chat-header-status">ዝግጁ ነኝ</div>
        </div>
        <button class="chat-close" onclick="toggleChat()"><i class="fas fa-times"></i></button>
    </div>
    <div class="chat-messages" id="chat-messages">
        <div class="msg bot">
            <div class="msg-bubble">👋 ሰላም! እኔ TesheAi assistant ነኝ። ስለ ኮርሶች ወይም ቴክኖሎጂ ምን ልረዳዎ?</div>
            <div class="msg-time">አሁን</div>
        </div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="chat-input" placeholder="ጥያቄዎን እዚህ ይጻፉ..." onkeypress="if(event.key==='Enter') sendMessage()">
        <button id="chat-send" onclick="sendMessage()">
            <i class="fas fa-paper-plane" style="font-size:0.85rem;"></i>
        </button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function toggleChat() {
    const win = document.getElementById('chatbot-window');
    const photo = document.getElementById('chat-photo');
    const icon = document.getElementById('chat-icon');
    const label = document.getElementById('chat-label');
    const isOpen = win.style.display === 'flex';
    win.style.display = isOpen ? 'none' : 'flex';
    photo.style.display = isOpen ? 'block' : 'none';
    icon.style.display = isOpen ? 'none' : 'block';
    label.style.display = isOpen ? 'block' : 'none';
    if (!isOpen) setTimeout(() => document.getElementById('chat-input').focus(), 300);
}

function getTime() {
    return new Date().toLocaleTimeString('am-ET', {hour:'2-digit', minute:'2-digit'});
}

function appendMsg(text, type) {
    const msgs = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.className = `msg ${type}`;
    div.innerHTML = `<div class="msg-bubble">${text}</div><div class="msg-time">${getTime()}</div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function showTyping() {
    const msgs = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.id = 'typing';
    div.className = 'msg bot';
    div.innerHTML = '<div class="typing-indicator"><div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div></div>';
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function removeTyping() {
    const t = document.getElementById('typing');
    if (t) t.remove();
}

function sendMessage() {
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (!msg) return;

    appendMsg(msg, 'user');
    input.value = '';
    showTyping();

    $.ajax({
        url: '{{ route("chatbot") }}',
        method: 'POST',
        data: { message: msg, _token: '{{ csrf_token() }}' },
        success: function(res) {
            removeTyping();
            appendMsg(res.reply.replace(/\n/g, '<br>'), 'bot');
        },
        error: function() {
            removeTyping();
            appendMsg('ይቅርታ፣ ችግር አጋጥሟል። ቆይተው ይሞክሩ።', 'bot');
        }
    });
}
</script>
</body>
</html>
