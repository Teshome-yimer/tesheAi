@extends('layouts.app')

{{-- 🎯 አድራሻው (URL) ላይ 'vip-telegram-access' ካለ በቀጥታ ወደ Telegram ያዞረዋል --}}
@if(str_contains(request()->url(), 'vip-telegram-access'))
    <script>
        window.location.replace("https://t.me/+qDjJMxPexn03NmQ8");
    </script>
@endif

@section('title', $lesson->title . ' - ' . $course->title)
@push('styles')
<style>
.viewer-wrap { display:grid; grid-template-columns:300px 1fr; height:calc(100vh - 65px); overflow:hidden; }
.sidebar { overflow-y:auto; background:var(--bg2); border-right:1px solid var(--border); display:flex; flex-direction:column; }
.sidebar-head { padding:16px; border-bottom:1px solid var(--border); position:sticky; top:0; background:var(--bg2); z-index:5; }
.sidebar-head h3 { font-size:0.85rem; font-weight:700; margin-bottom:8px; color:var(--text); line-height:1.3; }
.prog-label { display:flex; justify-content:space-between; font-size:0.72rem; color:var(--muted); margin-top:6px; }
.sec-title { padding:8px 14px; background:var(--bg3); font-size:0.72rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; border-bottom:1px solid var(--border); }
.l-item { display:flex; align-items:center; gap:10px; padding:10px 14px; border-left:3px solid transparent; text-decoration:none; color:var(--text); font-size:0.83rem; transition:.15s; border-bottom:1px solid rgba(255,255,255,.03); }
.l-item:hover { background:rgba(99,102,241,.08); color:var(--text); }
.l-item.active { background:rgba(99,102,241,.12); border-left-color:var(--indigo); color:var(--indigo); }
.l-item.done .check { border-color:var(--success); background:rgba(16,185,129,.2); color:var(--success); }
.check { width:18px; height:18px; border-radius:50%; border:2px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:0.65rem; flex-shrink:0; }
.l-dur { margin-left:auto; color:var(--muted); font-size:0.73rem; flex-shrink:0; }

