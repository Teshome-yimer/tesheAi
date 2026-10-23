<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function upload(Request $request, Lesson $lesson)
    {
        $request->validate([
            'video' => 'required|file|mimetypes:video/mp4,video/webm,video/ogg,video/avi,video/mov,video/mkv|max:512000', // 500MB
        ]);

        // 1. የቆየውን ቪዲዮ ከ Cloudflare R2 (s3) መሰረዝ
        if ($lesson->video_path) {
            Storage::disk('s3')->delete($lesson->video_path);
        }

        // 2. አዲሱን ቪዲዮ በቀጥታ ወደ Cloudflare R2 (s3) 'videos' ፎልደር መጫን
        $path = $request->file('video')->store('videos', 's3');

        $lesson->update([
            'video_path' => $path,
            'video_type' => 'local',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Video uploaded to Cloudflare R2!']);
        }

        return back()->with('success', 'Video uploaded successfully!');
    }

    public function stream(Lesson $lesson)
{
    // Check enrollment
    if (!auth()->user()->isAdmin() && !auth()->user()->isEnrolledIn($lesson->course_id)) {
        abort(403);
    }

    if (!$lesson->video_path || !Storage::disk('s3')->exists($lesson->video_path)) {
        abort(404, 'Video not found');
    }

    // ቪዲዮው ከ Cloudflare R2 በቀጥታ በሰሀራ ዩአርኤል እንዲታይ ማድረግ
    $url = Storage::disk('s3')->url($lesson->video_path);

    return redirect()->secure($url);
}

    public function delete(Lesson $lesson)
    {
        if ($lesson->video_path) {
            // 4. ቪዲዮው ሲሰረዝ ከ Cloudflare R2 እንዲጠፋ ማድረግ
            Storage::disk('s3')->delete($lesson->video_path);
            $lesson->update(['video_path' => null, 'video_type' => 'youtube']);
        }
        return back()->with('success', 'Video deleted!');
    }
}
