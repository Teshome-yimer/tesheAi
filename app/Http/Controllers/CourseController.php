<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function show(string $slug)
    {
        $course = Course::with(['sections.lessons'])->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $isEnrolled = auth()->check() && auth()->user()->isEnrolledIn($course->id);
        return view('course.show', compact('course', 'isEnrolled'));
    }
}
