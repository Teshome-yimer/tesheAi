<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function show(string $slug)
    {
        $course = Course::with(['sections.lessons'])->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $isEnrolled = auth()->check() && auth()->user()->isEnrolledIn($course->id);

        // 🎯 ተማሪው ከፈለ እና ኮርሱ VIP ከሆነ በቀጥታ ወደ Telegram ቻናል ይላካል
        if ($isEnrolled && $course->slug === 'vip-telegram-access-all-premium-courses') {
            return redirect()->away('https://t.me/+qDjJMxPexn03NmQ8');
        }

        return view('course.show', compact('course', 'isEnrolled'));
    }
}
