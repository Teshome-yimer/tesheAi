@extends('layouts.app')
@section('title', ' Tesheai Acadamey የነገው የቴክኖሎጂ መድረክ | Learn Tech Skills')
@push('styles')
<style>
.hero { padding: 100px 0 80px; text-align: center; position: relative; overflow: hidden; }
.hero::before { content:''; position:absolute; top:-200px; left:50%; transform:translateX(-50%); width:800px; height:800px; background: radial-gradient(circle, rgba(99,102,241,.15) 0%, transparent 70%); pointer-events:none; }
.hero-badge { display:inline-block; background:rgba(99,102,241,.15); border:1px solid rgba(99,102,241,.3); color:var(--indigo); padding:6px 16px; border-radius:99px; font-size:0.8rem; font-weight:600; margin-bottom:24px; }
.hero h1 { font-size:clamp(2.5rem,6vw,4.5rem); font-weight:900; line-height:1.1; margin-bottom:24px; }
.grad-text { background:linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.hero p { font-size:1.2rem; color:var(--muted); max-width:600px; margin:0 auto 40px; line-height:1.7; }
.hero-btns { display:flex; gap:16px; justify-content:center; flex-wrap:wrap; }
.stats-row { display:grid; grid-template-columns:repeat(auto-fit, minmax(60px,1fr)); gap:10px; padding:50px 0; }
.stat-card { background:var(--bg2); border:1px solid var(--border); border-radius:50%; padding:20px; text-align:center; transition:.5s; }
.stat-card:hover { border-color:var(--indigo); transform:translateY(-6px); }
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
    .tech-feature-list {
    list-style: none;
    padding: 0;
    margin: 24px auto 0;
    max-width: 700px;
    text-align: left; /* ከግራ እኩል እንዲጀምሩ የሚያደርገው CSS */
}

.tech-feature-list li {
    font-size: 0.95rem;
    color: var(--muted);
    margin-bottom: 12px;
    line-height: 1.6;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="hero">
    <div class="container">
        <div class="hero-badge"> በዲጂታሉ ዓለም ስኬታማ ለመሆን ዝግጁ ነዎት? | Master the Digital Era</div>
        <h1>TesheAi Acadamey  <span class="grad-text">  World is rapidly transforming digitally. </span><br>Learn modern, practical skills </h1>
            <div class="hero-btns">
            <a href="#courses" class="btn btn-cyan" style="font-size:1rem;padding:14px 32px;">አሁኑኑ መማር ይጀምሩ / Start Learning Today</a>
        </div>

        {{-- Search bar --}}
        <div style="margin-top:36px;max-width:520px;margin-left:auto;margin-right:auto;">
            <form onsubmit="searchCourses(event, this)" style="display:flex;gap:0;border-radius:99px;overflow:hidden;border:2px solid var(--indigo);background:var(--bg2);">
                <input type="text" id="hero-search" placeholder="ኮርስ ፈልግ / Search courses..." autocomplete="off"
                    style="flex:1;background:transparent;border:none;color:var(--text);padding:14px 22px;font-size:1rem;outline:none;font-family:inherit;">
                <button type="submit"
                    style="background:linear-gradient(135deg,var(--indigo),var(--cyan));color:#fff;border:none;padding:14px 24px;cursor:pointer;font-size:1rem;font-weight:700;white-space:nowrap;">
                     search
                </button>
            </form>
            <div id="search-results" style="display:none;background:var(--bg2);border:1px solid var(--border);border-radius:12px;margin-top:8px;overflow:hidden;text-align:left;"></div>
        </div>
    </div>
</section>

{{-- Stats --}}
<div class="container">
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num">5k</div>
            <div class="stat-label">ተማሪዎች / Active Learners</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">50+</div>
            <div class="stat-label">ትምህርቶች / Video Lessons</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">4.9★</div>
            <div class="stat-label">የተማሪዎች እርካታ / Top Rating</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">30h</div>
            <div class="stat-label">ተግባራዊ / Hands-on Projects</div>
        </div>
    </div>
</div>

{{-- What You Learn --}}
<section class="section-gap">
    <div class="container">
       <div class="section-title">
    <h2>ምን ያተርፋሉ? / <span class="grad-text">Why Learn With Us?</span></h2>
    
   
</div>
        <div class="features-grid">
            @if(isset($featuredCourse) && $featuredCourse)
                @php $items = $featuredCourse->what_you_learn ?? []; @endphp
                @foreach(array_slice($items, 0, 6) as $item)
                <div class="feature-card">
                    <div class="feature-icon"></div>
                    <h3>{{ $item }}</h3>
                </div>
                @endforeach
            @endif

            @if(!isset($featuredCourse) || empty($items))
                @foreach([
                    ['icon'=>'','title'=>'ዘመናዊ የቴክኖሎጂ ክህሎቶች','desc'=>'በዓለም አቀፍ ደረጃ በስፋት የሚፈለጉ ዘመናዊ የልማት ቴክኖሎጂዎች'],
                    ['icon'=>'','title'=>'ተግባራዊ ፕሮጀክቶች (Real-World Projects)','desc'=>'በቀጥታ ለሥራ የሚያዘጋጁዎትን እውነተኛ ፕሮጀክቶች የመስራት ልምድ'],
                    ['icon'=>'','title'=>'የውሂብ ጎታ እና ሲስተም ዲዛይን','desc'=>'ጠንካራና አስተማማኝ ሶፍትዌሮችን የመገንባት ጥበብ'],
                    ['icon'=>'','title'=>'ደህንነት እና ፕሮፌሽናል አሰራር','desc'=>'የሶፍትዌር ደህንነት እና በኢንዱስትሪ ደረጃ የሚጠበቁ ምርጥ ልምዶች'],
                    ['icon'=>'','title'=>'የፍሪላንሲንግ እና የሥራ ዕድል','desc'=>'በኦንላይን እና በሀገር ውስጥ የሥራ ዕድሎችን የማግኘት አቅም'],
                    ['icon'=>'☁️','title'=>'በራስ ፍጥነት የመማር እድል','desc'=>'በፈለጉት ጊዜና ቦታ ቪዲዮዎችን ደጋግመው የመመልከት ነፃነት'],
                ] as $f)
                <div class="feature-card">
                    <div class="feature-icon">{{ $f['icon'] }}</div>
                    <h3>{{ $f['title'] }}</h3>
                    <p>{{ $f['desc'] }}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- Courses --}}
