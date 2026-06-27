<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class CourseViewerController extends Controller
{
    public function __construct(private EnrollmentService $enrollmentService) {}

    public function show(string $slug)
    {
        $course = Course::with(['sections.lessons'])->where('slug', $slug)->firstOrFail();
        $this->authorize('view', $course);

        $firstLesson = $course->lessons()->orderBy('order')->first();
        if ($firstLesson) {
            return redirect()->route('student.lesson', [$slug, $firstLesson->slug ?? $firstLesson->id]);
        }

        return view('student.course-viewer', compact('course'));
    }

    public function lesson(string $courseSlug, string $lessonSlug)
    {
        $course = Course::with(['sections.lessons'])->where('slug', $courseSlug)->firstOrFail();

        if (!auth()->user()->isEnrolledIn($course->id)) {
            return redirect()->route('course.show', $courseSlug)->with('error', 'Please enroll first.');
        }

        $lesson = Lesson::where('course_id', $course->id)
            ->where(function ($q) use ($lessonSlug) {
                $q->where('slug', $lessonSlug)->orWhere('id', $lessonSlug);
            })->firstOrFail();

        $progress = $this->enrollmentService->getCourseProgress(auth()->id(), $course->id);

        $completedIds = LessonProgress::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        $allLessons = $course->lessons()->orderBy('order')->get();
        $currentIndex = $allLessons->search(fn($l) => $l->id === $lesson->id);
        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        $isCompleted = in_array($lesson->id, $completedIds);

        return view('student.lesson', compact('course', 'lesson', 'progress', 'completedIds', 'prevLesson', 'nextLesson', 'isCompleted'));
    }

    public function markComplete(Request $request)
    {
        $request->validate(['lesson_id' => 'required|exists:lessons,id', 'course_id' => 'required|exists:courses,id']);

        LessonProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'lesson_id' => $request->lesson_id],
            ['course_id' => $request->course_id, 'is_completed' => true, 'completed_at' => now()]
        );

        $progress = $this->enrollmentService->getCourseProgress(auth()->id(), $request->course_id);
        return response()->json(['success' => true, 'progress' => $progress]);
    }

    public function updateProgress(Request $request)
    {
        $request->validate(['lesson_id' => 'required|exists:lessons,id', 'course_id' => 'required|exists:courses,id', 'watched_seconds' => 'required|integer|min:0']);

        LessonProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'lesson_id' => $request->lesson_id],
            ['course_id' => $request->course_id, 'watched_seconds' => $request->watched_seconds]
        );

        return response()->json(['success' => true]);
    }
}
