<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('enrollments')->latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.form', ['course' => new Course()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateCourse($request);
        $data['slug'] = Str::slug($request->title);
        $data['what_you_learn'] = array_filter(explode("\n", $request->what_you_learn ?? ''));

        if ($request->hasFile('thumbnail')) {
    $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 's3');
}
        Course::create($data);
        return redirect()->route('admin.courses.index')->with('success', 'ኮርስ ተፈጥሯል / Course created!');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validateCourse($request);
        $data['what_you_learn'] = array_filter(explode("\n", $request->what_you_learn ?? ''));

        if ($request->hasFile('thumbnail')) {
    $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 's3');
}

        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'ኮርስ ተስተካክሏል / Course updated!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'ኮርስ ተሰርዟል / Course deleted!');
    }

    public function togglePublish(Course $course)
    {
        $course->update(['is_published' => !$course->is_published]);
        $msg = $course->is_published ? 'Published' : 'Unpublished';
        return back()->with('success', $msg);
    }

    private function validateCourse(Request $request): array
    {
        return $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'price_etb'          => 'required|numeric|min:0',
            'price_usd'          => 'required|numeric|min:0',
            'original_price_etb' => 'nullable|numeric',
            'original_price_usd' => 'nullable|numeric',
            'total_lessons'      => 'required|integer',
            'total_hours'        => 'required|numeric',
            'level'              => 'required|in:beginner,intermediate,advanced',
            'language'           => 'required|string',
            'preview_video'      => 'nullable|url',
            'thumbnail'          => 'nullable|image|max:2048',
            'is_published'       => 'sometimes|boolean',
            'is_featured'        => 'sometimes|boolean',
        ]);
    }
}
