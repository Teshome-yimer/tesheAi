<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Coupon;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Section;
use App\Models\User;
use Illuminate\Console\Command;

class CheckProject extends Command
{
    protected $signature = 'project:check';
    protected $description = 'Check all project data and URLs';

    public function handle(): void
    {
        $this->info('');
        $this->info('=== EduPlatform PROJECT STATUS ===');
        $this->info('');

        // DB Data
        $course  = Course::first();
        $lesson  = Lesson::first();
        $admin   = User::where('role', 'admin')->first();
        $student = User::where('role', 'student')->first();

        $this->table(['Item', 'Value'], [
            ['Courses',         Course::count()],
            ['Sections',        Section::count()],
            ['Lessons',         Lesson::count()],
            ['Users (total)',   User::count()],
            ['Enrollments',     Enrollment::count()],
            ['Orders (total)',  Order::count()],
            ['Orders (paid)',   Order::where('status', 'paid')->count()],
            ['Coupons',         Coupon::count()],
        ]);

        $this->info('');
        $this->info('--- Course ---');
        $this->line('Title:    ' . $course->title);
        $this->line('Slug:     ' . $course->slug);
        $this->line('Price:    ' . $course->price_etb . ' ETB / $' . $course->price_usd . ' USD');
        $this->line('Published:' . ($course->is_published ? ' YES' : ' NO'));

        $this->info('');
        $this->info('--- Credentials ---');
        $this->line('Admin:    ' . $admin->email . '  /  password');
        $this->line('Student:  ' . $student->email . '  /  password');

        $enrolled = Enrollment::where('user_id', $student->id)->first();
        $this->line('Student enrolled: ' . ($enrolled ? 'YES' : 'NO - enroll via admin panel'));

        $coupon = Coupon::where('is_active', true)->first();
        if ($coupon) {
            $this->line('Coupon:   ' . $coupon->code . ' (' . $coupon->value . ($coupon->type == 'percentage' ? '%' : ' ETB') . ' off)');
        }

        $this->info('');
        $this->info('--- All URLs ---');
        $base = 'http://127.0.0.1:8000';
        $slug = $course->slug;
        $lslug = $lesson ? $lesson->slug : 'lesson-slug';

        $urls = [
            ['Homepage',          "$base/"],
            ['Course detail',     "$base/course/$slug"],
            ['Checkout',          "$base/checkout/$slug"],
            ['Login',             "$base/login"],
            ['Register',          "$base/register"],
            ['Student dashboard', "$base/student/dashboard"],
            ['Course viewer',     "$base/student/course/$slug"],
            ['Lesson viewer',     "$base/student/lesson/$slug/$lslug"],
            ['Admin dashboard',   "$base/admin/dashboard"],
            ['Admin - Courses',   "$base/admin/courses"],
            ['Admin - Content',   "$base/admin/courses/" . $course->id . "/content"],
            ['Admin - Orders',    "$base/admin/orders"],
            ['Admin - Students',  "$base/admin/students"],
            ['Admin - Coupons',   "$base/admin/coupons"],
            ['Admin - Enroll',    "$base/admin/students/enroll"],
        ];

        $this->table(['Page', 'URL'], $urls);

        $this->info('');
        $this->info('Server running at: ' . $base);
        $this->info('Run START.bat to launch everything.');
        $this->info('');
    }
}
