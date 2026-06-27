@extends('layouts.admin')
@section('title', 'Orders')
@section('content')

<div class="page-header">
    <h1 class="page-title">💰 Orders</h1>
    <form method="GET" style="display:flex;gap:8px;">
        <select name="status" class="form-control" style="width:auto;" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach(['pending','paid','failed','refunded'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr><th>Order #</th><th>Student</th><th>Course</th><th>Amount</th><th>Method</th><th>Status</th><th>Coupon</th><th>Date</th></tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-family:monospace;color:var(--cyan);font-size:0.8rem;">{{ $order->order_number }}</td>
                <td>
                    <div style="font-weight:500;">{{ $order->user?->name ?? 'N/A' }}</div>
                    <div style="color:var(--muted);font-size:0.75rem;">{{ $order->user?->email }}</div>
                </td>
                <td style="max-width:180px;">{{ Str::limit($order->course->title, 35) }}</td>
                <td style="font-weight:700;color:var(--cyan);">{{ $order->amount }} {{ $order->currency }}</td>
                <td><span class="badge badge-indigo">{{ $order->payment_method }}</span></td>
                <td>
                    <span class="badge {{ $order->status=='paid' ? 'badge-success' : ($order->status=='failed' ? 'badge-danger' : 'badge-muted') }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td style="color:var(--muted);font-size:0.8rem;">{{ $order->coupon_code ?? '—' }}</td>
                <td style="color:var(--muted);font-size:0.8rem;">{{ $order->created_at->format('M d, H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--muted);padding:40px;">No orders found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">{{ $orders->withQueryString()->links() }}</div>

@endsection
