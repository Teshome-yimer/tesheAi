@extends('layouts.app')
@section('title', 'Checkout - ' . $course->title)
@push('styles')
<style>
.checkout-layout { display:grid; grid-template-columns:1fr 380px; gap:40px; padding:60px 0; align-items:start; }
.checkout-card { background:var(--bg2); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
.payment-tabs { display:flex; border-bottom:1px solid var(--border); }
.tab-btn { flex:1; padding:16px; background:none; border:none; color:var(--muted); font-size:0.95rem; font-weight:600; cursor:pointer; transition:.2s; }
.tab-btn.active { background:rgba(99,102,241,.1); color:var(--indigo); border-bottom:2px solid var(--indigo); }
.tab-content { display:none; padding:28px; }
.tab-content.active { display:block; }
.order-summary { background:var(--bg2); border:1px solid var(--border); border-radius:16px; padding:28px; position:sticky; top:90px; }
.summary-course { display:flex; gap:14px; margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid var(--border); }
.summary-thumb { width:80px; height:60px; border-radius:8px; background:linear-gradient(135deg,var(--bg3),var(--border)); display:flex; align-items:center; justify-content:center; font-size:1.8rem; flex-shrink:0; object-fit:cover; }
.summary-title { font-weight:700; font-size:0.95rem; line-height:1.3; }
.summary-meta { color:var(--muted); font-size:0.8rem; margin-top:4px; }
.price-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; }
.price-row.total { border-top:2px solid var(--border); margin-top:8px; padding-top:16px; font-size:1.2rem; font-weight:800; }
.coupon-box { display:flex; gap:10px; margin:20px 0; }
.coupon-box input { flex:1; }
.coupon-feedback { font-size:0.85rem; margin-top:6px; }
.coupon-success { color:var(--success); }
.coupon-error { color:var(--danger); }
.countdown-bar { background:rgba(99,102,241,.1); border:1px solid rgba(99,102,241,.3); border-radius:8px; padding:12px; text-align:center; margin-bottom:24px; }
#stripe-card { 
    background: var(--bg3); 
    border: 1px solid var(--border); 
    border-radius: 8px; 
    padding: 14px; 
    min-height: 45px; /* ቁመት እንዲኖረው ማድረግ */
    width: 100%;       /* ሙሉ ስፋት እንዲይዝ */
}
@media(max-width:900px) { .checkout-layout { grid-template-columns:1fr; } .order-summary { position:static; } }
</style>
@endpush
@section('content')

