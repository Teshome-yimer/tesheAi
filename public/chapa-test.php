<?php
// Debug Chapa API — http://127.0.0.1:8000/chapa-test.php
// DELETE this file before going live!
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$secretKey = config('services.chapa.secret');

echo "<pre style='background:#0a0a0f;color:#e2e8f0;padding:24px;font-size:14px;'>";
echo "=== CHAPA DEBUG ===\n\n";
echo "Secret Key: " . substr($secretKey, 0, 20) . "...\n\n";

$response = \Illuminate\Support\Facades\Http::withToken($secretKey)
    ->withoutVerifying()
    ->post('https://api.chapa.co/v1/transaction/initialize', [
        'amount'       => '100',
        'currency'     => 'ETB',
        'email'        => 'test@test.com',
        'first_name'   => 'Test',
        'last_name'    => 'User',
        'phone_number' => '+251912345678',
        'tx_ref'       => 'TEST-' . time(),
        'return_url'   => 'http://127.0.0.1:8000',
        'callback_url' => 'http://127.0.0.1:8000/payment/chapa/callback',
        'customization'=> ['title' => 'Test'],
    ]);

echo "HTTP Status: " . $response->status() . "\n\n";
echo "Full Response:\n";
echo json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\n";

if ($response->successful() && $response->json('data.checkout_url')) {
    echo "✅ SUCCESS!\n";
    echo "Checkout URL: " . $response->json('data.checkout_url') . "\n";
} else {
    echo "❌ FAILED\n";
    $msg = $response->json('message');
    echo "Message: " . (is_array($msg) ? json_encode($msg) : $msg) . "\n";
}
echo "</pre>";
