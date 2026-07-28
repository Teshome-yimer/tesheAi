<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$course = App\Models\Course::first();
$lesson = App\Models\Lesson::first();
$admin = App\Models\User::where('role','admin')->first();
$student = App\Models\User::where('role','student')->first();
$enrolled = App\Models\Enrollment::where('user_id', $student->id)->first();

echo "=== PROJECT STATUS CHECK ===\n\n";
echo "COURSE: " . $course->title . "\n";
echo "SLUG: " . $course->slug . "\n";
echo "PUBLISHED: " . ($course->is_published ? 'YES' : 'NO') . "\n";
echo "LESSONS: " . App\Models\Lesson::count() . "\n";
echo "SECTIONS: " . App\Models\Section::count() . "\n\n";

echo "ADMIN: " . $admin->email . "\n";
echo "STUDENT: " . $student->email . "\n";
echo "STUDENT ENROLLED: " . ($enrolled ? 'YES - course_id='.$enrolled->course_id : 'NO') . "\n\n";

echo "FIRST LESSON SLUG: " . $lesson->slug . "\n";
echo "FIRST LESSON VIDEO: " . $lesson->video_url . "\n\n";

echo "ORDERS: " . App\Models\Order::count() . "\n";
echo "PAID ORDERS: " . App\Models\Order::where('status','paid')->count() . "\n\n";

echo "COUPONS: " . App\Models\Coupon::count() . "\n";
$coupon = App\Models\Coupon::first();
if($coupon) echo "TEST COUPON: " . $coupon->code . " (" . $coupon->value . "% off)\n\n";

echo "=== URLS TO TEST ===\n";
echo "Homepage:        http://127.0.0.1:8000\n";
echo "Course page:     http://127.0.0.1:8000/course/" . $course->slug . "\n";
echo "Checkout:        http://127.0.0.1:8000/checkout/" . $course->slug . "\n";
echo "Login:           http://127.0.0.1:8000/login\n";
echo "Register:        http://127.0.0.1:8000/register\n";
echo "Student dash:    http://127.0.0.1:8000/student/dashboard\n";
if($enrolled && $lesson) {
    echo "Course viewer:   http://127.0.0.1:8000/student/lesson/" . $course->slug . "/" . $lesson->slug . "\n";
}
echo "Admin dash:      http://127.0.0.1:8000/admin/dashboard\n";
echo "Admin courses:   http://127.0.0.1:8000/admin/courses\n";
echo "Admin orders:    http://127.0.0.1:8000/admin/orders\n";
echo "Admin coupons:   http://127.0.0.1:8000/admin/coupons\n";
echo "Admin students:  http://127.0.0.1:8000/admin/students\n\n";
echo "=== DONE ===\n";
