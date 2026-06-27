@extends('layouts.admin')
@section('title', 'Manual Enrollment')
@section('content')

<div class="page-header">
    <h1 class="page-title">➕ Manual Enrollment</h1>
    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div style="max-width:500px;">
    <div class="form-card">
        <form method="POST" action="{{ route('admin.students.enroll') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Student</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Course</label>
                <select name="course_id" class="form-control" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;padding:14px;">Enroll Student</button>
        </form>
    </div>
</div>

@endsection
