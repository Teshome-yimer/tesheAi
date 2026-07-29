@extends('layouts.admin')

@section('title', 'Quiz Questions')

@section('content')
<div style="margin-bottom:8px;">
    <a href="{{ route('admin.quizzes.index') }}" style="font-size:0.85rem;color:var(--muted);">← All Quizzes</a>
</div>
<div class="page-header">
    <div>
        <h1 class="page-title">❓ {{ $quiz->title }}</h1>
        <p style="color:var(--muted);font-size:0.85rem;margin-top:4px;">
            {{ $quiz->questions->count() }} questions
            @if($quiz->time_limit_minutes) · ⏱ {{ $quiz->time_limit_minutes }} min @endif
            · {{ $quiz->is_published ? '🟢 Published' : '⚪ Draft' }}
        </p>
    </div>
    <form method="POST" action="{{ route('admin.quizzes.toggle-publish', $quiz) }}">
        @csrf
        <button type="submit" class="btn {{ $quiz->is_published ? 'btn-secondary' : 'btn-cyan' }}">
            {{ $quiz->is_published ? 'Hide Quiz' : '🚀 Publish Quiz' }}
        </button>
    </form>
</div>

@if($errors->any())
    <div class="flash flash-error">❌ {{ $errors->first() }}</div>
@endif

{{-- Quiz settings --}}
<div class="form-card" style="margin-bottom:24px;">
    <h3 style="font-size:0.95rem;margin-bottom:16px;">⚙️ Quiz Settings</h3>
    <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}">
        @csrf @method('PUT')
        <div style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
            <div style="flex:2;min-width:220px;">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $quiz->title }}" required>
            </div>
            <div style="flex:1;min-width:140px;">
                <label class="form-label">Time Limit (min)</label>
                <input type="number" name="time_limit_minutes" class="form-control" min="1" max="600" value="{{ $quiz->time_limit_minutes }}" placeholder="No limit">
            </div>
            <div style="flex:3;min-width:240px;">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value="{{ $quiz->description }}">
            </div>
            <button type="submit" class="btn btn-secondary btn-sm">Save</button>
        </div>
    </form>
</div>

{{-- Add question --}}
<div class="form-card" style="margin-bottom:24px;">
    <h3 style="font-size:0.95rem;margin-bottom:16px;">➕ Add Question</h3>
    <form method="POST" action="{{ route('admin.quizzes.questions.store', $quiz) }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Question *</label>
            <textarea name="question" class="form-control" rows="2" required>{{ old('question') }}</textarea>
        </div>
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Option A *</label>
                <input type="text" name="option_a" class="form-control" value="{{ old('option_a') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Option B *</label>
                <input type="text" name="option_b" class="form-control" value="{{ old('option_b') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Option C *</label>
                <input type="text" name="option_c" class="form-control" value="{{ old('option_c') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Option D *</label>
                <input type="text" name="option_d" class="form-control" value="{{ old('option_d') }}" required>
            </div>
        </div>
        <div class="form-group" style="max-width:240px;">
            <label class="form-label">Correct Answer *</label>
            <select name="correct_option" class="form-control" required>
                <option value="">— Select —</option>
                <option value="a" {{ old('correct_option') === 'a' ? 'selected' : '' }}>A</option>
                <option value="b" {{ old('correct_option') === 'b' ? 'selected' : '' }}>B</option>
                <option value="c" {{ old('correct_option') === 'c' ? 'selected' : '' }}>C</option>
                <option value="d" {{ old('correct_option') === 'd' ? 'selected' : '' }}>D</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">➕ Add Question</button>
    </form>
</div>

{{-- Existing questions --}}
@forelse($quiz->questions as $i => $q)
    <div class="form-card" style="margin-bottom:14px;padding:20px;">
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start;">
            <div style="flex:1;">
                <div style="font-weight:700;margin-bottom:10px;">{{ $i + 1 }}. {{ $q->question }}</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;font-size:0.85rem;">
                    @foreach($q->options as $key => $text)
                        <div style="padding:7px 12px;border-radius:6px;border:1px solid {{ $q->correct_option === $key ? 'var(--success)' : 'var(--border)' }};{{ $q->correct_option === $key ? 'color:var(--success);font-weight:600;' : 'color:var(--muted);' }}">
                            {{ strtoupper($key) }}. {{ $text }} {{ $q->correct_option === $key ? '✓' : '' }}
                        </div>
                    @endforeach
                </div>
            </div>
            <div style="display:flex;gap:6px;flex-shrink:0;">
                <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEditQ({{ $q->id }})">✎ Edit</button>
                <form method="POST" action="{{ route('admin.quizzes.questions.destroy', $q) }}"
                      onsubmit="return confirm('Delete this question?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                </form>
            </div>
        </div>

        {{-- Edit form --}}
        <div id="edit-q-{{ $q->id }}" style="display:none;margin-top:16px;border-top:1px solid var(--border);padding-top:16px;">
            <form method="POST" action="{{ route('admin.quizzes.questions.update', $q) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Question</label>
                    <textarea name="question" class="form-control" rows="2" required>{{ $q->question }}</textarea>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Option A</label>
                        <input type="text" name="option_a" class="form-control" value="{{ $q->option_a }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Option B</label>
                        <input type="text" name="option_b" class="form-control" value="{{ $q->option_b }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Option C</label>
                        <input type="text" name="option_c" class="form-control" value="{{ $q->option_c }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Option D</label>
                        <input type="text" name="option_d" class="form-control" value="{{ $q->option_d }}" required>
                    </div>
                </div>
                <div class="form-group" style="max-width:240px;">
                    <label class="form-label">Correct Answer</label>
                    <select name="correct_option" class="form-control" required>
                        @foreach(['a','b','c','d'] as $opt)
                            <option value="{{ $opt }}" {{ $q->correct_option === $opt ? 'selected' : '' }}>{{ strtoupper($opt) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEditQ({{ $q->id }})">Cancel</button>
            </form>
        </div>
    </div>
@empty
    <div class="form-card" style="text-align:center;color:var(--muted);padding:32px;">
        No questions yet — add your first question above. ጥያቄ የለም — ከላይ ጨምር።
    </div>
@endforelse
@endsection

@push('scripts')
<script>
    function toggleEditQ(id) {
        const el = document.getElementById('edit-q-' + id);
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endpush
