@extends('layouts.admin')
@section('title', 'Students')
@section('content')

<div class="page-header">
    <h1 class="page-title">👥 Students</h1>
    <a href="{{ route('admin.students.enroll-form') }}" class="btn btn-cyan">+ Manual Enroll</a>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr><th>Name</th><th>Email</th><th>Phone</th><th>Enrollments</th><th>Joined</th></tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td style="font-weight:600;">{{ $student->name }}</td>
                <td style="color:var(--muted);">{{ $student->email }}</td>
                <td style="color:var(--muted);">{{ $student->phone ?? '—' }}</td>
                <td><span class="badge badge-indigo">{{ $student->enrollments_count }}</span></td>
                <td style="color:var(--muted);font-size:0.8rem;">{{ $student->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--muted);padding:40px;">No students yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:20px;">{{ $students->links() }}</div>

@endsection
