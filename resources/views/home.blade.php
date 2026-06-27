@extends('layouts.app')
@section('title', 'EduPlatform - ምርጥ ኦንላይን ትምህርቶች')
@push('styles')
<style>
.hero { padding: 100px 0 80px; text-align: center; position: relative; overflow: hidden; }
.hero::before { content:''; position:absolute; top:-200px; left:50%; transform:translateX(-50%); width:800px; height:800px; background: radial-gradient(circle, rgba(99,102,241,.15) 0%, transparent 70%); pointer-events:none; }
.hero-badge { display:inline-block; background:rgba(99,102,241,.15); border:1px solid rgba(99,102,241,.3); color:var(--indigo); padding:6px 16px; border-radius:99px; font-size:0.8rem; font-weight:600; margin-bottom:24px; }
.hero h1 { font-size:clamp(2.5rem,6vw,4.5rem); font-weight:900; line-height:1.1; margin-bottom:24px; }
.grad-text { background:linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.hero p { font-size:1.2rem; color:var(--muted); max-width:600px; margin:0 auto 40px; line-height:1.7; }
.hero-btns { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; }
.stats-row { display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:24px; padding:60px 0; }
.stat-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:28px; text-align:center; transition:.2s; }
.stat-card:hover { border-color:var(--indigo); transform:translateY(-4px); }
.stat-num { font-size:2.5rem; font-weight:900; background:linear-gradient(135deg,var(--indigo),var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.stat-label { color:var(--muted); font-size:0.85rem; margin-top:4px; }
.section-title { text-align:center; margin-bottom:56px; }
.section-title h2 { font-size:2.2rem; font-weight:800; margin-bottom:12px; }
.section-title p { color:var(--muted); font-size:1.05rem; }
.features-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:24px; }
.feature-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:28px; transition:.2s; }
.feature-card:hover { border-color:var(--cyan); transform:translateY(-4px); box-shadow:0 8px 40px rgba(34,211,238,.1); }
.feature-icon { font-size:2.5rem; margin-bottom:16px; }
.feature-card h3 { font-size:1rem; font-weight:700; margin-bottom:8px; }
.feature-card p { color:var(--muted); font-size:0.9rem; line-height:1.6; }
.courses-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:28px; }
.course-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; overflow:hidden; transition:.3s; }
.course-card:hover { border-color:var(--indigo); transform:translateY(-6px); box-shadow:0 16px 50px rgba(99,102,241,.15); }
.course-thumb { width:100%; height:200px; object-fit:cover; background:linear-gradient(135deg,var(--bg3),var(--border)); display:flex; align-items:center; justify-content:center; font-size:4rem; }
.course-body { padding:24px; }
.course-meta { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:12px; }
.course-title { font-size:1.1rem; font-weight:700; margin-bottom:8px; line-height:1.3; }
.course-desc { color:var(--muted); font-size:0.85rem; margin-bottom:16px; line-height:1.5; }
.course-price { display:flex; align-items:center; gap:12px; margin-bottom:16px; }
.price-main { font-size:1.5rem; font-weight:800; color:var(--cyan); }
.price-original { font-size:0.9rem; color:var(--muted); text-decoration:line-through; }
.price-badge { background:rgba(16,185,129,.2); color:#10b981; padding:2px 8px; border-radius:4px; font-size:0.75rem; font-weight:700; }
.testimonials-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:24px; }
.testi-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:28px; position:relative; }
.testi-card::before { content:'"'; position:absolute; top:16px; right:20px; font-size:5rem; color:var(--indigo); opacity:.3; line-height:1; font-family:serif; }
.testi-stars { color:#fbbf24; font-size:1.1rem; margin-bottom:12px; }
.testi-text { color:var(--muted); font-size:0.95rem; line-height:1.6; margin-bottom:20px; }
.testi-author { display:flex; align-items:center; gap:12px; }
.testi-avatar { width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,var(--indigo),var(--cyan)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.1rem; }
.testi-name { font-weight:600; font-size:0.9rem; }
.testi-role { color:var(--muted); font-size:0.8rem; }
.cta-section { background:linear-gradient(135deg, rgba(99,102,241,.1), rgba(34,211,238,.05)); border:1px solid var(--border); border-radius:20px; padding:80px 40px; text-align:center; margin:80px 0; }
.cta-section h2 { font-size:2.5rem; font-weight:900; margin-bottom:16px; }
.cta-section p { color:var(--muted); font-size:1.1rem; margin-bottom:36px; }
.section-gap { padding: 80px 0; }
</style>
@endpush
@section('content')

{{-- Hero --}}
<section class="hero">
    <div class="container">
        <div class="hero-badge">🇪🇹 አዲስ ኮርሶች ተጨምረዋል / New Courses Available</div>
        <h1>ከዜሮ ወደ <span class="grad-text">ፕሮፌሽናል</span><br>ዲቬሎፐር ሁን</h1>
        <p>ላራቬል፣ ሪኤክት እና MySQL ተጠቅምህ ሙሉ ስታክ ዌብ ዲቬሎፐር ሁን። Learn modern web development in Amharic + English.</p>
        <div class="hero-btns">
            <a href="#courses" class="btn btn-cyan" style="font-size:1rem;padding:14px 32px;">🚀 ኮርሶችን ይመልከቱ / View Courses</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-secondary" style="padding:14px 32px;">ነፃ ተመዝገቡ / Free Sign Up</a>
            @endguest
        </div>
    </div>
</section>

{{-- Stats --}}
<div class="container">
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num">5,000+</div>
            <div class="stat-label">ተማሪዎች / Students</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">50+</div>
            <div class="stat-label">ትምህርቶች / Lessons</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">4.9★</div>
            <div class="stat-label">ደረጃ / Rating</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">30h</div>
            <div class="stat-label">ይዘት / Content</div>
        </div>
    </div>
</div>

{{-- What You Learn --}}
<section class="section-gap">
    <div class="container">
        <div class="section-title">
            <h2>ምን ይማራሉ? / <span class="grad-text">What You'll Learn</span></h2>
            <p>ይህ ኮርስ ሲጨርሱ ሙሉ ስታክ ዌብ ዲቬሎፐር ይሆናሉ</p>
        </div>
        @if(isset($featuredCourse) && $featuredCourse)
            @php $items = $featuredCourse->what_you_learn ?? []; @endphp
            <div class="features-grid">
                @foreach(array_slice($items, 0, 6) as $item)
                <div class="feature-card">
                    <div class="feature-icon">✅</div>
                    <h3>{{ $item }}</h3>
                </div>
                @endforeach
                @if(empty($items))
                @foreach([
                    ['icon'=>'⚡','title'=>'Laravel 11 Backend','desc'=>'Modern PHP framework for building robust APIs'],
                    ['icon'=>'⚛️','title'=>'React.js Frontend','desc'=>'Build dynamic user interfaces with React'],
                    ['icon'=>'🗄️','title'=>'MySQL Database','desc'=>'Design and optimize relational databases'],
                    ['icon'=>'🔐','title'=>'Authentication & Security','desc'=>'JWT, OAuth, and secure coding practices'],
                    ['icon'=>'🚀','title'=>'REST API Design','desc'=>'Build scalable and clean RESTful APIs'],
                    ['icon'=>'☁️','title'=>'Deployment','desc'=>'Deploy your app to production servers'],
                ] as $f)
                <div class="feature-card">
                    <div class="feature-icon">{{ $f['icon'] }}</div>
                    <h3>{{ $f['title'] }}</h3>
                    <p>{{ $f['desc'] }}</p>
                </div>
                @endforeach
                @endif
            </div>
        @endif
    </div>
</section>

{{-- Courses --}}
<section class="section-gap" id="courses">
    <div class="container">
        <div class="section-title">
            <h2>ኮርሶቻችን / <span class="grad-text">Our Courses</span></h2>
            <p>ተገቢ ኮርሱን ምረጡ እና ዛሬ ጀምሩ</p>
        </div>
        <div class="courses-grid">
            @forelse($courses as $course)
            <div class="course-card">
                @if($course->thumbnail)
                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="course-thumb" style="height:200px;object-fit:cover;width:100%;">
                @else
                    <div class="course-thumb">🎓</div>
                @endif
                <div class="course-body">
                    <div class="course-meta">
                        <span class="badge badge-indigo">{{ ucfirst($course->level) }}</span>
                        <span class="badge badge-cyan">{{ $course->language }}</span>
                    </div>
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <p class="course-desc">{{ Str::limit($course->description, 120) }}</p>
                    <div style="display:flex;gap:16px;color:var(--muted);font-size:0.8rem;margin-bottom:16px;">
                        <span>📚 {{ $course->total_lessons }} ትምህርቶች</span>
                        <span>⏱ {{ $course->total_hours }}h</span>
                    </div>
                    <div class="course-price">
                        <span class="price-main">{{ number_format($course->price_etb) }} ETB</span>
                        @if($course->original_price_etb)
                        <span class="price-original">{{ number_format($course->original_price_etb) }}</span>
                        <span class="price-badge">{{ $course->discountPercentageEtb() }}% OFF</span>
                        @endif
                    </div>
                    <a href="{{ route('course.show', $course->slug) }}" class="btn btn-primary" style="width:100%;justify-content:center;">ዝርዝር ይመልከቱ / View Details →</a>
                </div>
            </div>
            @empty
            <p style="color:var(--muted);text-align:center;grid-column:1/-1;">ኮርስ አልተጠቃ / No courses yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="section-gap">
    <div class="container">
        <div class="section-title">
            <h2>ምን ይላሉ? / <span class="grad-text">What Students Say</span></h2>
        </div>
        <div class="testimonials-grid">
            @foreach([
                ['name'=>'አብዱ ሀሰን','role'=>'Full Stack Developer','text'=>'ይህ ኮርስ ሕይወቴን ቀይሯል። ከምዝገባ 3 ወር ውስጥ የፈለኩትን ሥራ አገኘሁ። This course changed my life!','letter'=>'አ'],
                ['name'=>'Sara Tesfaye','role'=>'Web Developer','text'=>'The Amharic + English mix made it so easy to understand. Best investment I have made for my career!','letter'=>'S'],
                ['name'=>'ዳዊት ገ/ሕይወት','role'=>'Freelancer','text'=>'አስተማሪው በጣም ጥሩ ነው። ቪዲዮዎቹ ግልጽ ናቸው። ሁሉም ሰው ይህን ኮርስ መውሰድ አለበት።','letter'=>'ዳ'],
            ] as $t)
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"{{ $t['text'] }}"</p>
                <div class="testi-author">
                    <div class="testi-avatar">{{ $t['letter'] }}</div>
                    <div>
                        <div class="testi-name">{{ $t['name'] }}</div>
                        <div class="testi-role">{{ $t['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<div class="container">
    <div class="cta-section">
        <h2>ዛሬ ጀምሩ! / <span class="grad-text">Start Today!</span></h2>
        <p>5,000+ ተማሪዎች ተቀላቅለዋል። ቀጣዩ ተማሪ እርስዎ ነዎት። Join 5,000+ students already learning.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-cyan" style="font-size:1.1rem;padding:16px 40px;">ነፃ ተመዝገቡ / Sign Up Free →</a>
        @else
            <a href="#courses" class="btn btn-cyan" style="font-size:1.1rem;padding:16px 40px;">ኮርሶችን ይመልከቱ →</a>
        @endguest
    </div>
</div>

@endsection
