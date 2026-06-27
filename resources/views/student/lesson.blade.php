@extends('layouts.app')
@section('title', $lesson->title . ' - ' . $course->title)
@push('styles')
<style>
.viewer-layout { display:grid; grid-template-columns:320px 1fr; height:calc(100vh - 70px); overflow:hidden; }
.sidebar-lessons { overflow-y:auto; border-right:1px solid var(--border); background:var(--bg2); }
.sidebar-header { padding:20px; border-bottom:1px solid var(--border); position:sticky; top:0; background:var(--bg2); z-index:10; }
.sidebar-header h3 { font-size:0.9rem; font-weight:700; margin-bottom:10px; }
.sidebar-section { border-bottom:1px solid var(--border); }
.sidebar-section-title { padding:12px 16px; background:var(--bg3); font-size:0.8rem; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; }
.sidebar-lesson { display:flex; align-items:center; gap:10px; padding:12px 16px; font-size:0.85rem; cursor:pointer; transition:.15s; border-left:3px solid transparent; text-decoration:none; color:var(--text); }
.sidebar-lesson:hover { background:rgba(99,102,241,.08); }
.sidebar-lesson.active { background:rgba(99,102,241,.12); border-left-color:var(--indigo); color:var(--indigo); }
.sidebar-lesson.completed .check { color:var(--success); }
.sidebar-lesson .check { width:18px; height:18px; border-radius:50%; border:2px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:0.7rem; flex-shrink:0; }
.sidebar-lesson.completed .check { border-color:var(--success); background:rgba(16,185,129,.2); }
.lesson-main { overflow-y:auto; }
.lesson-topbar { padding:16px 28px; border-bottom:1px solid var(--border); background:var(--bg2); display:flex; align-items:center; justify-content:space-between; gap:16px; }
.video-wrap { position:relative; padding-bottom:56.25%; background:#000; }
.video-wrap iframe { position:absolute; inset:0; width:100%; height:100%; border:none; }
.lesson-content { padding:32px; max-width:860px; }
.lesson-nav { display:flex; gap:12px; justify-content:space-between; margin-top:28px; }
@media(max-width:768px) {
    .viewer-layout { grid-template-columns:1fr; }
    .sidebar-lessons { max-height:300px; border-right:none; border-bottom:1px solid var(--border); }
}
</style>
@endpush
@section('content')
@php $progressPct = $progress['percentage']; @endphp

<div class="viewer-layout" style="height:calc(100vh - 65px);">

    {{-- Sidebar --}}
    <div class="sidebar-lessons">
        <div class="sidebar-header">
            <h3>{{ Str::limit($course->title, 30) }}</h3>
            <div class="progress-bar"><div class="progress-fill" style="width:{{ $progressPct }}%"></div></div>
            <div style="text-align:right;font-size:0.75rem;color:var(--muted);margin-top:4px;">{{ $progressPct }}% complete</div>
        </div>

        @foreach($course->sections as $section)
        <div class="sidebar-section">
            <div class="sidebar-section-title">📂 {{ $section->title }}</div>
            @foreach($section->lessons as $sLesson)
            @php $isComp = in_array($sLesson->id, $completedIds); $isCurr = $sLesson->id == $lesson->id; @endphp
            <a href="{{ route('student.lesson', [$course->slug, $sLesson->slug ?? $sLesson->id]) }}"
               class="sidebar-lesson {{ $isCurr ? 'active' : '' }} {{ $isComp ? 'completed' : '' }}">
                <div class="check">{{ $isComp ? '✓' : '' }}</div>
                <span style="flex:1;line-height:1.3;">{{ $sLesson->title }}</span>
                <span style="color:var(--muted);font-size:0.75rem;">{{ $sLesson->duration_minutes }}m</span>
            </a>
            @endforeach
        </div>
        @endforeach
    </div>

    {{-- Main lesson area --}}
    <div class="lesson-main">
        <div class="lesson-topbar">
            <div>
                <div style="font-size:0.8rem;color:var(--muted);margin-bottom:2px;">{{ $course->title }}</div>
                <h2 style="font-size:1rem;font-weight:700;">{{ $lesson->title }}</h2>
            </div>
            <button id="complete-btn" onclick="markComplete()"
                class="btn {{ $isCompleted ? 'btn-secondary' : 'btn-primary' }} btn-sm"
                {{ $isCompleted ? 'disabled' : '' }}>
                {{ $isCompleted ? '✅ Completed' : '✓ Mark Complete' }}
            </button>
        </div>

        @if($lesson->video_url)
        <div class="video-wrap">
            <iframe src="{{ $lesson->video_url }}" allowfullscreen allow="autoplay; encrypted-media"></iframe>
        </div>
        @endif

        <div class="lesson-content">
            @if($lesson->description)
            <p style="color:var(--muted);line-height:1.7;margin-bottom:24px;">{{ $lesson->description }}</p>
            @endif

            <div class="lesson-nav">
                @if($prevLesson)
                <a href="{{ route('student.lesson', [$course->slug, $prevLesson->slug ?? $prevLesson->id]) }}" class="btn btn-secondary">← ቀዳሚ / Prev</a>
                @else
                <div></div>
                @endif
                @if($nextLesson)
                <a href="{{ route('student.lesson', [$course->slug, $nextLesson->slug ?? $nextLesson->id]) }}" class="btn btn-primary">ቀጣይ / Next →</a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
const LESSON_ID = {{ $lesson->id }};
const COURSE_ID = {{ $course->id }};

async function markComplete() {
    const btn = document.getElementById('complete-btn');
    btn.disabled = true; btn.textContent = 'Saving...';
    const res = await fetch('{{ route("student.progress.complete") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
        body: JSON.stringify({ lesson_id: LESSON_ID, course_id: COURSE_ID })
    });
    const data = await res.json();
    if (data.success) {
        btn.textContent = '✅ Completed';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-secondary');
        // Update sidebar check
        const sidebarItems = document.querySelectorAll('.sidebar-lesson');
        sidebarItems.forEach(item => {
            if (item.classList.contains('active')) {
                item.classList.add('completed');
                item.querySelector('.check').textContent = '✓';
            }
        });
        // Update progress bar
        const pct = data.progress.percentage;
        document.querySelector('.progress-fill').style.width = pct + '%';
        document.querySelector('.sidebar-header div[style*="text-align:right"]').textContent = pct + '% complete';
    }
}
</script>
@endpush