/* Main area */
.main-area { overflow-y:auto; display:flex; flex-direction:column; }
.topbar { padding:12px 20px; border-bottom:1px solid var(--border); background:var(--bg2); display:flex; align-items:center; justify-content:space-between; gap:12px; flex-shrink:0; }
.video-wrap { position:relative; padding-bottom:56.25%; background:#000; flex-shrink:0; }
.video-wrap iframe { position:absolute; inset:0; width:100%; height:100%; border:none; }
.no-video { padding-bottom:30%; background:linear-gradient(135deg,#13131a,#1a1a24); display:flex; align-items:center; justify-content:center; flex-direction:column; gap:12px; color:var(--muted); }

/* Instructor card */
.instructor-card { display:flex; align-items:center; gap:14px; background:var(--bg2); border:1px solid var(--border); border-radius:12px; padding:16px 20px; margin:20px 20px 0; }
.inst-avatar { width:52px; height:52px; border-radius:50%; object-fit:cover; background:linear-gradient(135deg,var(--indigo),var(--cyan)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.2rem; flex-shrink:0; }
.inst-name { font-weight:700; font-size:0.95rem; }
.inst-role { color:var(--cyan); font-size:0.8rem; margin-top:2px; }
.inst-bio { color:var(--muted); font-size:0.82rem; margin-top:4px; line-height:1.5; }

.lesson-body { padding:20px; flex:1; }
.lesson-desc { color:var(--muted); line-height:1.7; font-size:0.9rem; margin-bottom:20px; }
.nav-btns { display:flex; justify-content:space-between; gap:12px; padding:16px 20px; border-top:1px solid var(--border); background:var(--bg2); flex-shrink:0; }

/* Locked/Disabled button styling */
.btn:disabled, .btn[disabled] {
    opacity: 0.5;
    cursor: not-allowed !important;
    pointer-events: auto !important;
}

@media(max-width:768px) {
    .viewer-wrap { grid-template-columns:1fr; }
    .sidebar { max-height:260px; border-right:none; border-bottom:1px solid var(--border); }
}
</style>
@endpush

@section('content')
<div class="viewer-wrap">

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-head">
            <h3>{{ $course->title }}</h3>
            <div class="progress-bar"><div class="progress-fill" id="prog-fill" style="width:{{ $progress['percentage'] }}%"></div></div>
            <div class="prog-label"><span>{{ $progress['completed'] }}/{{ $progress['total'] }} lessons</span><span id="prog-pct">{{ $progress['percentage'] }}%</span></div>
        </div>

        @foreach($course->sections as $section)
        <div>
            <div class="sec-title">{{ $section->title }}</div>
            @foreach($section->lessons as $sl)
            @php $done = in_array($sl->id, $completedIds); $cur = $sl->id == $lesson->id; @endphp
            <a href="{{ route('student.lesson', [$course->slug, $sl->slug ?? $sl->id]) }}"
               class="l-item {{ $cur ? 'active' : '' }} {{ $done ? 'done' : '' }}">
                <div class="check">{{ $done ? '✓' : '' }}</div>
                <span style="flex:1;line-height:1.3;">{{ $sl->title }}</span>
                <span class="l-dur">{{ $sl->duration_minutes }}m</span>
            </a>
            @endforeach
        </div>
        @endforeach
    </div>

    {{-- Main Area --}}
    <div class="main-area">
        <div class="topbar">
            <div>
                <div style="font-size:0.75rem;color:var(--muted);">{{ $course->title }}</div>
                <div style="font-weight:700;font-size:0.95rem;">{{ $lesson->title }}</div>
            </div>
            <button id="complete-btn" onclick="markComplete()"
                class="btn {{ $isCompleted ? 'btn-secondary' : 'btn-primary' }} btn-sm"
                {{ $isCompleted ? 'disabled' : 'disabled' }}>
                {{ $isCompleted ? '✅ Completed' : '🔒 Finish Video First' }}
            </button>
        </div>

        {{-- Video Section --}}
        @if($lesson->video_type === 'local' && $lesson->video_path)
        <div class="video-wrap">
            <video id="lesson-video" controls controlslist="nodownload"
                   style="position:absolute;inset:0;width:100%;height:100%;background:#000;"
                   preload="auto" playsinline webkit-playsinline x5-playsinline
                   oncontextmenu="return false;">
                <source src="{{ route('student.video.stream', $lesson) }}" type="video/mp4">
                የእርስዎ ብራውዘር ቪዲዮ ማጫወቻውን መደገፍ አልቻለም።
            </video>
        </div>
        @elseif($lesson->video_url)
            @php
                $videoUrl = $lesson->video_url;
                $embedUrl = '';
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match);
                $videoId = $match[1] ?? null;
                if ($videoId) {
                    $embedUrl = "https://www.youtube.com/embed/{$videoId}?enablejsapi=1&rel=0&modestbranding=1";
                } else {
                    $embedUrl = $videoUrl;
                }
            @endphp
            <div class="video-wrap">
                <iframe id="lesson-iframe" src="{{ $embedUrl }}"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        @else
        <div style="padding:60px 0;background:linear-gradient(135deg,#13131a,#1a1a24);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px;color:var(--muted);">
            <div style="font-size:3rem;">🎥</div>
            <div>Video coming soon</div>
        </div>
        @endif

        {{-- Elapsed time bar (local video only) --}}
        @if($lesson->video_type === 'local' && $lesson->video_path)
        <div id="elapsed-bar" style="background:var(--bg3);padding:10px 20px;display:flex;align-items:center;gap:12px;font-size:0.82rem;color:var(--muted);">
            <span>⏱</span>
            <div style="flex:1;background:var(--bg2);border-radius:99px;height:4px;overflow:hidden;">
                <div id="elapsed-fill" style="height:100%;background:var(--indigo);border-radius:99px;width:0%;transition:width .5s;"></div>
            </div>
            <span id="elapsed-text">0:00 / 0:00</span>
        </div>
        @endif

        {{-- Instructor Info --}}
        <div class="instructor-card">
            <div class="inst-avatar">T</div>
            <div>
                <div class="inst-name">Teshe Yimer</div>
                <div class="inst-role">Senior Full Stack Developer</div>
                <div class="inst-bio">Full-Stack (Node.js, Express.js, PHP(laravel), React, Vue.js, Databases,API & DevOps) ባለሙያ • 4+ ዓመት ልምድ • 5,000+ ተማሪዎች</div>
            </div>
        </div>

        {{-- Lesson content --}}
        <div class="lesson-body">
            @if($lesson->description)
            <p class="lesson-desc">{{ $lesson->description }}</p>
            @endif

            {{-- Files / Downloads --}}
            @php $files = $lesson->files; @endphp
            @if($files->count() > 0)
            <div style="margin-top:8px;">
                <h3 style="font-size:0.95rem;font-weight:700;margin-bottom:12px;color:var(--cyan);">📎 Downloads</h3>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($files as $file)
                    @php
                        $canDownload = $file->is_free || (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isEnrolledIn($file->course_id)));
                    @endphp
                    <div style="display:flex;align-items:center;gap:12px;background:var(--bg3);border:1px solid var(--border);border-radius:8px;padding:12px 16px;">
                        <span style="font-size:1.5rem;">{{ $file->icon }}</span>
                        <div style="flex:1;">
                            <div style="font-weight:600;font-size:0.88rem;">{{ $file->title }}</div>
                            <div style="color:var(--muted);font-size:0.75rem;">{{ strtoupper($file->file_type) }} · {{ $file->file_size_formatted }}
                                @if($file->is_free) · <span style="color:var(--success);">🔓 Free</span> @endif
                            </div>
                        </div>
                        @if($canDownload)
                        <a href="{{ route('files.download', $file) }}" class="btn btn-primary btn-sm">⬇ Download</a>
                        @else
                        <a href="{{ route('checkout', $course->slug) }}" class="btn btn-secondary btn-sm">🔒 Enroll</a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Nav --}}
        <div class="nav-btns">
            @if($prevLesson)
            <a href="{{ route('student.lesson', [$course->slug, $prevLesson->slug ?? $prevLesson->id]) }}" class="btn btn-secondary">← ቀዳሚ</a>
            @else <div></div> @endif

            @if($nextLesson)
            <a href="{{ route('student.lesson', [$course->slug, $nextLesson->slug ?? $nextLesson->id]) }}"
               id="next-btn" class="btn btn-primary {{ $isCompleted ? '' : 'disabled' }}" 
               onclick="markAndNext(event, this.href)">
                ቀጣይ → Next
            </a>
            @else
            <a href="{{ route('student.dashboard') }}" class="btn btn-cyan">🏆 Course Complete!</a>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://www.youtube.com/iframe_api"></script>
