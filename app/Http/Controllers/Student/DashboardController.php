<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Services\EnrollmentService;

class DashboardController extends Controller
{
    public function __construct(private EnrollmentService $enrollmentService) {}

    public function index()
    {
        $enrollments = Enrollment::with('course')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $enrollments->each(function ($enrollment) {
            $enrollment->progress = $this->enrollmentService->getCourseProgress(
                auth()->id(), $enrollment->course_id
            );
        });

        return view('student.dashboard', compact('enrollments'));
    }
}
