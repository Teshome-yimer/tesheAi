@extends('layouts.admin')
@section('title', 'Coupons')
@section('content')

<div class="page-header">
    <h1 class="page-title">🏷️ Coupons</h1>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-cyan">+ New Coupon</a>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr><th>Code</th><th>Type</th><th>Value</th><th>Course</th><th>Uses</th><th>Expires</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
            <tr>
                <td style="font-family:monospace;font-weight:700;color:var(--cyan);font-size:0.95rem;">{{ $coupon->code }}</td>
                <td><span class="badge badge-indigo">{{ $coupon->type }}</span></td>
                <td style="font-weight:600;">{{ $coupon->type == 'percentage' ? $coupon->value . '%' : $coupon->value . ' ETB/USD' }}</td>
                <td style="color:var(--muted);font-size:0.8rem;">{{ $coupon->course?->title ?? 'All Courses' }}</td>
                <td>{{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}</td>
                <td style="color:var(--muted);font-size:0.8rem;">{{ $coupon->expires_at?->format('M d, Y') ?? 'Never' }}</td>
                <td>
                    <span class="badge {{ $coupon->is_active ? 'badge-success' : 'badge-muted' }}">
                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-secondary btn-sm">✏️</a>
                        <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">🗑</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px;">No coupons yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
