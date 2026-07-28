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

        // Delete old video if exists
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
        }

        $path = $request->file('video')->store('videos', 'public');

        $lesson->update([
            'video_path' => $path,
            'video_type' => 'local',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Video uploaded!']);
        }

        return back()->with('success', 'Video uploaded successfully!');
    }

    public function stream(Lesson $lesson)
    {
        // Check enrollment
        if (!auth()->user()->isAdmin() && !auth()->user()->isEnrolledIn($lesson->course_id)) {
            abort(403);
        }

        if (!$lesson->video_path || !Storage::disk('public')->exists($lesson->video_path)) {
            abort(404, 'Video not found');
        }

        $path     = Storage::disk('public')->path($lesson->video_path);
        $size     = filesize($path);
        $mimeType = mime_content_type($path);

        $start  = 0;
        $end    = $size - 1;
        $length = $size;

        $headers = [
            'Content-Type'   => $mimeType,
            'Accept-Ranges'  => 'bytes',
            'Content-Length' => $size,
        ];

        if (request()->hasHeader('Range')) {
            $range = request()->header('Range');
            preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
            $start  = (int) $matches[1];
            $end    = isset($matches[2]) && $matches[2] !== '' ? (int) $matches[2] : $size - 1;
            $length = $end - $start + 1;

            $headers['Content-Range']  = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;

            return response()->stream(function () use ($path, $start, $length) {
                $fp = fopen($path, 'rb');
                fseek($fp, $start);
                $buffer = 1024 * 8;
                $remaining = $length;
                while (!feof($fp) && $remaining > 0) {
                    $read = min($buffer, $remaining);
                    echo fread($fp, $read);
                    $remaining -= $read;
                    flush();
                }
                fclose($fp);
            }, 206, $headers);
        }

        return response()->stream(function () use ($path) {
            readfile($path);
        }, 200, $headers);
    }

    public function delete(Lesson $lesson)
    {
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
            $lesson->update(['video_path' => null, 'video_type' => 'youtube']);
        }
        return back()->with('success', 'Video deleted!');
    }
}
