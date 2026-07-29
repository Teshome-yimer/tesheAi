@extends('layouts.admin')

@section('title', 'Quizzes')

@section('content')
<div class="page-header">
    <h1 class="page-title">📝 Quizzes / Online Exams</h1>
    <button class="btn btn-primary" onclick="toggleCreatePanel()">➕ New Quiz</button>
</div>

@if($errors->any())
    <div class="flash flash-error">❌ {{ $errors->first() }}</div>
@endif

{{-- Create panel --}}
<div id="create-panel" class="form-card" style="display:none;margin-bottom:24px;">
    <h3 style="font-size:1rem;margin-bottom:16px;">Create New Quiz</h3>
    <form method="POST" action="{{ route('admin.quizzes.store') }}">
        @csrf
        <div class="form-grid-2">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Time Limit (minutes, optional)</label>
                <input type="number" name="time_limit_minutes" class="form-control" min="1" max="600" value="{{ old('time_limit_minutes') }}" placeholder="No limit">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Description (optional)</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create &amp; Add Questions →</button>
        <button type="button" class="btn btn-secondary" onclick="toggleCreatePanel()">Cancel</button>
    </form>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Quiz</th>
                <th>Questions</th>
                <th>Attempts</th>
                <th>Time Limit</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($quizzes as $quiz)
                <tr>
                    <td>
                        <div style="font-weight:600;">📝 {{ $quiz->title }}</div>
                        @if($quiz->description)
                            <div style="color:var(--muted);font-size:0.78rem;margin-top:2px;">{{ Str::limit($quiz->description, 80) }}</div>
                        @endif
                    </td>
                    <td>{{ $quiz->questions_count }}</td>
                    <td>{{ $quiz->attempts_count }}</td>
                    <td>{{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes . ' min' : '—' }}</td>
                    <td>
                        @if($quiz->is_published)
                            <span class="badge badge-success">Published</span>
                        @else
                            <span class="badge badge-muted">Draft</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <a href="{{ route('admin.quizzes.questions', $quiz) }}" class="btn btn-cyan btn-sm">❓ Questions ({{ $quiz->questions_count }})</a>
                            <form method="POST" action="{{ route('admin.quizzes.toggle-publish', $quiz) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">{{ $quiz->is_published ? 'Hide' : 'Publish' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}" style="display:inline;"
                                  onsubmit="return confirm('Delete this quiz, its questions and all attempts?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:var(--muted);padding:32px;">
                        No quizzes yet. Click "New Quiz" to create your first exam.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $quizzes->links() }}
</div>
@endsection

@push('scripts')
<script>
    function toggleCreatePanel() {
        const p = document.getElementById('create-panel');
        p.style.display = p.style.display === 'none' ? 'block' : 'none';
    }
    @if($errors->any())
        document.getElementById('create-panel').style.display = 'block';
    @endif
</script>
@endpush
