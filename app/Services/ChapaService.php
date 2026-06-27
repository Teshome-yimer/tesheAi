<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChapaService
{
    private string $secretKey;
    private string $baseUrl = 'https://api.chapa.co/v1';

    public function __construct()
    {
        $this->secretKey = config('services.chapa.secret');
    }

    public function initializePayment(array $data): array
    {
        $response = Http::withToken($this->secretKey)
            ->withoutVerifying()
            ->post("{$this->baseUrl}/transaction/initialize", [
                'amount'        => $data['amount'],
                'currency'      => 'ETB',
                'email'         => $data['email'],
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'] ?? '',
                'phone_number'  => $data['phone'] ?? '',
                'tx_ref'        => $data['tx_ref'],
                'callback_url'  => route('payment.chapa.callback'),
                'return_url'    => $data['return_url'],
                'customization' => [
                    'title'       => config('app.name'),
                    'description' => $data['description'] ?? 'Course Purchase',
                ],
            ]);

        if ($response->successful()) {
            return ['success' => true, 'checkout_url' => $response->json('data.checkout_url')];
        }

        return ['success' => false, 'message' => $response->json('message', 'Payment initialization failed')];
    }

    public function verifyPayment(string $txRef): array
    {
        $response = Http::withToken($this->secretKey)
            ->withoutVerifying()
            ->get("{$this->baseUrl}/transaction/verify/{$txRef}");

        if ($response->successful() && $response->json('status') === 'success') {
            $data = $response->json('data');
            return [
                'success' => $data['status'] === 'success',
                'data'    => $data,
            ];
        }

        return ['success' => false, 'message' => 'Verification failed'];
    }
}