<section class="section-gap" id="courses">
    <div class="container">
        <div class="section-title">
            <h2>የሥልጠና ፕሮግራሞቻችን / <span class="grad-text">Our Courses</span></h2>
            @if(!empty($search))
                <p>🔍 "{{ $search }}" ውጤት: {{ $courses->count() }} ኮርስ(ኮርሶች) ተገኝተዋል — <a href="{{ url('/') }}#courses" style="color:var(--cyan);">ሁሉንም አሳይ / Clear</a></p>
            @else
                <p>ለእርስዎ ተስማሚ የሆነውን ትምህርት ይምረጡና የዕውቀት ጉዞዎን ዛሬውኑ ይጀምሩ</p>
            @endif
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
            <p style="color:var(--muted);text-align:center;grid-column:1/-1;">አዳዲስ ኮርስ ልንለቅ ነው በትግስት ጠብቁን.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Meet Your Instructor --}}
<section class="section-gap" style="background:var(--bg3); border-top:1px solid var(--border); border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="section-title">
            <h2>አሰልጣኝዎን ያግኙ / <span class="grad-text">Meet Your Instructor</span></h2>
            <p>ቀጥታ ከኢንዱስትሪው ባለሙያዎች ጋር በተግባር ይማሩ / Learn from industry experts</p>
        </div>
        <div style="display:flex; gap:48px; align-items:center; flex-wrap:wrap; justify-content:center;">
            <div style="flex:1; min-width:280px; text-align:center;">
                <img src="{{ asset('images/teshome_photo_1.jpg') }}" alt="Teshome" style="width:280px; height:280px; border-radius:50%; object-fit:cover; object-position:top; border:4px solid var(--indigo); box-shadow:0 12px 40px rgba(99,102,241,0.25);">
            </div>
            <div style="flex:2; min-width:320px;">
                <h3 style="font-size:2rem; font-weight:800; margin-bottom:8px;">ተሾመ / Teshome</h3>
                <p style="color:var(--cyan); font-weight:600; margin-bottom:18px; font-size:1.1rem;">የሶፍትዌር ኢንጂነር፣ የቴክኖሎጂ አማካሪ እና የዲጂታል ክህሎቶች አሰልጣኝ
