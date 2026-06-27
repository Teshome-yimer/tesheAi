<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Enrollment Confirmed</title></head>
<body style="font-family:Arial,sans-serif;background:#0a0a0f;color:#e2e8f0;padding:40px;">
<div style="max-width:600px;margin:0 auto;background:#13131a;border:1px solid #6366f1;border-radius:12px;padding:40px;">
    <h1 style="color:#6366f1;">🎉 ምዝገባ ተረጋግጧል! / Enrollment Confirmed!</h1>
    <p>ሰላም {{ $order->user->name }},</p>
    <p>ለ <strong style="color:#22d3ee;">{{ $order->course->title }}</strong> ኮርስ በተሳካ ሁኔታ ተመዝግበዋል!</p>
    <hr style="border-color:#6366f1;margin:20px 0;">
    <p><strong>Order #:</strong> {{ $order->order_number }}</p>
    <p><strong>Amount:</strong> {{ $order->amount }} {{ $order->currency }}</p>
    <p><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</p>
    <hr style="border-color:#6366f1;margin:20px 0;">
    <a href="{{ url('/student/dashboard') }}" style="background:linear-gradient(135deg,#6366f1,#22d3ee);color:#fff;padding:14px 28px;border-radius:8px;text-decoration:none;font-weight:bold;">
        ኮርሱን ጀምሩ / Start Learning
    </a>
    <p style="margin-top:30px;color:#64748b;font-size:12px;">{{ config('app.name') }}</p>
</div>
</body>
</html>
