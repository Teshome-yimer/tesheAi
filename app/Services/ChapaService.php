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
                    'title'       => 'EduPlatform',
                    'description' => substr(preg_replace('/[^a-zA-Z0-9\s\-_\.]/', '', 'Course Enrollment'), 0, 50),
                ],
            ]);

        if ($response->successful()) {
            return ['success' => true, 'checkout_url' => $response->json('data.checkout_url')];
        }

        $message = $response->json('message', 'Payment initialization failed');
        if (is_array($message)) {
            $message = implode(', ', array_map(fn($v) => is_array($v) ? implode(', ', $v) : $v, $message));
        }

        return ['success' => false, 'message' => $message];
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
