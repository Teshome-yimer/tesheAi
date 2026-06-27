@extends('layouts.admin')
@section('title', 'Courses')
@section('content')

<div class="page-header">
    <h1 class="page-title">📚 Courses</h1>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-cyan">+ New Course</a>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Price (ETB)</th>
                <th>Price (USD)</th>
                <th>Students</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $course->title }}</div>
                    <div style="color:var(--muted);font-size:0.78rem;">{{ $course->total_lessons }} lessons · {{ $course->total_hours }}h · {{ $course->level }}</div>
                </td>
                <td>{{ number_format($course->price_etb) }}</td>
                <td>${{ $course->price_usd }}</td>
                <td><span class="badge badge-indigo">{{ $course->enrollments_count }}</span></td>
                <td>
                    <span class="badge {{ $course->is_published ? 'badge-success' : 'badge-muted' }}">
                        {{ $course->is_published ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <a href="{{ route('admin.courses.content', $course) }}" class="btn btn-secondary btn-sm">📝 Content</a>
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                        <form method="POST" action="{{ route('admin.courses.toggle-publish', $course) }}" style="display:inline">
                            @csrf
                            <button class="btn btn-secondary btn-sm">{{ $course->is_published ? '🔒 Unpublish' : '✅ Publish' }}</button>
                        </form>
                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Delete this course?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">🗑</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:40px;">No courses yet. <a href="{{ route('admin.courses.create') }}">Create one</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
