@extends('layouts.admin')
@section('title', 'Course Content: ' . $course->title)
@section('content')

<div class="page-header">
    <h1 class="page-title">📝 {{ $course->title }}</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:28px;align-items:start;">

    {{-- Sections + Lessons --}}
    <div>
        @forelse($course->sections as $section)
        <div class="form-card" style="margin-bottom:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <h3 style="font-weight:700;">📂 {{ $section->title }}</h3>
                <div style="display:flex;gap:8px;">
                    <form method="POST" action="{{ route('admin.sections.destroy', $section) }}" onsubmit="return confirm('Delete section?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑</button>
                    </form>
                </div>
            </div>

            {{-- Lessons list --}}
            @foreach($section->lessons as $lesson)
            <div style="background:var(--bg3);border-radius:8px;padding:14px 16px;margin-bottom:8px;display:flex;align-items:center;gap:12px;">
                <span style="color:var(--muted);">▶</span>
                <div style="flex:1;">
                    <div style="font-size:0.9rem;font-weight:500;">{{ $lesson->title }}</div>
                    <div style="font-size:0.75rem;color:var(--muted);">{{ $lesson->duration_minutes }}min {{ $lesson->is_free_preview ? '· FREE PREVIEW' : '' }}</div>
                </div>
                <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}" onsubmit="return confirm('Delete lesson?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">🗑</button>
                </form>
            </div>
            @endforeach

            {{-- Add lesson --}}
            <details style="margin-top:12px;">
                <summary style="cursor:pointer;color:var(--cyan);font-size:0.85rem;font-weight:600;padding:8px 0;">+ Add Lesson</summary>
                <form method="POST" action="{{ route('admin.lessons.store', $section) }}" style="margin-top:12px;background:var(--bg);border-radius:8px;padding:16px;">
                    @csrf
                    <div class="form-grid-2" style="margin-bottom:12px;">
                        <input type="text" name="title" class="form-control" placeholder="Lesson title *" required>
                        <input type="text" name="video_url" class="form-control" placeholder="Video URL (YouTube embed)">
                    </div>
                    <div class="form-grid-2" style="margin-bottom:12px;">
                        <input type="number" name="duration_minutes" class="form-control" placeholder="Duration (min)" min="1">
                        <input type="number" name="order" class="form-control" placeholder="Order" min="1">
                    </div>
                    <label style="display:flex;align-items:center;gap:8px;margin-bottom:12px;font-size:0.85rem;cursor:pointer;">
                        <input type="checkbox" name="is_free_preview" value="1" style="accent-color:var(--indigo);">
                        Free Preview
                    </label>
                    <button type="submit" class="btn btn-primary btn-sm">Add Lesson</button>
                </form>
            </details>
        </div>
        @empty
        <div style="text-align:center;padding:40px;color:var(--muted);background:var(--bg2);border:1px solid var(--border);border-radius:12px;">
            No sections yet. Add one →
        </div>
        @endforelse
    </div>

    {{-- Add Section --}}
    <div>
        <div class="form-card">
            <h3 style="font-weight:700;margin-bottom:16px;">➕ Add Section</h3>
            <form method="POST" action="{{ route('admin.sections.store', $course) }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Section Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Introduction" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Order</label>
                    <input type="number" name="order" class="form-control" value="{{ $course->sections->count() + 1 }}" min="1">
                </div>
                <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;">Add Section</button>
            </form>
        </div>
    </div>

</div>

@endsection