<div class="container">
    <div style="padding-top:40px;margin-bottom:8px;">
        <a href="{{ route('course.show', $course->slug) }}" style="color:var(--muted);font-size:0.9rem;">← {{ $course->title }}</a>
    </div>
    <h1 style="font-size:2rem;font-weight:900;margin-bottom:32px;">ምዝገባ / <span style="background:linear-gradient(135deg,var(--indigo),var(--cyan));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Checkout</span></h1>

    <div class="checkout-layout">

        {{-- Payment Form --}}
        <div>
            {{-- Countdown --}}
            <div class="countdown-bar">
                <span style="color:var(--muted);font-size:0.8rem;">⏰ ዋጋው ለ </span>
                <strong style="color:var(--indigo);" id="co-timer">30:00</strong>
                <span style="color:var(--muted);font-size:0.8rem;"> ይቆያል ይፍጠኑ / price reserved for</span>
            </div>

            <div class="checkout-card">
                <div class="payment-tabs">
                    <button class="tab-btn active" onclick="switchTab('chapa', this)">🇪🇹 Chapa (ETB)</button>
                    <button class="tab-btn" onclick="switchTab('stripe', this)">💳 Stripe (USD)</button>
                </div>

                {{-- Customer Info (shared) --}}
                <div style="padding:28px 28px 0;">
                    <h3 style="font-weight:700;margin-bottom:20px;">ዝርዝር / Your Info</h3>
                    <div class="form-group">
                        <label class="form-label">ሙሉ ስም / Full Name</label>
                        <input type="text" id="cust-name" class="form-control" value="{{ auth()->user()->name }}" placeholder="አበበ ቢቀለ">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div class="form-group">
                            <label class="form-label">ኢሜይል / Email</label>
                            <input type="email" id="cust-email" class="form-control" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">ስልክ / Phone</label>
                            <input type="text" id="cust-phone" class="form-control" value="{{ auth()->user()->phone }}" placeholder="+251912345678">
                        </div>
                    </div>
                </div>

                {{-- Chapa Tab --}}
                <div id="tab-chapa" class="tab-content active">
                    <p style="color:var(--muted);font-size:0.9rem;margin-bottom:20px;">🏦  በቀላሉ በ Tele Birr,  CBE Birr እና  በ CBE (ንግድ ባንክ)  መክፈል ይችላሉ  አገልግሎታችነን ስለወደዱት እናመሰግናለን </p>
                    <form id="chapa-form" action="{{ route('payment.chapa.initiate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="coupon" id="chapa-coupon-code">
                        <input type="hidden" name="discount" id="chapa-discount">
                        <input type="hidden" name="amount" id="chapa-amount" value="{{ $course->price_etb }}">
                        <button type="submit" class="btn btn-cyan" style="width:100%;justify-content:center;font-size:1.1rem;padding:16px;">
                            🚀 Chapa ክፈል / Pay {{ number_format($course->price_etb) }} ETB
                        </button>
                    </form>
                </div>

                {{-- Stripe Tab --}}
                <div id="tab-stripe" class="tab-content">
                    <p style="color:var(--muted);font-size:0.9rem;margin-bottom:20px;">💳 Visa / Mastercard / አለም አቀፍ ክፍያ / International card payment</p>
                    <div class="form-group">
                        <label class="form-label">Card Details</label>
                        <div id="stripe-card"></div>
                        <div id="card-errors" style="color:var(--danger);font-size:0.85rem;margin-top:6px;"></div>
                    </div>
                    <button id="stripe-pay-btn" class="btn btn-primary" style="width:100%;justify-content:center;font-size:1.1rem;padding:16px;">
                        💳 Pay $<span id="stripe-display-price">{{ $course->price_usd }}</span> USD
                    </button>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="order-summary">
            <h3 style="font-weight:800;margin-bottom:20px;">Order Summary</h3>
            <div class="summary-course">
                @if($course->thumbnail)
                <img src="{{ Storage::url($course->thumbnail) }}" alt="" class="summary-thumb">
                @else
                <div class="summary-thumb">🎓</div>
                @endif
                <div>
                    <div class="summary-title">{{ $course->title }}</div>
                    <div class="summary-meta">{{ $course->total_lessons }} lessons • {{ $course->total_hours }}h</div>
                </div>
            </div>

            {{-- Coupon --}}
            <div class="coupon-box">
                <input type="text" id="coupon-input" class="form-control" placeholder="ኮፖን ኮድ / Coupon code">
                <button class="btn btn-secondary" onclick="applyCoupon()">Apply</button>
            </div>
            <div id="coupon-feedback" class="coupon-feedback"></div>

            <div id="price-breakdown">
                <div class="price-row">
                    <span style="color:var(--muted);">ዋጋ / Price (ETB)</span>
                    <span id="orig-etb">{{ number_format($course->price_etb) }} ETB</span>
                </div>
                <div class="price-row" id="discount-row" style="display:none;">
                    <span style="color:var(--success);">ቅናሽ / Discount</span>
                    <span id="discount-amount" style="color:var(--success);">-0 ETB</span>
                </div>
                <div class="price-row total">
                    <span>ድምር / Total (ETB)</span>
                    <span id="final-etb" style="color:var(--cyan);">{{ number_format($course->price_etb) }} ETB</span>
                </div>
                <div class="price-row" style="font-size:0.85rem;color:var(--muted);border-top:1px solid var(--border);padding-top:10px;margin-top:4px;">
                    <span>USD equivalent</span>
                    <span id="final-usd">${{ $course->price_usd }}</span>
                </div>
            </div>

            <div style="margin-top:20px;background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);border-radius:8px;padding:12px;font-size:0.8rem;color:#10b981;text-align:center;">
                🔒 Secure Payment • 7-day refund guarantee
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
const COURSE_ID = {{ $course->id }};
const PRICE_ETB = {{ $course->price_etb }};
const PRICE_USD = {{ $course->price_usd }};
let discountEtb = 0, discountUsd = 0, couponCode = '';

// Countdown
let secs = 30 * 60;
const timerEl = document.getElementById('co-timer');
setInterval(() => {
    if (secs <= 0) return;
    secs--;
    const m = String(Math.floor(secs / 60)).padStart(2, '0');
    const s = String(secs % 60).padStart(2, '0');
    timerEl.textContent = m + ':' + s;
}, 1000);

// Tabs
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
}

