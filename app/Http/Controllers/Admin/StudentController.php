<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search  = trim((string) $request->query('q', ''));
        $perPage = in_array((int) $request->query('per_page'), [10, 20, 50, 100]) ? (int) $request->query('per_page') : 10;

        $students = User::withCount('enrollments')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("CASE WHEN role = 'admin' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.students.index', compact('students', 'search', 'perPage'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:30',
            'role'     => 'required|in:student,admin',
            'password' => 'required|string|min:6',
        ]);

        User::create($data);

        return back()->with('success', $data['role'] === 'admin'
            ? 'አዲስ Admin በተሳካ ሁኔታ ተፈጥሯል!'
            : 'አዲስ ተጠቃሚ በተሳካ ሁኔታ ተፈጥሯል!');
    }

    public function update(Request $request, User $user)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone'    => 'nullable|string|max:30',
        'role'     => 'required|in:student,admin',
        'password' => 'nullable|string|min:6',
    ]);

    // 🛡️ ጥበቃ 1፡ የዋናው Admin Email ከሆነ ሁልጊዜ Admin እንደሆነ እንዲቀጥል ያስገድደዋል
    if ($user->email === 'tesheyimer12@gmail.com') { 
        $data['role'] = 'admin'; 
    }

    if ($user->isAdmin() && $data['role'] !== 'admin'
        && User::where('role', 'admin')->where('id', '!=', $user->id)->count() === 0) {
        return back()->withErrors(['role' => 'በሲስተሙ ውስጥ የቀረውን የመጨረሻ Admin መቀየር አይቻልም!']);
    }

    if (empty($data['password'])) {
        unset($data['password']);
    }

    $user->update($data);

    return back()->with('success', 'የተጠቃሚው መረጃ በተሳካ ሁኔታ ተስተካክሏል!');
}

public function destroy(User $user)
{
    // 🛡️ ጥበቃ 2፡ ዋናውን Admin በኢሜይሉ ለይቶ መደለት እንዳይቻል ይከለክላል
    if ($user->email === 'tesheyimer12@gmail.com') {
        return back()->withErrors(['delete' => 'ዋናውን Admin አካውንት መደለት አይቻልም!']);
    }

    if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
        return back()->withErrors(['delete' => 'በሲስተሙ ውስጥ የቀረውን የመጨረሻ Admin መደለት አይቻልም!']);
    }

    $user->delete();

    return back()->with('success', 'ተጠቃሚው ተሰርዟል!');
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

        return back()->with('success', 'ተማሪው ኮርሱ ላይ ተመዝግቧል!');
    }

    public function enrollForm()
    {
        $students = User::where('role', 'student')->get();
        $courses  = Course::where('is_published', true)->get();
        return view('admin.students.enroll', compact('students', 'courses'));
    }
}
