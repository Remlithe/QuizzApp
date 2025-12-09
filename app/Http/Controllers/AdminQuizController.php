<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;

class AdminQuizController extends Controller
{
    public function store(StoreQuizRequest $request)
    {
        Quiz::create($request->validated());
        return redirect()->route('quizzes.index')->with('success', 'Quiz został pomyślnie utworzony.');
    }

    public function edit(Quiz $quiz)
    {
        // Załaduj pytania, aby uniknąć problemu N+1
        $quiz->load('questions');
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());
        return redirect()->route('quizzes.index')->with('success', 'Quiz został pomyślnie zaktualizowany.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete(); // Dzięki onDelete('cascade') pytania usuną się automatycznie
        return redirect()->route('quizzes.index')->with('success', 'Quiz i wszystkie jego pytania zostały usunięte.');
    }
}
