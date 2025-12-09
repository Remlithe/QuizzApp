<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class AdminQuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    public function store(StoreQuestionRequest $request, Quiz $quiz)
    {
        $quiz->questions()->create($request->validated());
        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało dodane.');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        return view('admin.questions.edit', compact('quiz', 'question'));
    }

    public function update(UpdateQuestionRequest $request, Quiz $quiz, Question $question)
    {
        $question->update($request->validated());
        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało zaktualizowane.');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();
        return redirect()->route('admin.quizzes.edit', $quiz)->with('success', 'Pytanie zostało usunięte.');
    }
}
