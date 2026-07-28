<?php
// Quick project status — open http://127.0.0.1:8000/project-check.php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$course  = App\Models\Course::first();
$lesson  = App\Models\Lesson::orderBy('order')->first();
$admin   = App\Models\User::where('role','admin')->first();
$student = App\Models\User::where('role','student')->first();

// Auto-enroll student if not enrolled
if ($student && $course) {
    App\Models\Enrollment::firstOrCreate(
        ['user_id' => $student->id, 'course_id' => $course->id],
        ['enrolled_at' => now()]
    );
}

$enrolled   = App\Models\Enrollment::where('user_id', $student->id)->exists();
$slug       = $course->slug;
$lslug      = $lesson ? ($lesson->slug ?? $lesson->id) : 'no-lesson';
$base       = 'http://127.0.0.1:8000';
$coupon     = App\Models\Coupon::where('is_active', true)->first();

$pages = [
    ['🏠 Homepage',             "$base/",                          'public'],
    ['📚 Course Detail Page',   "$base/course/$slug",              'public'],
    ['🛒 Checkout Page',        "$base/checkout/$slug",            'auth'],
    ['🔐 Login',                "$base/login",                     'public'],
    ['📝 Register',             "$base/register",                  'public'],
    ['📊 Student Dashboard',    "$base/student/dashboard",         'student'],
    ['🎥 Course Viewer',        "$base/student/course/$slug",      'student'],
    ['▶ Lesson Viewer',         "$base/student/lesson/$slug/$lslug", 'student'],
    ['⚙️ Admin Dashboard',      "$base/admin/dashboard",           'admin'],
    ['📚 Admin - Courses',      "$base/admin/courses",             'admin'],
    ['📝 Admin - Course Content',"$base/admin/courses/{$course->id}/content", 'admin'],
    ['💰 Admin - Orders',       "$base/admin/orders",              'admin'],
    ['👥 Admin - Students',     "$base/admin/students",            'admin'],
    ['🏷️ Admin - Coupons',      "$base/admin/coupons",             'admin'],
    ['➕ Admin - Manual Enroll', "$base/admin/students/enroll",     'admin'],
    ['➕ Admin - New Course',    "$base/admin/courses/create",      'admin'],
    ['➕ Admin - New Coupon',    "$base/admin/coupons/create",      'admin'],
];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>EduPlatform — Project Status</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #0a0a0f; color: #e2e8f0; font-family: 'Segoe UI', sans-serif; padding: 32px 24px; }
h1 { background: linear-gradient(135deg, #6366f1, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 2rem; margin-bottom: 8px; }
.sub { color: #64748b; margin-bottom: 32px; }
.grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 32px; }
.stat { background: #13131a; border: 1px solid #2a2a3a; border-radius: 12px; padding: 20px; text-align: center; }
.stat-num { font-size: 2.2rem; font-weight: 800; background: linear-gradient(135deg, #6366f1, #22d3ee); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.stat-label { color: #64748b; font-size: 0.82rem; margin-top: 4px; }
.section { background: #13131a; border: 1px solid #2a2a3a; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
.section h2 { font-size: 1rem; font-weight: 700; margin-bottom: 16px; color: #22d3ee; }
.info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #1a1a24; font-size: 0.9rem; }
.info-row:last-child { border-bottom: none; }
.label { color: #64748b; }
.value { color: #e2e8f0; font-weight: 500; }
.pages-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 10px; }
.page-link { display: flex; align-items: center; justify-content: space-between; background: #1a1a24; border: 1px solid #2a2a3a; border-radius: 8px; padding: 12px 16px; text-decoration: none; transition: .2s; }
.page-link:hover { border-color: #6366f1; background: rgba(99,102,241,.08); }
.page-name { color: #e2e8f0; font-size: 0.88rem; font-weight: 500; }
.page-badge { font-size: 0.7rem; padding: 2px 8px; border-radius: 99px; }
.badge-public { background: rgba(16,185,129,.2); color: #10b981; }
.badge-auth { background: rgba(99,102,241,.2); color: #6366f1; }
.badge-student { background: rgba(34,211,238,.2); color: #22d3ee; }
.badge-admin { background: rgba(239,68,68,.2); color: #ef4444; }
.cred { background: rgba(99,102,241,.1); border: 1px solid rgba(99,102,241,.3); border-radius: 8px; padding: 12px 16px; font-family: monospace; font-size: 0.9rem; margin-bottom: 8px; }
.success { color: #10b981; } .warn { color: #fbbf24; }
</style>
</head>
<body>
<h1>🎓 EduPlatform — Project Status</h1>
<p class="sub">ሁሉም pages ከዚህ ይክፈቱ / Click any page to open it</p>

<div class="grid">
    <div class="stat"><div class="stat-num"><?= App\Models\Course::count() ?></div><div class="stat-label">📚 Courses</div></div>
    <div class="stat"><div class="stat-num"><?= App\Models\Lesson::count() ?></div><div class="stat-label">🎥 Lessons</div></div>
    <div class="stat"><div class="stat-num"><?= App\Models\User::count() ?></div><div class="stat-label">👥 Users</div></div>
    <div class="stat"><div class="stat-num"><?= App\Models\Enrollment::count() ?></div><div class="stat-label">🎓 Enrollments</div></div>
    <div class="stat"><div class="stat-num"><?= App\Models\Order::where('status','paid')->count() ?></div><div class="stat-label">💰 Paid Orders</div></div>
    <div class="stat"><div class="stat-num"><?= App\Models\Coupon::count() ?></div><div class="stat-label">🏷️ Coupons</div></div>
</div>

<div class="section">
    <h2>📋 Course Info</h2>
    <div class="info-row"><span class="label">Title</span><span class="value"><?= $course->title ?></span></div>
    <div class="info-row"><span class="label">Price</span><span class="value"><?= number_format($course->price_etb) ?> ETB / $<?= $course->price_usd ?> USD</span></div>
    <div class="info-row"><span class="label">Original Price</span><span class="value"><?= number_format($course->original_price_etb) ?> ETB (<?= $course->discountPercentageEtb() ?>% off)</span></div>
    <div class="info-row"><span class="label">Published</span><span class="value <?= $course->is_published ? 'success' : 'warn' ?>"><?= $course->is_published ? '✅ Yes' : '⚠️ No — go to admin/courses to publish' ?></span></div>
    <div class="info-row"><span class="label">Sections</span><span class="value"><?= App\Models\Section::count() ?></span></div>
    <?php if($coupon): ?>
    <div class="info-row"><span class="label">Test Coupon</span><span class="value" style="color:#22d3ee;font-weight:700;"><?= $coupon->code ?> — <?= $coupon->value ?><?= $coupon->type == 'percentage' ? '%' : ' ETB' ?> off</span></div>
    <?php endif; ?>
</div>

<div class="section">
    <h2>🔑 Login Credentials</h2>
    <div class="cred">👑 Admin &nbsp;&nbsp; Email: <strong><?= $admin->email ?></strong> &nbsp;&nbsp; Password: <strong>password</strong></div>
    <div class="cred">🎓 Student &nbsp; Email: <strong><?= $student->email ?></strong> &nbsp; Password: <strong>password</strong> &nbsp;
        <?php if($enrolled): ?>
        <span class="success">✅ Enrolled in course</span>
        <?php else: ?>
        <span class="warn">⚠️ Not enrolled</span>
        <?php endif; ?>
    </div>
</div>

<div class="section">
    <h2>🔗 All Pages — Click to Open</h2>
    <div class="pages-grid">
        <?php foreach($pages as [$name, $url, $type]): ?>
        <a href="<?= $url ?>" target="_blank" class="page-link">
            <span class="page-name"><?= $name ?></span>
            <span class="page-badge badge-<?= $type ?>"><?= $type ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<p style="color:#64748b;font-size:0.8rem;text-align:center;margin-top:16px;">
    Delete <code>public/project-check.php</code> before going live
</p>
</body>
</html>
