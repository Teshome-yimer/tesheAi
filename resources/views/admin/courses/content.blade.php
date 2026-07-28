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
            <div style="background:var(--bg3);border-radius:8px;padding:14px 16px;margin-bottom:8px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <span style="color:var(--muted);">▶</span>
                    <div style="flex:1;">
                        <div style="font-size:0.9rem;font-weight:500;">{{ $lesson->title }}</div>
                        <div style="font-size:0.75rem;color:var(--muted);">{{ $lesson->duration_minutes }}min {{ $lesson->is_free_preview ? '· FREE PREVIEW' : '' }}</div>
                        @if($lesson->video_type === 'local' && $lesson->video_path)
                        <div style="font-size:0.72rem;color:var(--success);margin-top:4px;">🎬 Local video uploaded</div>
                        @elseif($lesson->video_url)
                        <div style="font-size:0.72rem;color:var(--cyan);margin-top:4px;word-break:break-all;">🎥 {{ $lesson->video_url }}</div>
                        @else
                        <div style="font-size:0.72rem;color:#fbbf24;margin-top:4px;">⚠️ No video</div>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}" onsubmit="return confirm('Delete lesson?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑</button>
                    </form>
                </div>
                <details style="margin-top:10px;">
                    <summary style="cursor:pointer;color:var(--indigo);font-size:0.8rem;font-weight:600;">✏️ Edit Video URL / Upload Local Video</summary>
                    {{-- YouTube URL --}}
                    <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}" style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                        @csrf @method('PUT')
                        <input type="hidden" name="title" value="{{ $lesson->title }}">
                        <input type="hidden" name="duration_minutes" value="{{ $lesson->duration_minutes }}">
                        <input type="hidden" name="order" value="{{ $lesson->order }}">
                        <input type="text" name="video_url" class="form-control" style="flex:1;min-width:220px;" value="{{ $lesson->video_url }}" placeholder="https://youtu.be/VIDEO_ID">
                        <button type="submit" class="btn btn-secondary btn-sm">💾 Save URL</button>
                    </form>
                    {{-- Local video upload --}}
                    <form method="POST" action="{{ route('admin.lessons.video.upload', $lesson) }}"
                          enctype="multipart/form-data" style="margin-top:10px;"
                          onsubmit="startUpload(this, {{ $lesson->id }})">
                        @csrf
                        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <input type="file" name="video" accept="video/mp4,video/webm"
                                style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:6px 10px;border-radius:6px;font-size:0.8rem;flex:1;min-width:200px;"
                                onchange="showSize(this, {{ $lesson->id }})" required>
                            <button type="submit" id="upload-btn-{{ $lesson->id }}" class="btn btn-primary btn-sm">⬆ Upload</button>
                        </div>
                        <div id="size-info-{{ $lesson->id }}" style="font-size:0.72rem;color:var(--muted);margin-top:4px;"></div>
                        <div id="progress-wrap-{{ $lesson->id }}" style="display:none;margin-top:8px;">
                            <div style="background:var(--bg2);border-radius:99px;height:8px;overflow:hidden;">
                                <div id="progress-bar-{{ $lesson->id }}" style="height:100%;background:linear-gradient(90deg,var(--indigo),var(--cyan));border-radius:99px;width:0%;transition:width .3s;"></div>
                            </div>
                            <div id="progress-text-{{ $lesson->id }}" style="color:var(--cyan);font-size:0.78rem;margin-top:4px;">Uploading...</div>
                        </div>
                    </form>
                    @if($lesson->video_type === 'local' && $lesson->video_path)
                    <div style="display:flex;align-items:center;gap:10px;margin-top:8px;">
                        <span style="color:var(--success);font-size:0.8rem;">✅ Local video uploaded</span>
                        <a href="{{ route('student.video.stream', $lesson) }}" target="_blank" class="btn btn-secondary btn-sm">▶ Preview</a>
                        <form method="POST" action="{{ route('admin.lessons.video.delete', $lesson) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">🗑 Remove</button>
                        </form>
                    </div>
                    @endif
                </details>
            </div>
            @endforeach

            {{-- Add lesson --}}
            <details style="margin-top:12px;">
                <summary style="cursor:pointer;color:var(--cyan);font-size:0.85rem;font-weight:600;padding:8px 0;">+ Add Lesson</summary>
                <form method="POST" action="{{ route('admin.lessons.store', $section) }}" style="margin-top:12px;background:var(--bg);border-radius:8px;padding:16px;">
                    @csrf
                    <div class="form-grid-2" style="margin-bottom:12px;">
                        <input type="text" name="title" class="form-control" placeholder="Lesson title *" required>
                        <input type="text" name="video_url" class="form-control" placeholder="https://youtu.be/VIDEO_ID">
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

@push('scripts')
<script>
function showSize(input, id) {
    const file = input.files[0];
    if (!file) return;
    const mb = (file.size / 1024 / 1024).toFixed(1);
    document.getElementById('size-info-' + id).textContent = '📁 ' + file.name + ' (' + mb + ' MB)';
}

function startUpload(form, id) {
    const fileInput = form.querySelector('input[type=file]');
    if (!fileInput.files[0]) return;

    event.preventDefault();

    const btn   = document.getElementById('upload-btn-' + id);
    const wrap  = document.getElementById('progress-wrap-' + id);
    const bar   = document.getElementById('progress-bar-' + id);
    const txt   = document.getElementById('progress-text-' + id);

    btn.disabled = true;
    btn.textContent = 'Uploading...';
    wrap.style.display = 'block';

    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();

    xhr.upload.addEventListener('progress', (e) => {
        if (e.lengthComputable) {
            const pct = Math.round((e.loaded / e.total) * 100);
            bar.style.width = pct + '%';
            const loaded = (e.loaded / 1024 / 1024).toFixed(1);
            const total  = (e.total  / 1024 / 1024).toFixed(1);
            txt.textContent = pct + '% — ' + loaded + ' / ' + total + ' MB uploaded';
        }
    });

    xhr.addEventListener('load', () => {
        if (xhr.status === 200 || xhr.status === 302) {
            txt.textContent = '✅ Upload complete! Reloading...';
            bar.style.width = '100%';
            setTimeout(() => location.reload(), 1000);
        } else {
            txt.textContent = '❌ Upload failed (status ' + xhr.status + '). Check file size limits.';
            btn.disabled = false;
            btn.textContent = '⬆ Upload';
        }
    });

    xhr.addEventListener('error', () => {
        txt.textContent = '❌ Network error. Try a smaller file or check PHP limits.';
        btn.disabled = false;
        btn.textContent = '⬆ Upload';
    });

    xhr.open('POST', form.action);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
}
</script>
@endpush
