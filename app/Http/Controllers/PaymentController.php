<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Services\ChapaService;
use App\Services\StripeService;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct(
        private ChapaService $chapa,
        private StripeService $stripe,
        private EnrollmentService $enrollment,
    ) {}

    // ── CHAPA ──────────────────────────────────────────────────────────

    public function chapaInitiate(Request $request)
    {
        $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'name'       => 'required|string',
            'email'      => 'required|email',
            'phone'      => 'required|string',
            'coupon'     => 'nullable|string',
            'amount'     => 'required|numeric|min:1',
        ]);

        $course = Course::findOrFail($request->course_id);
        $nameParts = explode(' ', $request->name, 2);
        $txRef = 'CP-' . strtoupper(Str::random(12));

        // Create pending order
        $order = Order::create([
            'order_number'   => Order::generateOrderNumber(),
            'user_id'        => auth()->id(),
            'course_id'      => $course->id,
            'amount'         => $request->amount,
            'currency'       => 'ETB',
            'payment_method' => 'chapa',
            'status'         => 'pending',
            'chapa_tx_ref'   => $txRef,
            'coupon_code'    => $request->coupon,
            'discount_amount'=> $request->discount ?? 0,
        ]);

        $result = $this->chapa->initializePayment([
            'amount'      => $request->amount,
            'email'       => $request->email,
            'first_name'  => $nameParts[0],
            'last_name'   => $nameParts[1] ?? '',
            'phone'       => $request->phone,
            'tx_ref'      => $txRef,
            'return_url'  => route('payment.chapa.return', ['order' => $order->id]),
                                                 
 'callback_url' => route('payment.chapa.callback'),
            'description' => 'Enrollment: ' . $course->title,
        ]);

        if ($result['success']) {
            return redirect($result['checkout_url']);
        }

        $order->update(['status' => 'failed']);

        $errorMsg = is_array($result['message'] ?? '') 
            ? implode(', ', $result['message']) 
            : ($result['message'] ?? 'Unknown error');

        \Log::error('Chapa init failed', ['result' => $result, 'order' => $order->id]);

        return back()->with('error', 'Payment initialization failed: ' . $errorMsg);
    }

    public function chapaReturn(Request $request, int $order)
    {
        $orderModel = Order::findOrFail($order);

        if ($orderModel->status === 'paid') {
            return redirect()->route('student.dashboard')->with('success', 'Already enrolled!');
        }

        $verify = $this->chapa->verifyPayment($orderModel->chapa_tx_ref);

        if ($verify['success']) {
            $orderModel->update(['transaction_id' => $verify['data']['id'] ?? null]);
            $this->enrollment->completePurchase($orderModel);
            return redirect()->route('student.dashboard')->with('success', '🎉 ምዝገባ ተሳካ! / Enrollment successful!');
        }

        return redirect()->route('checkout', $orderModel->course->slug)->with('error', 'Payment verification failed.');
    }

    public function chapaCallback(Request $request)
{
    // Chapa ከ JSON body ወይም ከ Query params በሚልክበት መንገድ መፈለግ
    $txRef = $request->input('trx_ref') 
          ?? $request->input('tx_ref') 
          ?? $request->input('data.tx_ref');

    if (!$txRef) {
        \Log::warning('Chapa Webhook: tx_ref missing in payload', $request->all());
        return response('OK');
    }

    $order = Order::where('chapa_tx_ref', $txRef)->first();
    if (!$order || $order->status === 'paid') return response('OK');

    $verify = $this->chapa->verifyPayment($txRef);
    if ($verify['success']) {
        $order->update(['transaction_id' => $verify['data']['id'] ?? null]);
        $this->enrollment->completePurchase($order);
        \Log::info("Chapa Webhook: Order {$order->id} successfully updated to paid.");
    }

    return response('OK');
}
    // ── STRIPE ─────────────────────────────────────────────────────────

    public function stripeIntent(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'amount'    => 'required|numeric|min:0.5',
            'coupon'    => 'nullable|string',
        ]);

        $course = Course::findOrFail($request->course_id);

        // Create pending order
        $order = Order::create([
            'order_number'   => Order::generateOrderNumber(),
            'user_id'        => auth()->id(),
            'course_id'      => $course->id,
            'amount'         => $request->amount,
            'currency'       => 'USD',
            'payment_method' => 'stripe',
            'status'         => 'pending',
            'coupon_code'    => $request->coupon,
            'discount_amount'=> $request->discount ?? 0,
        ]);

        $result = $this->stripe->createPaymentIntent($request->amount, 'usd', [
            'order_id'  => $order->id,
            'course_id' => $course->id,
        ]);

        if ($result['success']) {
            $order->update(['stripe_payment_intent' => $result['intent_id']]);
            return response()->json(['client_secret' => $result['client_secret'], 'order_id' => $order->id]);
        }

        $order->update(['status' => 'failed']);
        return response()->json(['error' => $result['message']], 422);
    }

    public function stripeSuccess(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        if ($order->status === 'paid') {
            return redirect()->route('student.dashboard')->with('success', 'Already enrolled!');
        }

        $intent = $this->stripe->retrieveIntent($order->stripe_payment_intent);
        if ($intent && $intent->status === 'succeeded') {
            $order->update(['transaction_id' => $intent->id]);
            $this->enrollment->completePurchase($order);
            return redirect()->route('student.dashboard')->with('success', '🎉 ምዝገባ ተሳካ! / Enrollment successful!');
        }

        return redirect()->route('checkout', $order->course->slug)->with('error', 'Payment not completed.');
    }

    public function stripeWebhook(Request $request)
    {
        $event = $this->stripe->constructWebhookEvent(
            $request->getContent(),
            $request->header('Stripe-Signature', '')
        );

        if (!$event) return response('Invalid signature', 400);

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            $order = Order::where('stripe_payment_intent', $intent->id)->first();
            if ($order && $order->status !== 'paid') {
                $order->update(['transaction_id' => $intent->id]);
                $this->enrollment->completePurchase($order);
            }
        }

        return response('OK');
    }
}