// Coupon
async function applyCoupon() {
    const code = document.getElementById('coupon-input').value.trim();
    if (!code) return;
    const feedback = document.getElementById('coupon-feedback');
    feedback.textContent = 'Checking...';
    feedback.className = 'coupon-feedback';

    const res = await fetch('{{ route("coupon.apply") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
        body: JSON.stringify({ code, course_id: COURSE_ID })
    });
    const data = await res.json();

    if (data.valid) {
        discountEtb = data.discount_etb;
        discountUsd = data.discount_usd;
        couponCode = code;
        feedback.textContent = '✅ ' + data.message;
        feedback.className = 'coupon-feedback coupon-success';
        updatePrices();
        document.getElementById('chapa-coupon-code').value = code;
    } else {
        feedback.textContent = '❌ ' + data.message;
        feedback.className = 'coupon-feedback coupon-error';
    }
}

function updatePrices() {
    const finalEtb = Math.max(0, PRICE_ETB - discountEtb);
    const finalUsd = Math.max(0, PRICE_USD - discountUsd);
    document.getElementById('final-etb').textContent = finalEtb.toLocaleString() + ' ETB';
    document.getElementById('final-usd').textContent = '$' + finalUsd.toFixed(2);
    document.getElementById('discount-row').style.display = discountEtb > 0 ? 'flex' : 'none';
    document.getElementById('discount-amount').textContent = '-' + discountEtb.toLocaleString() + ' ETB';
    document.getElementById('chapa-amount').value = finalEtb;
    document.getElementById('chapa-discount').value = discountEtb;
    document.getElementById('stripe-display-price').textContent = finalUsd.toFixed(2);
}

// Chapa: inject name/email/phone into form
document.getElementById('chapa-form').addEventListener('submit', function(e) {
    const name = document.getElementById('cust-name').value;
    const email = document.getElementById('cust-email').value;
    const phone = document.getElementById('cust-phone').value;
    if (!name || !email || !phone) { e.preventDefault(); alert('Please fill in your details'); return; }
    // Add hidden fields
    ['name','email','phone'].forEach(f => {
        let el = this.querySelector('[name='+f+']');
        if (!el) { el = document.createElement('input'); el.type = 'hidden'; el.name = f; this.appendChild(el); }
        el.value = { name, email, phone }[f];
    });
});

// Stripe
// Stripe መጀመሪያ አታስነሳው (Mount አታድርገው)
const stripe = Stripe('{{ config("services.stripe.key") }}');
const elements = stripe.elements();
const cardEl = elements.create('card', {
    style: { 
        base: { color: '#e2e8f0', fontSize: '16px', '::placeholder': { color: '#64748b' }, iconColor: '#6366f1' }, 
        invalid: { color: '#ef4444' } 
    }
});

let isStripeMounted = false;

// የ ታብ መቀያየሪያ (switchTab) ፊንክሽንህን በዚህ መልክ አሻሽለው
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    
    btn.classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');

    // ተጠቃሚው Stripe ታብ ሲመርጥ እና አንዴ ብቻ mount እንዲያደርግ
    if (tab === 'stripe' && !isStripeMounted) {
        // ትንሽ ሰዓት ሰጥተን ዲቪው እንዲታይ እና ስፋቱን እንዲያገኝ እናደርጋለን
        setTimeout(() => {
            cardEl.mount('#stripe-card');
            isStripeMounted = true;
        }, 100);
    }
}

cardEl.on('change', e => { 
    document.getElementById('card-errors').textContent = e.error ? e.error.message : ''; 
});

document.getElementById('stripe-pay-btn').addEventListener('click', async function() {
    const btn = this;
    btn.disabled = true; btn.textContent = 'Processing...';
    const name = document.getElementById('cust-name').value;
    const email = document.getElementById('cust-email').value;
    const finalUsd = Math.max(0, PRICE_USD - discountUsd);

    // Create PaymentIntent
    const intentRes = await fetch('{{ route("payment.stripe.intent") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
        body: JSON.stringify({ course_id: COURSE_ID, amount: finalUsd, coupon: couponCode, discount: discountUsd })
    });
    const intentData = await intentRes.json();

    if (!intentData.client_secret) {
        document.getElementById('card-errors').textContent = intentData.error || 'Failed to initiate payment';
        btn.disabled = false; btn.textContent = 'Pay $' + finalUsd.toFixed(2) + ' USD'; return;
    }

    const result = await stripe.confirmCardPayment(intentData.client_secret, {
        payment_method: { card: cardEl, billing_details: { name, email } }
    });

    if (result.error) {
        document.getElementById('card-errors').textContent = result.error.message;
        btn.disabled = false; btn.textContent = 'Pay $' + finalUsd.toFixed(2) + ' USD';
    } else if (result.paymentIntent.status === 'succeeded') {
        window.location = '{{ route("payment.stripe.success") }}?order_id=' + intentData.order_id;
    }
});
</script>
@endpush
