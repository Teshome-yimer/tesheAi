<?php
// One-time admin password reset
// DELETE this file after use!

define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$secret = $_GET['key'] ?? '';
if ($secret !== 'teshe2024reset') {
    die("<div style='color:red;font-family:monospace;padding:40px;'>❌ Invalid key</div>");
}

$user = App\Models\User::where('email', 'admin@course.com')->first();

if (!$user) {
    // Create admin if not exists
    $user = App\Models\User::create([
        'name'     => 'Admin User',
        'email'    => 'admin@course.com',
        'phone'    => '+251900000000',
        'password' => bcrypt('Teshe@Admin2024'),
        'role'     => 'admin',
    ]);
    $msg = "✅ Admin user CREATED!";
} else {
    $user->password = bcrypt('Teshe@Admin2024');
    $user->role = 'admin';
    $user->save();
    $msg = "✅ Admin password RESET!";
}

echo "<div style='background:#0a0a0f;color:#10b981;font-family:monospace;padding:40px;font-size:18px;'>";
echo $msg . "<br><br>";
echo "Email: <strong>admin@course.com</strong><br>";
echo "Password: <strong>Teshe@Admin2024</strong><br><br>";
echo "<a href='/admin/login' style='color:#6366f1;font-size:16px;'>→ Go to Admin Login</a><br><br>";
echo "<span style='color:#ef4444;font-size:14px;'>⚠️ Delete this file after use: public/reset-admin.php</span>";
echo "</div>";
