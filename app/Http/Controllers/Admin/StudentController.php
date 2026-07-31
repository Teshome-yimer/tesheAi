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

        $user = User::create($data);

        // Single-admin policy: creating a new admin demotes every other admin.
        if ($data['role'] === 'admin') {
            User::where('id', '!=', $user->id)->where('role', 'admin')->update(['role' => 'student']);
        }

        return back()->with('success', $data['role'] === 'admin'
            ? 'New admin created. This is now the only admin login.'
            : 'New user created!');
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

        // Safety: never demote the last remaining admin
        if ($user->isAdmin() && $data['role'] !== 'admin'
            && User::where('role', 'admin')->where('id', '!=', $user->id)->count() === 0) {
            return back()->withErrors(['role' => 'Cannot remove the last admin account.']);
        }

        if (empty($data['password'])) {
            unset($data['password']); // keep current password
        }

        $user->update($data);

        // 🔐 Single-admin policy: saving a user as admin demotes every other admin
        if ($data['role'] === 'admin') {
            User::where('id', '!=', $user->id)->where('role', 'admin')->update(['role' => 'student']);
        }

        return back()->with('success', 'User updated! ' . ($user->isAdmin() ? 'This is now the ONLY admin — login uses this email/password.' : ''));
    }

    public function destroy(User $user)
    {
        // Admin account can never be deleted (protects the only admin)
        if ($user->isAdmin()) {
            return back()->withErrors(['delete' => 'The admin account cannot be deleted.']);
        }

        $user->delete();

        return back()->with('success', 'User deleted!');
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
