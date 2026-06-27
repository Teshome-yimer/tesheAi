@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-value">{{ number_format($stats['total_students']) }}</div>
        <div class="stat-label">👥 Total Students</div>
    </div>
    <div class="stat-box">
        <div class="stat-value">{{ number_format($stats['revenue_etb']) }}</div>
        <div class="stat-label">💰 Revenue (ETB)</div>
    </div>
    <div class="stat-box">
        <div class="stat-value">${{ number_format($stats['revenue_usd'], 2) }}</div>
        <div class="stat-label">💵 Revenue (USD)</div>
    </div>
    <div class="stat-box">
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
        <div class="stat-label">📦 Paid Orders</div>
    </div>
    <div class="stat-box">
        <div class="stat-value">{{ $stats['total_courses'] }}</div>
        <div class="stat-label">📚 Total Courses</div>
    </div>
    <div class="stat-box">
        <div class="stat-value">{{ $stats['total_enrollments'] }}</div>
        <div class="stat-label">🎓 Enrollments</div>
    </div>
</div>

<div class="page-header">
    <h2 class="page-title" style="font-size:1.1rem;">Recent Orders</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Student</th>
                <th>Course</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
            <tr>
                <td style="font-family:monospace;color:var(--cyan);">{{ $order->order_number }}</td>
                <td>{{ $order->user?->name ?? 'N/A' }}</td>
                <td>{{ Str::limit($order->course->title, 30) }}</td>
                <td style="font-weight:700;">{{ $order->amount }} {{ $order->currency }}</td>
                <td><span class="badge badge-indigo">{{ $order->payment_method }}</span></td>
                <td>
                    <span class="badge {{ $order->status == 'paid' ? 'badge-success' : ($order->status == 'failed' ? 'badge-danger' : 'badge-muted') }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td style="color:var(--muted);">{{ $order->created_at->format('M d, H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:40px;">No orders yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
