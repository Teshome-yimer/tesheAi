<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function manage(Course $course)
    {
        $course->load('sections.lessons');
        return view('admin.courses.content', compact('course'));
    }

    // Sections
    public function storeSection(Request $request, Course $course)
    {
        $request->validate(['title' => 'required|string', 'order' => 'nullable|integer']);
        $course->sections()->create(['title' => $request->title, 'order' => $request->order ?? 0]);
        return back()->with('success', 'Section added!');
    }

    public function updateSection(Request $request, Section $section)
    {
        $request->validate(['title' => 'required|string']);
        $section->update(['title' => $request->title, 'order' => $request->order ?? $section->order]);
        return back()->with('success', 'Section updated!');
    }

    public function destroySection(Section $section)
    {
        $section->delete();
        return back()->with('success', 'Section deleted!');
    }

    // Lessons
    public function storeLesson(Request $request, Section $section)
    {
        $data = $request->validate([
            'title'            => 'required|string',
            'video_url'        => 'nullable|string',
            'description'      => 'nullable|string',
            'duration_minutes' => 'nullable|integer',
            'order'            => 'nullable|integer',
            'is_free_preview'  => 'sometimes|boolean',
        ]);
        $data['course_id'] = $section->course_id;
        $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        $section->lessons()->create($data);
        return back()->with('success', 'Lesson added!');
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title'            => 'required|string',
            'video_url'        => 'nullable|string',
            'description'      => 'nullable|string',
            'duration_minutes' => 'nullable|integer',
            'order'            => 'nullable|integer',
            'is_free_preview'  => 'sometimes|boolean',
        ]);
        $lesson->update($data);
        return back()->with('success', 'Lesson updated!');
    }

    public function destroyLesson(Lesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson deleted!');
    }
}
