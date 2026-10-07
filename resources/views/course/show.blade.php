@extends('layouts.app')
@section('title', $course->title)
@push('styles')
<style>
.course-hero { background:linear-gradient(135deg,rgba(99,102,241,.1),rgba(34,211,238,.05)); border-bottom:1px solid var(--border); padding:60px 0; }
.course-layout { display:grid; grid-template-columns:1fr 360px; gap:40px; padding:60px 0; align-items:start; }
.sticky-sidebar { position:sticky; top:90px; }
.sidebar-card { background:var(--bg2); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
.sidebar-preview { position:relative; cursor:pointer; }
.sidebar-preview img, .sidebar-preview-placeholder { width:100%; height:200px; object-fit:cover; background:linear-gradient(135deg,var(--bg3),var(--border)); display:flex; align-items:center; justify-content:center; font-size:4rem; }
.play-btn { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.4); }
.play-btn span { width:64px; height:64px; border-radius:50%; background:var(--indigo); display:flex; align-items:center; justify-content:center; font-size:1.5rem; }
.sidebar-body { padding:24px; }
.price-display { margin-bottom:20px; }
.price-etb { font-size:2rem; font-weight:900; color:var(--cyan); }
.price-usd { color:var(--muted); font-size:0.9rem; margin-top:2px; }
.price-original-etb { font-size:1rem; color:var(--muted); text-decoration:line-through; }
.discount-badge { background:rgba(16,185,129,.2); color:#10b981; padding:4px 12px; border-radius:99px; font-size:0.8rem; font-weight:700; display:inline-block; margin-top:8px; }
.value-stack { list-style:none; margin:20px 0; }
.value-stack li { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid var(--border); font-size:0.9rem; color:var(--muted); }
.value-stack li:last-child { border-bottom:none; }
.value-stack li .icon { color:var(--cyan); font-size:1rem; }
.countdown { background:rgba(99,102,241,.1); border:1px solid rgba(99,102,241,.3); border-radius:8px; padding:14px; text-align:center; margin-bottom:16px; }
.countdown-label { font-size:0.75rem; color:var(--muted); margin-bottom:6px; }
.countdown-timer { display:flex; justify-content:center; gap:8px; font-size:1.3rem; font-weight:800; color:var(--indigo); }
.countdown-unit { background:var(--bg3); border-radius:6px; padding:4px 10px; font-variant-numeric:tabular-nums; }
.curriculum-item { border:1px solid var(--border); border-radius:8px; margin-bottom:8px; overflow:hidden; }
.curriculum-header { background:var(--bg3); padding:16px 20px; cursor:pointer; display:flex; align-items:center; justify-content:space-between; font-weight:600; user-select:none; }
.curriculum-header:hover { background:rgba(99,102,241,.1); }
.curriculum-lessons { display:none; }
.curriculum-lessons.open { display:block; }
.lesson-item { display:flex; align-items:center; gap:12px; padding:12px 20px; border-top:1px solid var(--border); font-size:0.9rem; }
.lesson-item:hover { background:rgba(99,102,241,.05); }
.lesson-icon { color:var(--muted); font-size:0.9rem; }
.free-badge { margin-left:auto; background:rgba(16,185,129,.15); color:#10b981; padding:2px 8px; border-radius:4px; font-size:0.72rem; font-weight:600; }
.instructor-section { background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:32px; margin-bottom:32px; display:flex; gap:24px; align-items:center; }
.instructor-avatar { width:120px; height:120px; border-radius:50%; background:linear-gradient(135deg,var(--indigo),var(--cyan)); display:flex; align-items:center; justify-content:center; font-size:2rem; font-weight:700; flex-shrink:0; }
.faq-item { border:1px solid var(--border); border-radius:8px; margin-bottom:8px; overflow:hidden; }
.faq-q { padding:16px 20px; cursor:pointer; font-weight:600; display:flex; justify-content:space-between; background:var(--bg3); }
.faq-a { padding:16px 20px; color:var(--muted); font-size:0.9rem; line-height:1.6; display:none; }
.faq-a.open { display:block; }
@media(max-width:900px) { .course-layout { grid-template-columns:1fr; } .sticky-sidebar { position:static; } }
</style>
@endpush
@section('content')

<div class="course-hero">
    <div class="container">
        <div style="max-width:720px;">
            <div style="display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap;">
                <span class="badge badge-indigo">{{ ucfirst($course->level) }}</span>
                <span class="badge badge-cyan">{{ $course->language }}</span>
                @if($course->is_featured) <span class="badge" style="background:rgba(251,191,36,.2);color:#fbbf24;">⭐ Featured</span> @endif
            </div>
            <h1 style="font-size:clamp(1.8rem,4vw,3rem);font-weight:900;line-height:1.2;margin-bottom:16px;">{{ $course->title }}</h1>
            <p style="color:var(--muted);font-size:1.05rem;line-height:1.7;margin-bottom:24px;">{{ Str::limit($course->description, 200) }}</p>
            <div style="display:flex;gap:24px;flex-wrap:wrap;color:var(--muted);font-size:0.9rem;">
                <span>📚 {{ $course->total_lessons }} ትምህርቶች</span>
                <span>⏱ {{ $course->total_hours }} ሰዓት</span>
                <span>👥 {{ $course->enrollments->count() }}+ ተማሪዎች</span>
                <span>⭐ 4.9 ደረጃ</span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="course-layout">

        {{-- Main Content --}}
        <div>
            {{-- What You Learn --}}
            @if($course->what_you_learn)
            <div class="card" style="padding:28px;margin-bottom:32px;">
                <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:20px;"> What You'll Learn</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:12px;">
                    @foreach($course->what_you_learn as $item)
                    <div style="display:flex;align-items:start;gap:10px;font-size:0.9rem;">
                        <span style="color:var(--cyan);margin-top:2px;">✓</span>
                        <span>{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Curriculum --}}
            <div style="margin-bottom:32px;">
                <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:20px;"> Curriculum</h2>
                @forelse($course->sections as $section)
                <div class="curriculum-item">
                    <div class="curriculum-header" onclick="toggleSection(this)">
                        <span>📂 {{ $section->title }}</span>
                        <span style="color:var(--muted);font-size:0.85rem;">{{ $section->lessons->count() }} ትምህርቶች ▼</span>
                    </div>
                    <div class="curriculum-lessons">
                        @foreach($section->lessons as $lesson)
                        <div class="lesson-item">
                            <span class="lesson-icon">▶</span>
                            <span>{{ $lesson->title }}</span>
                            <span style="color:var(--muted);font-size:0.8rem;margin-left:auto;">{{ $lesson->duration_minutes }}min</span>
                            @if($lesson->is_free_preview)
                            <span class="free-badge">FREE</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <p style="color:var(--muted);"> Content coming soon</p>
                @endforelse
            </div>

            <div class="instructor-section" style="margin-bottom:32px;">
            <img src="{{ asset('tesheai_style_5_sunset_startup.webp') }}" alt="Teshome" class="instructor-avatar" style="object-fit:cover; object-position:top; border:2px solid var(--indigo);">
                <div>
                    <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:4px;"> Teshome</h3>
                    <p style="color:var(--cyan);font-size:0.85rem;margin-bottom:12px;font-weight:600;">   የሶፍትዌር ኢንጂነር፣ የቴክኖሎጂ አማካሪ እና የዲጂታል ክህሎቶች አሰልጣኝ
(Software Engineer, Tech Consultant & Digital Skills Instructor)  </p>
                    <p style="color:var(--muted);font-size:0.9rem;line-height:1.6;">  Teshome is a Software Engineer, Tech Consultant, and Lead Instructor with 4+ years of experience building modern digital solutions.  
              </p>
                </div>
            </div>

            {{-- Testimonials --}}
            <div style="margin-bottom:32px;">
                <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:20px;"> Student Reviews</h2>
                <div style="display:grid;gap:16px;">
                @foreach([
    ['name'=>'Eyob from Kobo','text'=>'ከሁሉ ጥሩ ኮርስ ነው! ምዝገባዬ ሕይወቴን ቀይሯል።','img'=>asset('images/kidan.webp')],
    ['name'=>'Mengesha from Bahir dar','text'=>'The videos are very clear. I landed a job after 2 months!','img'=>asset('images/photo_7_2026-10-07_15-55-15.webp')],
    ['name'=>' Kasahun from Dessie','text'=>'በጣም ግልጽ የሆነ ማብራሪያ ነው። ለጀማሪዎች ይመከራል።','img'=>asset('images/photo_5_2026-10-07_15-55-15.webp')],
] as $r)
                    <div class="card" style="padding:20px;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                            <img src="{{ $r['img'] }}" alt="{{ $r['name'] }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:1px solid var(--border);">
                            <div>
                                <div style="font-weight:600;font-size:0.9rem;">{{ $r['name'] }}</div>
                                <div style="color:#fbbf24;font-size:0.8rem;">★★★★★</div>
                            </div>
                        </div>
                        <p style="color:var(--muted);font-size:0.9rem;">"{{ $r['text'] }}"</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- FAQ --}}
            <div>
                <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:20px;">ተደጋጋሚ ጥያቄዎች </h2>
                @foreach([
                    ['q'=>'ኮርሱን ለምን ያህል ጊዜ ይቀጥላሉ? / How long do I have access?','a'=>'ለዘለዓለም! / Lifetime access once you enroll.'],
                    ['q'=>'ሰርተፍኬት ይሰጣሉ? / Do you provide a certificate?','a'=>'አዎ፣ ኮርሱ ሲጠናቀቅ ሰርቲፊኬት ያገኛሉ። Yes, you get a completion certificate.'],
                    ['q'=>'ኢንተርኔት ሳይኖር ማጥናት ይቻላሉ? / Can I study offline?','a'=>'አሁን ለጊዜው አይደለም ነገር ግን ቪዲዮዎቹ በ HD ናቸው። Videos stream in HD.'],
                    ['q'=>'Money-back guarantee አለ? / Is there a refund policy?','a'=>'አዎ፣ 7-day money back guarantee አለ። Yes, 7-day refund policy.'],
                ] as $faq)
                <div class="faq-item">
                    <div class="faq-q" onclick="toggleFaq(this)">{{ $faq['q'] }} <span>+</span></div>
                    <div class="faq-a">{{ $faq['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Sticky Sidebar --}}
        <div class="sticky-sidebar">
            <div class="sidebar-card">
                @if($course->preview_video)
                <div style="position:relative;">
                    <!-- አዲሱ የተስተካከለው ኮድ: -->
<iframe src="{{ $course->preview_video }}" loading="lazy" style="width:100%;height:200px;border:none;" allowfullscreen></iframe>
                </div>
                @else
                <div style="height:180px;background:linear-gradient(135deg,var(--bg3),var(--border));display:flex;align-items:center;justify-content:center;font-size:5rem;">🎓</div>
                @endif

                <div class="sidebar-body">
                    <div class="countdown">
                        <div class="countdown-label">⏰ ዋጋው ይቀንሳል / Offer ends in</div>
                        <div class="countdown-timer">
                            <div class="countdown-unit" id="cd-h">00</div>:
                            <div class="countdown-unit" id="cd-m">30</div>:
                            <div class="countdown-unit" id="cd-s">00</div>
                        </div>
                    </div>

                    <div class="price-display">
                        <div class="price-etb">{{ number_format($course->price_etb) }} ETB</div>
                        <div class="price-usd">${{ $course->price_usd }} USD</div>
                        @if($course->original_price_etb)
                        <div style="display:flex;align-items:center;gap:10px;margin-top:6px;">
                            <span class="price-original-etb">{{ number_format($course->original_price_etb) }} ETB</span>
                            <span class="discount-badge">{{ $course->discountPercentageEtb() }}% ቅናሽ</span>
                        </div>
                        @endif
                    </div>

                    @if($isEnrolled)
                        <a href="{{ route('student.course', $course->slug) }}" class="btn btn-cyan" style="width:100%;justify-content:center;margin-bottom:12px;">▶ ትምህርቱን ቀጥሉ / Continue Learning</a>
                    @else
                        <a href="{{ route('checkout', $course->slug) }}" class="btn btn-cyan" style="width:100%;justify-content:center;margin-bottom:12px;">🛒 አሁን ምዝገቡ / Enroll Now</a>
                    @endif

                    <ul class="value-stack">
                        <li><span class="icon">🎥</span> {{ $course->total_lessons }} HD ቪዲዮዎች</li>
                        <li><span class="icon">⏱</span> {{ $course->total_hours }} ሰዓት ይዘት</li>
                        <li><span class="icon">📱</span> Mobile + Desktop access</li>
                        <li><span class="icon">♾</span> Lifetime access</li>
                        <li><span class="icon">🏆</span> Certificate of completion</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@push('scripts')
<script>
function toggleSection(el) {
    const content = el.nextElementSibling;
    content.classList.toggle('open');
}
function toggleFaq(el) {
    const content = el.nextElementSibling;
    content.classList.toggle('open');
    el.querySelector('span').textContent = content.classList.contains('open') ? '−' : '+';
}

// Countdown timer
let totalSeconds = 30 * 60;
const cdH = document.getElementById('cd-h');
const cdM = document.getElementById('cd-m');
const cdS = document.getElementById('cd-s');
function updateCountdown() {
    if (totalSeconds <= 0) { clearInterval(timer); return; }
    totalSeconds--;
    const h = Math.floor(totalSeconds / 3600);
    const m = Math.floor((totalSeconds % 3600) / 60);
    const s = totalSeconds % 60;
    cdH.textContent = String(h).padStart(2,'0');
    cdM.textContent = String(m).padStart(2,'0');
    cdS.textContent = String(s).padStart(2,'0');
}
const timer = setInterval(updateCountdown, 1000);

// Open first section
document.querySelector('.curriculum-header')?.click();
</script>
@endpush
