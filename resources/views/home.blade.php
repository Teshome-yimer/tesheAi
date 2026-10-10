@extends('layouts.app')
@section('title', 'Tesheai Academy Learn Tech Skills')

@push('styles')
<style>
/* Hero & Compact Top Header */
.hero { padding: 30px 0 20px; text-align: center; position: relative; overflow: hidden; }
.hero::before { content:''; position:absolute; top:-200px; left:50%; transform:translateX(-50%); width:800px; height:800px; background: radial-gradient(circle, rgba(99,102,241,.15) 0%, transparent 70%); pointer-events:none; }
.hero-badge { display:inline-block; background:rgba(99,102,241,.15); border:1px solid rgba(99,102,241,.3); color:var(--indigo); padding:4px 14px; border-radius:99px; font-size:0.75rem; font-weight:600; margin-bottom:12px; }
.hero h1 { font-size:clamp(1.8rem,4vw,2.8rem); font-weight:900; line-height:1.2; margin-bottom:10px; }
.grad-text { background:linear-gradient(135deg, var(--indigo), var(--cyan)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.hero p { font-size:0.95rem; color:var(--muted); max-width:600px; margin:0 auto 16px; line-height:1.5; }

/* Responsive Full-Width Search Bar */
.search-container { max-width: 580px; width: 100%; margin: 15px auto 0; position: relative; padding: 0 10px; }
.search-form { display: flex; background: var(--bg2); border: 1px solid var(--border); border-radius: 50px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
.search-input { flex: 1; min-width: 0; background: transparent; border: none; color: var(--text); padding: 12px 18px; font-size: 0.95rem; outline: none; font-family: inherit; }
.search-btn { background: linear-gradient(135deg, var(--indigo), var(--cyan)); color: #fff; border: none; padding: 12px 22px; cursor: pointer; font-size: 0.95rem; font-weight: 700; white-space: nowrap; flex-shrink: 0; }

/* Grids & Cards */
.section-title { text-align:center; margin-bottom:32px; }
.section-title h2 { font-size:2rem; font-weight:800; margin-bottom:8px; }
.section-title p { color:var(--muted); font-size:0.95rem; }
.courses-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:24px; }
.course-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; overflow:hidden; transition:.3s; }
.course-card:hover { border-color:var(--indigo); transform:translateY(-6px); box-shadow:0 16px 50px rgba(99,102,241,.15); }
.course-thumb { width:100%; height:180px; object-fit:cover; background:linear-gradient(135deg,var(--bg3),var(--border)); display:flex; align-items:center; justify-content:center; font-size:4rem; }
.course-body { padding:20px; }
.course-meta { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px; }
.course-title { font-size:1.1rem; font-weight:700; margin-bottom:8px; line-height:1.3; }
.course-desc { color:var(--muted); font-size:0.85rem; margin-bottom:16px; line-height:1.5; }
.course-price { display:flex; align-items:center; gap:12px; margin-bottom:16px; }
.price-main { font-size:1.4rem; font-weight:800; color:var(--cyan); }
.price-original { font-size:0.9rem; color:var(--muted); text-decoration:line-through; }
.price-badge { background:rgba(16,185,129,.2); color:#10b981; padding:2px 8px; border-radius:4px; font-size:0.75rem; font-weight:700; }

/* Testimonials */
.testimonials-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:24px; }
.testi-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:24px; position:relative; }
.testi-card::before { content:'"'; position:absolute; top:16px; right:20px; font-size:4rem; color:var(--indigo); opacity:.2; line-height:1; font-family:serif; }
.testi-stars { color:#fbbf24; font-size:1rem; margin-bottom:12px; }
.testi-text { color:var(--muted); font-size:0.9rem; line-height:1.6; margin-bottom:16px; }
.testi-author { display:flex; align-items:center; gap:12px; }
.testi-avatar { width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,var(--indigo),var(--cyan)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1rem; color:#fff; }
.testi-name { font-weight:600; font-size:0.9rem; }
.testi-role { color:var(--muted); font-size:0.8rem; }

.feature-card { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:24px; transition:.2s; }
.cta-section { background:linear-gradient(135deg, rgba(99,102,241,.1), rgba(34,211,238,.05)); border:1px solid var(--border); border-radius:20px; padding:50px 20px; text-align:center; margin:50px 0; }
.section-gap { padding: 40px 0; }
</style>
@endpush

@section('content')
<div class="container">
    {{-- Top Compact Hero & Search --}}
    <section class="hero">
        <span class="hero-badge">100% Safe, Focused & Practical</span>
        <h1><span class="grad-text">ከሶሻል ሚዲያ ውዥንብር የጸዳ</span></h1>
        <p>Learn coding, software design, and modern digital skills in English with structured pathways.</p>

        {{-- Search bar --}}
        <div class="search-container">
            <form onsubmit="searchCourses(event, this)" class="search-form">
                <input type="text" id="hero-search" placeholder="eg, JavaScript ..." autocomplete="off" class="search-input">
                <button type="submit" class="search-btn">Search</button>
            </form>
            <div id="search-results" style="display:none; position:absolute; top:115%; left:10px; right:10px; background:var(--bg2); border:1px solid var(--border); border-radius:16px; padding:16px; z-index:100; text-align:left; box-shadow:0 10px 30px rgba(0,0,0,0.4);"></div>
        </div>
    </section>

    {{-- Courses / All Videos Section Immediately Below Search --}}
    <section id="courses" class="section-gap">
        <div class="section-title">
            <h2>All Videos</h2>
            @if(!empty($search))
                <p>🔍 "{{ $search }}" ውጤት: {{ $courses->count() }} ኮርስ(ኮርሶች) ተገኝተዋል — <a href="{{ route('home') }}">Clear</a></p>
            @else
                <p>ለእርስዎ ተስማሚ የሆነውን ትምህርት Video ይመልከቱ</p>
            @endif
        </div>

        <div class="courses-grid">
            @forelse($courses as$course)
                <div class="course-card">
                    @if($course->thumbnail)
                        <img src="{{ Str::startsWith($course->thumbnail, ['http://', 'https://']) ? $course->thumbnail : Storage::disk('s3')->url($course->thumbnail) }}" 
                             alt="{{ $course->title }}" 
                             class="course-thumb" 
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/400x200?text=No+Image';">
                    @else
                        <div class="course-thumb">🎓</div>
                    @endif
                    
                    <div class="course-body">
                        <div class="course-meta">
                            <span class="badge">{{ ucfirst($course->level) }}</span>
                            <span class="badge">{{ $course->language }}</span>
                        </div>
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <p class="course-desc">{{ Str::limit($course->description, 120) }}</p>
                        
                        <div style="display:flex; gap:16px; font-size:0.85rem; color:var(--muted); margin-bottom:16px;">
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

                        <a href="{{ route('course.show', $course->slug) }}" class="btn btn-primary" style="display:block; text-align:center; width:100%;">
                            ዝርዝር ይመልከቱ / View Details →
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: var(--bg2); border-radius: 12px;">
                    <p>አዳዲስ ኮርስ ልንለቅ ነው በትግስት ጠብቁን.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Meet Your Instructor --}}
    <section class="section-gap">
        <div class="section-title">
            <h2>Meet Your Instructor</h2>
            <p>Learn from industry experts / በ 10 ብር ብቻ መማር ይጀምሩ</p>
        </div>
        <div class="feature-card" style="max-width:800px; margin:0 auto; text-align:center;">
            <h3>Teshome</h3>
            <p style="color:var(--cyan); font-weight:600; margin-bottom:16px;">
                የሶፍትዌር ኢንጂነር፣ የቴክኖሎጂ አማካሪ እና የዲጂታል ክህሎቶች አሰልጣኝ<br>
                (Software Engineer, Tech Consultant & Digital Skills Instructor)
            </p>
            <p style="color:var(--muted);">Teshome is a Software Engineer, Tech Consultant, and Lead Instructor with 4+ years of experience building modern digital solutions.</p>
            
            <div style="display:flex; justify-content:center; gap:40px; margin-top:24px;">
                <div>
                    <div style="font-size:1.8rem; font-weight:800; color:var(--indigo);">4+ ዓመት</div>
                    <div style="font-size:0.85rem; color:var(--muted);">Experience</div>
                </div>
                <div>
                    <div style="font-size:1.8rem; font-weight:800; color:var(--cyan);">5,000+</div>
                    <div style="font-size:0.85rem; color:var(--muted);">Students</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="section-gap">
        <div class="section-title">
            <h2>Student Stories</h2>
            <p>Our students share their success stories.</p>
        </div>
        <div class="testimonials-grid">
            @foreach([
                [
                    'name' => 'Abidu from Addis ababa',
                    'role' => 'AI & Software Developer',
                    'text' => 'The YouTube video series was super clear and practical! By watching all the lessons from start to finish, I gained strong coding skills and received my completion Certificate. It is truly a game-changer!',
                ],
                [
                    'name' => 'Kal from DESSIE',
                    'role' => 'Cybersecurity & Cloud Analyst',
                    'text' => 'The blend of Amharic and English made complex tech domains like Cybersecurity, Data Analytics, and Cloud systems effortless to grasp. Truly a life-changing experience for my career in tech!',
                ],
                [
                    'name' => 'Edil From MEKELLE',
                    'role' => 'Tech Freelancer & Consultant',
                    'text' => 'Learning in a focused environment free from social media noise and distractions was a game-changer. I acquired solid technical knowledge and gained the hands-on confidence to actively earn and work as a freelancer today!',
                ],
            ] as $t)
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"{{ $t['text'] }}"</p>
                    <div class="testi-author">
                        <div class="testi-avatar">{{ mb_substr($t['name'], 0, 1) }}</div>
                        <div>
                            <div class="testi-name">{{ $t['name'] }}</div>
                            <div class="testi-role">{{ $t['role'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="cta-section">
        <h2>Start Today!</h2>
        <p>Join thousands of successful learners today.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding:14px 32px; font-weight:700;">Sign Up Free →</a>
        @else
            <a href="#courses" class="btn btn-primary" style="padding:14px 32px; font-weight:700;">View Courses →</a>
        @endguest
    </section>
</div>
@endsection

@push('scripts')
<script>
// Live search: filter course cards on the page
const allCourseData = [
    @foreach($courses as$c)
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
    const box = document.getElementById('search-results');

    if (!q) {
        box.style.display = 'none';
        document.getElementById('courses').scrollIntoView({ behavior: 'smooth' });
        return;
    }

    const filtered = allCourseData.filter(c =>
        c.title.toLowerCase().includes(q) || c.desc.toLowerCase().includes(q)
    );

    if (filtered.length === 0) {
        box.innerHTML = '<p style="margin:0; color:var(--muted);">ምንም ኮርስ አልተገኘም / No courses found</p>';
    } else {
        box.innerHTML = filtered.map(c => `
            <div style="padding: 8px 0; border-bottom: 1px solid var(--border);">
                <a href="${c.url}" style="font-weight: 700; color: var(--indigo); text-decoration: none; display: block;">📚 ${c.title}</a>
                <p style="margin: 4px 0; font-size: 0.85rem; color: var(--muted);">${c.desc}</p>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--cyan);">${c.price}</span>
            </div>
        `).join('');
    }
    box.style.display = 'block';
}

// Close search results on outside click
document.addEventListener('click', function(e) {
    if (!e.target.closest('#hero-search') && !e.target.closest('#search-results') && !e.target.closest('form')) {
        const box = document.getElementById('search-results');
        if (box) box.style.display = 'none';
    }
});

// Live filter as user types
document.getElementById('hero-search')?.addEventListener('input', function() {
    if (this.value.trim() === '') {
        const box = document.getElementById('search-results');
        if (box) box.style.display = 'none';
    }
});
</script>
@endpush