<script>
const LESSON_ID = {{ $lesson->id }};
const COURSE_ID = {{ $course->id }};
const IS_COMPLETED = {{ $isCompleted ? 'true' : 'false' }};
const CSRF     = document.querySelector('meta[name=csrf-token]').content;

// ── 1. የቀኝ ክሊክ እና F12 እገዳ ──
document.addEventListener('contextmenu', event => event.preventDefault());
document.addEventListener('keydown', function(e) {
    if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'C' || e.key === 'J')) || (e.ctrlKey && e.key === 'U')) {
        e.preventDefault();
        alert('ይህ ድርጊት በዚህ ድረ-ገጽ ላይ የተከለከለ ነው!');
    }
});

// ── 2. የተለዋዋጭ የውሃ ምልክት (Dynamic Watermarking) ──
window.addEventListener('DOMContentLoaded', () => {
    const videoWrap = document.querySelector('.video-wrap');
    if (videoWrap) {
        const watermark = document.createElement('div');
        watermark.style.position = 'absolute';
        watermark.style.top = '20px';
        watermark.style.left = '20px';
        watermark.style.color = 'rgba(255, 255, 255, 0.35)';
        watermark.style.fontSize = '14px';
        watermark.style.fontWeight = 'bold';
        watermark.style.pointerEvents = 'none';
        watermark.style.zIndex = '9999';
        watermark.innerText = '{{ auth()->user()->email ?? "TesheAi Academy Student" }}';
        
        videoWrap.style.position = 'relative';
        videoWrap.appendChild(watermark);

        setInterval(() => {
            const randomTop = Math.floor(Math.random() * 80);
            const randomLeft = Math.floor(Math.random() * 80);
            watermark.style.top = randomTop + '%';
            watermark.style.left = randomLeft + '%';
        }, 5000);
    }
});

