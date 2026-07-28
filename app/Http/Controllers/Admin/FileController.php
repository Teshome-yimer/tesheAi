<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Course $course)
    {
        $course->load('sections.lessons.files');
        $allFiles = LessonFile::where('course_id', $course->id)
            ->with('lesson')
            ->orderBy('order')
            ->get();
        return view('admin.files.index', compact('course', 'allFiles'));
    }

    public function upload(Request $request, Lesson $lesson)
    {
        $request->validate([
            'file'    => 'required|file|max:102400', // 100MB
            'title'   => 'required|string|max:255',
            'is_free' => 'sometimes|boolean',
        ]);

        $file     = $request->file('file');
        $ext      = strtolower($file->getClientOriginalExtension());
        $path     = $file->store('lesson-files', 'public');

        LessonFile::create([
            'lesson_id' => $lesson->id,
            'course_id' => $lesson->course_id,
            'title'     => $request->title,
            'file_path' => $path,
            'file_type' => $ext,
            'file_size' => $file->getSize(),
            'is_free'   => $request->boolean('is_free'),
            'order'     => LessonFile::where('lesson_id', $lesson->id)->count() + 1,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'File uploaded!']);
        }
        return back()->with('success', 'File uploaded successfully!');
    }

    public function destroy(LessonFile $file)
    {
        Storage::disk('public')->delete($file->file_path);
        $file->delete();
        return back()->with('success', 'File deleted!');
    }

    public function toggleFree(LessonFile $file)
    {
        $file->update(['is_free' => !$file->is_free]);
        return back()->with('success', 'Updated!');
    }
}
