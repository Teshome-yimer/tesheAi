@push('scripts')
<script src="https://www.youtube.com/iframe_api"></script>
<script>
const LESSON_ID = {{ $lesson->id }};
const COURSE_ID = {{ $course->id }};
const IS_COMPLETED = {{ $isCompleted ? 'true' : 'false' }};
const CSRF     = document.querySelector('meta[name=csrf-token]').content;

// ── 1. OKUZIYIZA RIGHT-CLICK N'OKULABA INSPECT (F12) ──
document.addEventListener('contextmenu', event => event.preventDefault());
document.addEventListener('keydown', function(e) {
    if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'C' || e.key === 'J')) || (e.ctrlKey && e.key === 'U')) {
        e.preventDefault();
        alert('Okukola kino kiziyiziddwa ku mukutu guno!');
    }
});

// ── 2. OKUTEERAWO WATERMARK EGYETOOLOOLA (Dynamic Watermarking) ──
// Kino kissa ebifaananyi oba amannya g'omuyizi (nga email oba ID) ku video
window.addEventListener('DOMContentLoaded', () => {
    const videoWrap = document.querySelector('.video-wrap');
    if (videoWrap) {
        const watermark = document.createElement('div');
        watermark.style.position = 'absolute';
        watermark.style.top = '20px';
        watermark.style.left = '20px';
        watermark.style.color = 'rgba(255, 255, 255, 0.3)';
        watermark.style.fontSize = '14px';
        watermark.style.fontWeight = 'bold';
        watermark.style.pointerEvents = 'none';
        watermark.style.zIndex = '9999';
        watermark.innerText = '{{ auth()->user()->email ?? "TesheAi Academy Student" }}';
        
        videoWrap.style.position = 'relative';
        videoWrap.appendChild(watermark);

        // Okusobola okukyusa ekifo kya watermark buli luvannyuma lw'akatono
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
        alert('Ebaakon kigezi okugenda mu maaso okola nga tonamala kulaba vidiyo eno okutuuka ku nkomerero!');
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
