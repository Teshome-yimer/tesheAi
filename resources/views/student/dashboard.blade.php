@extends('layouts.app')
@section('title', 'Student Dashboard')
@push('styles')
<style>
.dash-header { padding:48px 0 32px; border-bottom:1px solid var(--border); margin-bottom:40px; }
.dash-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:24px; }
.enroll-card { background:var(--bg2); border:1px solid var(--border); border-radius:14px; overflow:hidden; transition:.3s; }
.enroll-card:hover { border-color:var(--indigo); transform:translateY(-4px); }
.enroll-thumb { width:100%; height:160px; object-fit:cover; background:linear-gradient(135deg,var(--bg3),var(--border)); display:flex; align-items:center; justify-content:center; font-size:3.5rem; }
.enroll-body { padding:20px; }
.enroll-title { font-weight:700; font-size:1rem; margin-bottom:10px; }
.enroll-progress-label { display:flex; justify-content:space-between; font-size:0.8rem; color:var(--muted); margin-bottom:6px; }
</style>
@endpush
@section('content')

<div class="container">
    <div class="dash-header">
        <p style="color:var(--cyan);font-size:0.9rem;margin-bottom:6px;">👋 እንኳን ደህና መጡ / Welcome back</p>
        <h1 style="font-size:2rem;font-weight:900;">{{ auth()->user()->name }}</h1>
        <p style="color:var(--muted);margin-top:8px;">{{ $enrollments->count() }} courses enrolled</p>
    </div>

    @if($enrollments->isEmpty())
    <div style="text-align:center;padding:60px 20px; background:var(--bg2); border:1px solid var(--border); border-radius:16px; max-width:600px; margin:0 auto;">
        <div style="font-size:4rem;margin-bottom:16px;">🎓</div>
        <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:12px;line-height:1.6;">
            በነፃ ሰርተፍኬት (Certificate) ለማግኘት ከታች ያለውን በመጫወት ኮርሶቹን ይጀምሩ!
        </h2>
        <p style="color:var(--muted);margin-bottom:24px;font-size:0.9rem;">
            ማስታወሻ፡ ሰርተፍኬት ለማግኘት የቪዲዮ ትምህርቶቹን ሙሉ በሙሉ መከታተል ይኖርብዎታል።
        </p>
        <a href="/" class="btn btn-cyan" style="padding:12px 24px;font-weight:bold;"> All Courses / All Videos </a>
    </div>
    @else
    <div class="dash-grid">
        @foreach($enrollments as $enrollment)
        @php $progress = $enrollment->progress; @endphp
        <div class="enroll-card">
            @if($enrollment->course->thumbnail)
                <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}" class="enroll-thumb">
            @else
                <div class="enroll-thumb">🎓</div>
            @endif
            <div class="enroll-body">
                <h3 class="enroll-title">{{ $enrollment->course->title }}</h3>
                <div class="enroll-progress-label">
                    <span>ምዝገባ ሂደት / Progress</span>
                    <span>{{ $progress['percentage'] }}%</span>
                </div>
                <div class="progress-bar" style="margin-bottom:16px; background:var(--bg3); height:8px; border-radius:4px; overflow:hidden;">
                    <div class="progress-fill" style="width:{{ $progress['percentage'] }}%; background:var(--cyan); height:100%;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.8rem;color:var(--muted);margin-bottom:16px;">
                    <span>✅ {{ $progress['completed'] }}/{{ $progress['total'] }} ትምህርቶች</span>
                    @if($progress['percentage'] == 100)
                        <span style="color:var(--success);font-weight:bold;">🏆 Completed!</span>
                    @endif
                </div>
                <a href="{{ route('student.course', $enrollment->course->slug) }}" class="btn btn-primary" style="width:100%;justify-content:center;">
                    {{ $progress['percentage'] > 0 ? '▶ ቀጥሉ / Continue' : '▶ Start Course' }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection
