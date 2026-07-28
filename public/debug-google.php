<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$clientId    = config('services.google.client_id');
$redirectUrl = config('services.google.redirect');

echo "<div style='background:#0a0a0f;color:#e2e8f0;font-family:monospace;padding:32px;font-size:15px;'>";
echo "<h2 style='color:#6366f1;margin-bottom:16px;'>Google OAuth Debug</h2>";
echo "<b style='color:#64748b;'>Client ID:</b> " . substr($clientId, 0, 40) . "...<br><br>";
echo "<b style='color:#64748b;'>Redirect URL in code:</b> <span style='color:#22d3ee;'>" . $redirectUrl . "</span><br><br>";
echo "<hr style='border-color:#2a2a3a;margin:16px 0;'>";
echo "<b style='color:#fbbf24;'>⚠️ Google Console ውስጥ ይህን EXACTLY ጨምር:</b><br><br>";
echo "<span style='background:#13131a;border:1px solid #6366f1;padding:10px 16px;border-radius:8px;color:#22d3ee;font-size:1.1rem;display:inline-block;'>";
echo $redirectUrl;
echo "</span><br><br>";
echo "<a href='https://console.cloud.google.com/apis/credentials' target='_blank' style='color:#6366f1;'>→ Open Google Console</a>";
echo "</div>";
