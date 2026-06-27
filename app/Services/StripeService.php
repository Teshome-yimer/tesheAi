<?php

namespace App\Services;

/**
 * StripeService — wraps the stripe/stripe-php SDK.
 *
 * Install the SDK when SSL is available:
 *   composer require stripe/stripe-php
 *
 * Until then the methods return safe fallbacks so the rest of the app loads fine.
 */
class StripeService
{
    private bool $available;

    public function __construct()
    {
        $this->available = class_exists(\Stripe\Stripe::class);

        if ($this->available) {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        }
    }

    public function createPaymentIntent(float $amount, string $currency = 'usd', array $metadata = []): array
    {
        if (!$this->available) {
            return ['success' => false, 'message' => 'Stripe SDK not installed. Run: composer require stripe/stripe-php'];
        }

        try {
            $intent = \Stripe\PaymentIntent::create([
                'amount'   => (int) ($amount * 100),
                'currency' => strtolower($currency),
                'metadata' => $metadata,
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            return ['success' => true, 'client_secret' => $intent->client_secret, 'intent_id' => $intent->id];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function retrieveIntent(string $intentId): ?object
    {
        if (!$this->available) return null;

        try {
            return \Stripe\PaymentIntent::retrieve($intentId);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function constructWebhookEvent(string $payload, string $sigHeader): ?object
    {
        if (!$this->available) return null;

        try {
            return \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            return null;
        }
    }
}
