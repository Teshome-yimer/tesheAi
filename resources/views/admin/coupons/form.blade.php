@extends('layouts.admin')
@section('title', $coupon->exists ? 'Edit Coupon' : 'New Coupon')
@section('content')

<div class="page-header">
    <h1 class="page-title">{{ $coupon->exists ? '✏️ Edit Coupon' : '➕ New Coupon' }}</h1>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div style="max-width:540px;">
    <div class="form-card">
        @if($errors->any())
            <div class="flash flash-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ $coupon->exists ? route('admin.coupons.update', $coupon) : route('admin.coupons.store') }}">
            @csrf
            @if($coupon->exists) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Coupon Code *</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code) }}" placeholder="SAVE20" required style="text-transform:uppercase;">
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Type *</label>
                    <select name="type" class="form-control" required>
                        <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Value *</label>
                    <input type="number" name="value" class="form-control" value="{{ old('value', $coupon->value) }}" step="0.01" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Apply to Course (optional)</label>
                <select name="course_id" class="form-control">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $coupon->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Max Uses</label>
                    <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses', $coupon->max_uses) }}" placeholder="Unlimited" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Expires At</label>
                    <input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}">
                </div>
            </div>
            <label style="display:flex;align-items:center;gap:10px;margin-bottom:24px;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }} style="accent-color:var(--indigo);width:16px;height:16px;">
                <span style="font-size:0.9rem;">Active</span>
            </label>

            <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;padding:14px;">
                {{ $coupon->exists ? '💾 Update Coupon' : '🚀 Create Coupon' }}
            </button>
        </form>
    </div>
</div>

@endsection