(Software Engineer, Tech Consultant & Digital Skills Instructor)</p>
                <p style="color:var(--muted); line-height:1.8; font-size:1.05rem; margin-bottom:24px;">
                   Teshome is a Software Engineer, Tech Consultant, and Lead Instructor with 7+ years of experience building modern digital solutions. He empowers learners with real-world tech skills across 6 core domains: Video Editing, Digital Marketing, Software & Web Development, Mobile App Development, Database & REST APIs, and AI & Cybersecurity. Through practical, project-based teaching, Teshome bridges the gap between theory and industry needs to prepare students for global tech careers.
                </p>
                <div style="display:flex; gap:16px;">
                    <div style="background:var(--bg2); padding:14px 24px; border-radius:10px; border:1px solid var(--border); text-align:center; min-width:120px;">
                        <div style="font-weight:800; color:var(--indigo); font-size:1.2rem;">5+ ዓመት</div>
                        <div style="font-size:0.8rem; color:var(--muted); margin-top:2px;">ልምድ / Experience</div>
                    </div>
                    <div style="background:var(--bg2); padding:14px 24px; border-radius:10px; border:1px solid var(--border); text-align:center; min-width:120px;">
                        <div style="font-weight:800; color:var(--indigo); font-size:1.2rem;">5,000+</div>
                        <div style="font-size:0.8rem; color:var(--muted); margin-top:2px;">ተማሪዎች / Students</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="section-gap">
    <div class="container">
        <div class="section-title">
            <h2>የተማሪዎቻችን አስተያየት / <span class="grad-text">Student Stories</span></h2>
            <p>ከእኛ ጋር የተማሩ ተማሪዎች ስኬታቸውን ያካፍላሉ</p>
        </div>
        <div class="testimonials-grid">
        @foreach([
    [
        'name' => 'አብዱ ሀሰን',
        'role' => 'AI & Software Developer',
        'text' => 'ትምህርቱ በጣም ተግባራዊና ግልጽ ነው። ከኮዲንግ ባለፈ የዘመኑን የኤአይ (AI) መሣሪያዎች ለምርታማነት በመጠቀሜ ሙሉ የዌብና የሞባይል መተግበሪያዎችን በራሴ መገንባት ችያለሁ። ለአካዴሚያዊና ፕሮፌሽናል ጉዞዬ ድንቅ ጅምር ነው!',
        'img'  => asset('images/kidan.webp')
    ],
    [
        'name' => 'robel Tesfaye',
        'role' => 'Cybersecurity & Cloud Analyst',
        'text' => 'The blend of Amharic and English made complex tech domains like Cybersecurity, Data Analytics, and Cloud systems effortless to grasp. Truly a life-changing experience for my career in tech!',
        'img'  => asset('images/mengesha.webp')
    ],
    [
        'name' => 'ዳዊት ገ/ሕይወት',
        'role' => 'Tech Freelancer & Consultant',
        'text' => 'ስልጠናው ከንድፈ-ሀሳብ ይልቅ ሙሉ በሙሉ ተግባር ላይ ያተኮረ በመሆኑ፣ በፍሪላንሲንግ ዘርፍ በዓለም አቀፍ ደረጃ የቴክኖሎጂ ስራዎችን ወዲያውኑ እንድጀምርና ውጤታማ እንድሆን ረድቶኛል። በጣም እመክራለሁ!',
        'img'  => asset('images/waja.webp')
    ],
] as $t)
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"{{ $t['text'] }}"</p>
                <div class="testi-author">
                    <img src="{{ $t['img'] }}" alt="{{ $t['name'] }}" class="testi-avatar" style="object-fit:cover;">
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
        <h2>የነገውን የቴክኖሎጂ ስኬትዎን ዛሬ ይጀምሩ!/ <span class="grad-text">Start Today!</span></h2>
        <p>በሺዎች የሚቆጠሩ ተማሪዎች ክህሎታቸውን እያደሱ ይገኛሉ። እርስዎስ ምን ይጠብቃሉ? Join thousands of successful learners today.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-cyan" style="font-size:1.1rem;padding:16px 40px;">በነፃ ተመዝገቡ / Sign Up Free →</a>
        @else
            <a href="#courses" class="btn btn-cyan" style="font-size:1.1rem;padding:16px 40px;">ኮርሶችን ይመልከቱ / View Courses →</a>
        @endguest
    </div>
</div>

@endsection

@push('scripts')
<script>
// Live search: filter course cards on the page
const allCourseData = [
    @foreach($courses as $c)
    { 
        title: @json($c->title), 
        url: @json(route('course.show', $c->slug)), 
        desc: @json(Str::limit($c->description, 80)), 
        price: @json(number_format($c->price_etb) . ' ETB') 
    },
    @endforeach
];

function searchCourses(e, form) {
    e.preventDefault();
    const q = document.getElementById('hero-search').value.trim().toLowerCase();
    if (!q) {
        document.getElementById('search-results').style.display = 'none';
        document.getElementById('courses').scrollIntoView({ behavior: 'smooth' });
        return;
    }

    const filtered = allCourseData.filter(c =>
        c.title.toLowerCase().includes(q) || c.desc.toLowerCase().includes(q)
    );

    const box = document.getElementById('search-results');
    if (filtered.length === 0) {
        box.innerHTML = '<div style="padding:16px;color:var(--muted);text-align:center;">ምንም ኮርስ አልተገኘም / No courses found</div>';
    } else {
        box.innerHTML = filtered.map(c =>
            `<a href="${c.url}" style="display:flex;align-items:center;justify-content:space-between;padding:14px 18px;border-bottom:1px solid var(--border);color:var(--text);gap:12px;">
                <div>
                    <div style="font-weight:600;font-size:0.9rem;">📚 ${c.title}</div>
                    <div style="color:var(--muted);font-size:0.78rem;margin-top:2px;">${c.desc}</div>
                </div>
                <span style="color:var(--cyan);font-weight:700;white-space:nowrap;">${c.price}</span>
            </a>`
        ).join('');
    }
    box.style.display = 'block';
    box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Close search results on outside click
document.addEventListener('click', function(e) {
    if (!e.target.closest('#hero-search') && !e.target.closest('#search-results') && !e.target.closest('form')) {
        document.getElementById('search-results').style.display = 'none';
    }
});

// Live filter as user types
document.getElementById('hero-search')?.addEventListener('input', function() {
    if (this.value.trim() === '') {
        document.getElementById('search-results').style.display = 'none';
    }
});
</script>
@endpush
