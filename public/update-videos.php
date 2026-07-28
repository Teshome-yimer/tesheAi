<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$videoUrl = 'https://www.youtube.com/embed/lbqZnCjoTv4';

$count = App\Models\Lesson::count();
App\Models\Lesson::query()->update(['video_url' => $videoUrl]);

// Also update course preview video
App\Models\Course::query()->update(['preview_video' => $videoUrl]);

echo "<div style='background:#0a0a0f;color:#10b981;font-family:monospace;padding:40px;font-size:16px;'>";
echo "✅ Updated " . $count . " lessons with video:<br><br>";
echo "<span style='color:#22d3ee;'>" . $videoUrl . "</span><br><br>";
echo "<a href='/student/dashboard' style='color:#6366f1;font-size:18px;'>→ Go to Student Dashboard & Watch</a><br><br>";
echo "<a href='/admin/courses/1/content' style='color:#22d3ee;'>→ Admin Course Content</a>";
echo "</div>";