function unlockCompletionButtons() {
    const btn = document.getElementById('complete-btn');
    const nextBtn = document.getElementById('next-btn');

    if (btn && btn.textContent.includes('Finish Video')) {
        btn.disabled = false;
        btn.textContent = '✓ Mark Complete';
        btn.classList.replace('btn-secondary', 'btn-primary');
    }
    if (nextBtn) {
        nextBtn.classList.remove('disabled');
    }
}

async function markComplete() {
    const btn = document.getElementById('complete-btn');
    if (btn.disabled) return;

    btn.disabled = true; btn.textContent = '...';
    const res  = await fetch('{{ route("student.progress.complete") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ lesson_id: LESSON_ID, course_id: COURSE_ID })
    });
    const data = await res.json();
    if (data.success) {
        btn.textContent = '✅ Completed';
        btn.classList.replace('btn-primary', 'btn-secondary');
        document.querySelectorAll('.l-item.active .check').forEach(c => { c.textContent = '✓'; c.closest('.l-item').classList.add('done'); });
        document.getElementById('prog-fill').style.width = data.progress.percentage + '%';
        document.getElementById('prog-pct').textContent  = data.progress.percentage + '%';
        
        const nextBtn = document.getElementById('next-btn');
        if (nextBtn) nextBtn.classList.remove('disabled');
    }
}

async function markAndNext(e, nextUrl) {
    const nextBtn = document.getElementById('next-btn');
    if (nextBtn && nextBtn.classList.contains('disabled')) {
        e.preventDefault();
        alert('እባክዎን ቀጣይ ከመሄድዎ በፊት ቪዲዮውን እስከ መጨረሻው ይመልከቱ!');
        return;
    }

    if (document.getElementById('complete-btn').textContent.includes('Mark')) {
        e.preventDefault();
        await markComplete();
        setTimeout(() => window.location = nextUrl, 400);
    }
}

let ytPlayer;
function onYouTubeIframeAPIReady() {
    const iframe = document.getElementById('lesson-iframe');
    if (iframe && !IS_COMPLETED) {
        ytPlayer = new YT.Player('lesson-iframe', {
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    } else if (IS_COMPLETED) {
        unlockCompletionButtons();
    }
}

function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.ENDED) {
        unlockCompletionButtons();
        markComplete();
    }
}

function fmtTime(s) {
    s = Math.floor(s);
    const m = Math.floor(s / 60);
    const sec = s % 60;
    return m + ':' + String(sec).padStart(2, '0');
}

const video = document.getElementById('lesson-video');
if (video) {
    let lastSave = 0;

    if (IS_COMPLETED) {
        unlockCompletionButtons();
    }

    video.addEventListener('timeupdate', () => {
        const pct  = video.duration ? (video.currentTime / video.duration) * 100 : 0;
        const fill = document.getElementById('elapsed-fill');
        const txt  = document.getElementById('elapsed-text');
        if (fill) fill.style.width = pct + '%';
        if (txt)  txt.textContent  = fmtTime(video.currentTime) + ' / ' + fmtTime(video.duration || 0);

        if (Math.floor(video.currentTime) - lastSave >= 10) {
            lastSave = Math.floor(video.currentTime);
            fetch('{{ route("student.progress.update") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ lesson_id: LESSON_ID, course_id: COURSE_ID, watched_seconds: Math.floor(video.currentTime) })
            });
        }
    });

    video.addEventListener('timeupdate', () => {
        if (video.duration && (video.currentTime / video.duration) >= 0.9) {
            unlockCompletionButtons();
            const btn = document.getElementById('complete-btn');
            if (btn && btn.textContent.includes('Mark')) {
                markComplete();
            }
        }
    });
}
</script>
@endpush
