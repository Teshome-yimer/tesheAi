<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount(['questions', 'attempts'])->orderByDesc('created_at')->paginate(20);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string|max:2000',
            'time_limit_minutes' => 'nullable|integer|min:1|max:600',
        ]);

        $quiz = Quiz::create($request->only('title', 'description', 'time_limit_minutes'));

        return redirect()->route('admin.quizzes.questions', $quiz)
            ->with('success', 'Quiz created! Now add your questions.');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string|max:2000',
            'time_limit_minutes' => 'nullable|integer|min:1|max:600',
        ]);

        $quiz->update($request->only('title', 'description', 'time_limit_minutes'));

        return back()->with('success', 'Quiz updated!');
    }

    public function togglePublish(Quiz $quiz)
    {
        if (!$quiz->is_published && $quiz->questions()->count() === 0) {
            return back()->withErrors(['quiz' => 'Add at least one question before publishing.']);
        }
        $quiz->update(['is_published' => !$quiz->is_published]);
        return back()->with('success', $quiz->is_published ? 'Quiz published!' : 'Quiz hidden!');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted!');
    }

    // ------ Questions management ------

    public function questions(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('admin.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'question'       => 'required|string|max:2000',
            'option_a'       => 'required|string|max:500',
            'option_b'       => 'required|string|max:500',
            'option_c'       => 'required|string|max:500',
            'option_d'       => 'required|string|max:500',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $data['order'] = $quiz->questions()->count() + 1;
        $quiz->questions()->create($data);

        return back()->with('success', 'Question added!');
    }

    public function updateQuestion(Request $request, QuizQuestion $question)
    {
        $data = $request->validate([
            'question'       => 'required|string|max:2000',
            'option_a'       => 'required|string|max:500',
            'option_b'       => 'required|string|max:500',
            'option_c'       => 'required|string|max:500',
            'option_d'       => 'required|string|max:500',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $question->update($data);

        return back()->with('success', 'Question updated!');
    }

    public function destroyQuestion(QuizQuestion $question)
    {
        $question->delete();
        return back()->with('success', 'Question deleted!');
    }
}
