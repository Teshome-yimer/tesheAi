@extends('layouts.admin')
@section('title', $course->exists ? 'Edit Course' : 'New Course')
@section('content')

<div class="page-header">
    <h1 class="page-title">{{ $course->exists ? '✏️ Edit Course' : '➕ New Course' }}</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">← Back</a>
</div>

<form method="POST" action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}" enctype="multipart/form-data">
    @csrf
    @if($course->exists) @method('PUT') @endif

    @if($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
    @endif

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:28px;align-items:start;">
        <div>
            <div class="form-card" style="margin-bottom:20px;">
                <h3 style="font-weight:700;margin-bottom:20px;">Basic Info</h3>
                <div class="form-group">
                    <label class="form-label">Course Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $course->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">What You'll Learn (one per line)</label>
                    <textarea name="what_you_learn" class="form-control" rows="6" placeholder="Laravel Backend Development&#10;React Frontend&#10;MySQL Database">{{ old('what_you_learn', is_array($course->what_you_learn) ? implode("\n", $course->what_you_learn) : '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Preview Video URL</label>
                    <input type="url" name="preview_video" class="form-control" value="{{ old('preview_video', $course->preview_video) }}" placeholder="https://youtube.com/embed/...">
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-weight:700;margin-bottom:20px;">Pricing</h3>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Price (ETB) *</label>
                        <input type="number" name="price_etb" class="form-control" value="{{ old('price_etb', $course->price_etb) }}" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Price (USD) *</label>
                        <input type="number" name="price_usd" class="form-control" value="{{ old('price_usd', $course->price_usd) }}" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Original Price (ETB)</label>
                        <input type="number" name="original_price_etb" class="form-control" value="{{ old('original_price_etb', $course->original_price_etb) }}" step="0.01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Original Price (USD)</label>
                        <input type="number" name="original_price_usd" class="form-control" value="{{ old('original_price_usd', $course->original_price_usd) }}" step="0.01">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="form-card" style="margin-bottom:20px;">
                <h3 style="font-weight:700;margin-bottom:20px;">Details</h3>
                <div class="form-group">
                    <label class="form-label">Total Lessons *</label>
                    <input type="number" name="total_lessons" class="form-control" value="{{ old('total_lessons', $course->total_lessons) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Total Hours *</label>
                    <input type="number" name="total_hours" class="form-control" value="{{ old('total_hours', $course->total_hours) }}" step="0.5" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Level *</label>
                    <select name="level" class="form-control">
                        @foreach(['beginner','intermediate','advanced'] as $l)
                        <option value="{{ $l }}" {{ old('level', $course->level) == $l ? 'selected' : '' }}>{{ ucfirst($l) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Language *</label>
                    <input type="text" name="language" class="form-control" value="{{ old('language', $course->language ?? 'Amharic + English') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    @if($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" style="margin-top:8px;border-radius:6px;width:100%;height:120px;object-fit:cover;">
                    @endif
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-weight:700;margin-bottom:16px;">Visibility</h3>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $course->is_published) ? 'checked' : '' }} style="accent-color:var(--indigo);width:16px;height:16px;">
                        <span style="font-size:0.9rem;">Published</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }} style="accent-color:var(--indigo);width:16px;height:16px;">
                        <span style="font-size:0.9rem;">Featured on homepage</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;margin-top:24px;padding:14px;">
                    {{ $course->exists ? '💾 Update Course' : '🚀 Create Course' }}
                </button>
            </div>
        </div>
    </div>
</form>

@endsection
