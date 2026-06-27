<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Stripe webhook (no CSRF)
Route::post('/webhooks/stripe', [PaymentController::class, 'stripeWebhook']);
