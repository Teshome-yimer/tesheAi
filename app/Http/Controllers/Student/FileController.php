<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LessonFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download(LessonFile $file)
    {
        // Free files — anyone can download (even guests)
        if (!$file->is_free) {
            // Must be logged in and enrolled
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Please login to download this file.');
            }
            if (!auth()->user()->isAdmin() && !auth()->user()->isEnrolledIn($file->course_id)) {
                return redirect()->route('course.show', $file->course->slug)
                    ->with('error', 'Enroll in this course to download files.');
            }
        }

        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File not found');
        }

        $fullPath = Storage::disk('public')->path($file->file_path);
        $fileName = $file->title . '.' . $file->file_type;

        return response()->download($fullPath, $fileName);
    }
}
