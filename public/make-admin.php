<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Make ALL users admin if ?all=1
if (isset($_GET['all'])) {
    App\Models\User::query()->update(['role' => 'admin']);
    echo "<script>location='http://127.0.0.1:9000/admin/dashboard'</script>";
    exit;
}

// Make specific user admin
if (isset($_GET['id'])) {
    $user = App\Models\User::find($_GET['id']);
    if ($user) {
        $user->role = 'admin';
        $user->save();
        echo "<script>location='http://127.0.0.1:9000/admin/dashboard'</script>";
        exit;
    }
}

$users = App\Models\User::all();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body{background:#0a0a0f;color:#e2e8f0;font-family:monospace;padding:40px;}
h2{color:#6366f1;margin-bottom:20px;}
.user{background:#13131a;border:1px solid #2a2a3a;border-radius:8px;padding:16px 20px;margin-bottom:10px;display:flex;align-items:center;justify-content:space-between;gap:16px;}
.user.admin{border-color:#10b981;}
a.btn{background:linear-gradient(135deg,#6366f1,#22d3ee);color:#000;font-weight:700;padding:8px 20px;border-radius:6px;text-decoration:none;font-size:0.85rem;}
.role{padding:3px 10px;border-radius:99px;font-size:0.75rem;font-weight:600;}
.r-admin{background:rgba(16,185,129,.2);color:#10b981;}
.r-student{background:rgba(99,102,241,.2);color:#6366f1;}
</style>
</head>
<body>
<h2>👥 Users — Admin ምረጥ</h2>
<?php foreach($users as $u): ?>
<div class="user <?= $u->role=='admin'?'admin':'' ?>">
    <div>
        <div style="font-weight:700;"><?= $u->name ?></div>
        <div style="color:#64748b;font-size:0.85rem;"><?= $u->email ?></div>
    </div>
    <div style="display:flex;align-items:center;gap:12px;">
        <span class="role r-<?= $u->role ?>"><?= $u->role ?></span>
        <?php if($u->role != 'admin'): ?>
        <a href="?id=<?= $u->id ?>" class="btn">→ Make Admin</a>
        <?php else: ?>
        <a href="http://127.0.0.1:9000/admin/dashboard" class="btn" style="background:linear-gradient(135deg,#10b981,#22d3ee);">→ Go to Dashboard</a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
</body>
</html>
