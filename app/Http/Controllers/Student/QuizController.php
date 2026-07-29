<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('is_published', true)
            ->withCount('questions')
            ->orderByDesc('created_at')
            ->paginate(12);

        $lastAttempts = QuizAttempt::where('user_id', auth()->id())
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->get()
            ->unique('quiz_id')
            ->keyBy('quiz_id');

        return view('quizzes.index', compact('quizzes', 'lastAttempts'));
    }

    public function take(Quiz $quiz)
    {
        abort_unless($quiz->is_published, 404);
        $quiz->load('questions');
        abort_if($quiz->questions->isEmpty(), 404);

        return view('quizzes.take', compact('quiz'));
    }

    public function check(Request $request, Quiz $quiz, QuizQuestion $question)
    {
        abort_unless($quiz->is_published, 404);
        abort_unless($question->quiz_id === $quiz->id, 404);

        $request->validate([
            'option' => 'required|in:a,b,c,d',
        ]);

        return response()->json([
            'correct' => $request->string('option')->toString() === $question->correct_option,
        ]);
    }

    public function submit(Request $request, Quiz $quiz)
    {
        abort_unless($quiz->is_published, 404);
        $quiz->load('questions');
        abort_if($quiz->questions->isEmpty(), 404);

        $request->validate([
            'answers'   => 'required|array',
            'answers.*' => 'in:a,b,c,d',
        ]);

        $answers = $request->input('answers', []);

        // Grade server-side — correct answers never leave the backend before submission
        $score = 0;
        $clean = [];
        foreach ($quiz->questions as $question) {
            $given = $answers[$question->id] ?? null;
            $clean[$question->id] = $given;
            if ($given !== null && $given === $question->correct_option) {
                $score++;
            }
        }

        $attempt = QuizAttempt::create([
            'quiz_id'      => $quiz->id,
            'user_id'      => auth()->id(),
            'score'        => $score,
            'total'        => $quiz->questions->count(),
            'answers'      => $clean,
            'completed_at' => now(),
        ]);

        return redirect()->route('quizzes.result', $attempt);
    }

    public function result(QuizAttempt $attempt)
    {
        abort_unless($attempt->user_id === auth()->id(), 403);
        $attempt->load('quiz.questions');

        return view('quizzes.result', compact('attempt'));
    }
}
