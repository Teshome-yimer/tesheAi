<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Coupon;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Database\Seeders\HtmlCssJsQuizzesSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(['email' => 'admin@course.com'], [
            'name'     => 'Admin User',
            'phone'    => '+251900000000',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Demo student
        User::firstOrCreate(['email' => 'student@course.com'], [
            'name'     => 'Demo Student',
            'phone'    => '+251911000000',
            'password' => Hash::make('password'),
            'role'     => 'student',
        ]);

        // Course
        $course = Course::firstOrCreate(['slug' => 'web-development-bootcamp'], [
            'title'              => 'Web Development Bootcamp',
            'description'        => 'Laravel, React, እና MySQL ተጠቅመው ሙሉ ስታክ ድረ-ገጽ ዲቬሎፐር ሁኑ። ይህ ኮርስ ከባዶ ጀምሮ ፕሮፌሽናል ዲቬሎፐር እንዲሆኑ ያስችሎታል። Build full-stack web applications using Laravel, React and MySQL from scratch.',
            'what_you_learn'     => [
                'Laravel 11 Backend Development / ላራቬል 11 ባክኤንድ ዲቬሎፕሜንት',
                'React.js Frontend / ሪኤክት.ጄኤስ ፍሮንቴንድ',
                'MySQL Database Design / MySQL ዳታቤዝ ዲዛይን',
                'REST API Development / ሬስት ኤፒአይ ዲቬሎፕሜንት',
                'Authentication & Security / ኦቶሜቲኬሽን እና ደህንነት',
                'Deployment & DevOps / ዲፕሎይሜንት',
            ],
            'price_etb'          => 2980.00,
            'price_usd'          => 49.00,
            'original_price_etb' => 5000.00,
            'original_price_usd' => 89.00,
            'total_lessons'      => 50,
            'total_hours'        => 30,
            'level'              => 'beginner',
            'language'           => 'Amharic + English',
            'is_published'       => true,
            'is_featured'        => true,
            'preview_video'      => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ]);

        // Sections + Lessons
        $sectionsData = [
            ['title' => 'Introduction / መግቢያ', 'lessons' => ['Welcome & Setup / እንኳን ደህና መጡ', 'Tools Installation / መሳሪያዎች መጫን', 'Project Overview / ፕሮጀክት አጠቃላይ']],
            ['title' => 'Laravel Basics / ላራቬል መሰረታዊ', 'lessons' => ['MVC Architecture', 'Routes & Controllers', 'Blade Templates', 'Eloquent ORM']],
            ['title' => 'Database Design / ዳታቤዝ', 'lessons' => ['Migrations', 'Relationships', 'Seeders & Factories']],
            ['title' => 'React Frontend / ሪኤክት', 'lessons' => ['React Setup', 'Components', 'State & Props', 'API Integration']],
            ['title' => 'Authentication / ኦቶሜቲኬሽን', 'lessons' => ['Laravel Auth', 'JWT Tokens', 'Role Management']],
            ['title' => 'Deployment / ዲፕሎይሜንት', 'lessons' => ['Server Setup', 'Deploy to VPS', 'Domain & SSL']],
        ];

        $lessonOrder = 1;
        foreach ($sectionsData as $i => $sData) {
            $section = Section::firstOrCreate(
                ['course_id' => $course->id, 'title' => $sData['title']],
                ['order' => $i + 1]
            );
            foreach ($sData['lessons'] as $j => $lessonTitle) {
                Lesson::firstOrCreate(
                    ['course_id' => $course->id, 'section_id' => $section->id, 'title' => $lessonTitle],
                    [
                        'slug'              => Str::slug($lessonTitle) . '-' . $lessonOrder,
                        'video_url'         => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                        'description'       => $lessonTitle . ' - ዝርዝር ማብራሪያ ቪዲዮ ትምህርት',
                        'duration_minutes'  => rand(15, 45),
                        'order'             => $lessonOrder++,
                        'is_free_preview'   => $lessonOrder <= 3,
                    ]
                );
            }
        }

        // Sample coupon
        Coupon::firstOrCreate(['code' => 'SAVE20'], [
            'type'      => 'percentage',
            'value'     => 20,
            'max_uses'  => 100,
            'is_active' => true,
        ]);

        $this->call(HtmlCssJsQuizzesSeeder::class);
    }
}
