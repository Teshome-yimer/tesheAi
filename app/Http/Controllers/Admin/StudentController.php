<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->withCount('enrollments')->latest()->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        Enrollment::firstOrCreate(
            ['user_id' => $request->user_id, 'course_id' => $request->course_id],
            ['enrolled_at' => now()]
        );

        return back()->with('success', 'Student enrolled manually!');
    }

    public function enrollForm()
    {
        $students = User::where('role', 'student')->get();
        $courses  = Course::where('is_published', true)->get();
        return view('admin.students.enroll', compact('students', 'courses'));
    }
}
