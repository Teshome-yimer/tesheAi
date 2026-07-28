@extends('layouts.admin')
@section('title', 'File Manager — ' . $course->title)
@push('styles')
<style>
.file-card { background:var(--bg3); border:1px solid var(--border); border-radius:10px; padding:16px; margin-bottom:10px; display:flex; align-items:center; gap:14px; transition:.2s; }
.file-card:hover { border-color:var(--indigo); }
.file-icon { font-size:2rem; flex-shrink:0; }
.file-info { flex:1; }
.file-title { font-weight:600; font-size:0.9rem; }
.file-meta { color:var(--muted); font-size:0.78rem; margin-top:3px; }
.upload-area { border:2px dashed var(--border); border-radius:12px; padding:32px; text-align:center; transition:.2s; cursor:pointer; }
.upload-area:hover { border-color:var(--indigo); background:rgba(99,102,241,.05); }
.lesson-group { margin-bottom:28px; }
.lesson-group-title { background:var(--bg2); border:1px solid var(--border); border-radius:8px; padding:12px 16px; font-weight:700; font-size:0.9rem; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between; }
</style>
@endpush
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">📎 File Manager</h1>
        <p style="color:var(--muted);font-size:0.85rem;margin-top:4px;">{{ $course->title }}</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('admin.courses.content', $course) }}" class="btn btn-secondary">← Content</a>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">← Courses</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 380px;gap:28px;align-items:start;">

    {{-- Files list by lesson --}}
    <div>
        @if($allFiles->isEmpty())
        <div style="text-align:center;padding:60px;color:var(--muted);background:var(--bg2);border:1px solid var(--border);border-radius:12px;">
            <div style="font-size:3rem;margin-bottom:12px;">📭</div>
            <div>ፋይሎች አልተጨመሩም / No files yet. Upload from the form →</div>
        </div>
        @else
        @foreach($course->sections as $section)
            @foreach($section->lessons as $lesson)
                @if($lesson->files->count() > 0)
                <div class="lesson-group">
                    <div class="lesson-group-title">
                        <span>📚 {{ $lesson->title }}</span>
                        <span class="badge badge-indigo">{{ $lesson->files->count() }} files</span>
                    </div>
                    @foreach($lesson->files as $file)
                    <div class="file-card">
                        <div class="file-icon">{{ $file->icon }}</div>
                        <div class="file-info">
                            <div class="file-title">{{ $file->title }}</div>
                            <div class="file-meta">
                                {{ strtoupper($file->file_type) }} · {{ $file->file_size_formatted }}
                                @if($file->is_free)
                                    · <span style="color:var(--success);">🔓 Free (everyone)</span>
                                @else
                                    · <span style="color:var(--cyan);">🔒 Enrolled only</span>
                                @endif
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <a href="{{ route('student.files.download', $file) }}" class="btn btn-secondary btn-sm" target="_blank">⬇ Download</a>
                            <form method="POST" action="{{ route('admin.files.toggle-free', $file) }}">
                                @csrf
                                <button class="btn btn-secondary btn-sm">{{ $file->is_free ? '🔒 Make Private' : '🔓 Make Free' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.files.destroy', $file) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            @endforeach
        @endforeach
        @endif
    </div>

    {{-- Upload form --}}
    <div>
        <div class="form-card">
            <h3 style="font-weight:700;margin-bottom:20px;">⬆ Upload File</h3>
            <form method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <div class="form-group">
                    <label class="form-label">Lesson *</label>
                    <select name="lesson_id" id="lesson-select" class="form-control" required onchange="updateAction(this)">
                        <option value="">-- Select Lesson --</option>
                        @foreach($course->sections as $section)
                            <optgroup label="{{ $section->title }}">
                                @foreach($section->lessons as $lesson)
                                <option value="{{ $lesson->id }}" data-url="{{ route('admin.lessons.files.upload', $lesson) }}">
                                    {{ $lesson->title }}
                                </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">File Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Course Notes PDF" required>
                </div>

                <div class="form-group">
                    <label class="form-label">File *</label>
                    <div class="upload-area" onclick="document.getElementById('file-input').click()">
                        <div id="file-name" style="color:var(--muted);">📎 Click to select file (PDF, DOC, ZIP...)</div>
                    </div>
                    <input type="file" id="file-input" name="file"
                        accept=".pdf,.doc,.docx,.zip,.rar,.mp3,.jpg,.png,.txt,.xlsx,.pptx"
                        style="display:none;" required
                        onchange="showFileName(this)">
                </div>

                <label style="display:flex;align-items:center;gap:10px;margin-bottom:20px;cursor:pointer;">
                    <input type="checkbox" name="is_free" value="1" id="is-free" style="accent-color:var(--indigo);width:16px;height:16px;">
                    <div>
                        <div style="font-size:0.9rem;font-weight:600;">🔓 Free for everyone</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Login ሳያስፈልግ ሁሉም ያወርዱታል</div>
                    </div>
                </label>

                <div id="upload-progress" style="display:none;margin-bottom:16px;">
                    <div style="background:var(--bg3);border-radius:99px;height:8px;overflow:hidden;">
                        <div id="upload-bar" style="height:100%;background:linear-gradient(90deg,var(--indigo),var(--cyan));width:0%;transition:width .3s;border-radius:99px;"></div>
                    </div>
                    <div id="upload-status" style="color:var(--cyan);font-size:0.8rem;margin-top:6px;"></div>
                </div>

                <button type="submit" id="upload-btn" class="btn btn-cyan" style="width:100%;justify-content:center;padding:14px;">⬆ Upload File</button>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
function showFileName(input) {
    const file = input.files[0];
    if (file) {
        const mb = (file.size / 1024 / 1024).toFixed(2);
        document.getElementById('file-name').innerHTML =
            '✅ <strong>' + file.name + '</strong> (' + mb + ' MB)';
        document.getElementById('file-name').style.color = 'var(--cyan)';
    }
}

function updateAction(select) {
    const opt = select.options[select.selectedIndex];
    document.getElementById('upload-form').action = opt.dataset.url || '';
}

document.getElementById('upload-form').addEventListener('submit', function(e) {
    const lessonId = document.getElementById('lesson-select').value;
    if (!lessonId) { e.preventDefault(); alert('Please select a lesson'); return; }

    e.preventDefault();
    const btn  = document.getElementById('upload-btn');
    const prog = document.getElementById('upload-progress');
    const bar  = document.getElementById('upload-bar');
    const stat = document.getElementById('upload-status');

    btn.disabled = true; btn.textContent = 'Uploading...';
    prog.style.display = 'block';

    const fd  = new FormData(this);
    const xhr = new XMLHttpRequest();

    xhr.upload.onprogress = (e) => {
        if (e.lengthComputable) {
            const pct = Math.round(e.loaded / e.total * 100);
            bar.style.width = pct + '%';
            stat.textContent = pct + '% — ' + (e.loaded/1024/1024).toFixed(1) + ' / ' + (e.total/1024/1024).toFixed(1) + ' MB';
        }
    };

    xhr.onload = () => {
        stat.textContent = '✅ Upload complete! Reloading...';
        bar.style.width = '100%';
        setTimeout(() => location.reload(), 1000);
    };

    xhr.onerror = () => {
        stat.textContent = '❌ Upload failed';
        btn.disabled = false; btn.textContent = '⬆ Upload File';
    };

    xhr.open('POST', this.action);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(fd);
});
</script>
@endpush
