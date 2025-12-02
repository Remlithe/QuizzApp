<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class AdminQuizController extends Controller
{
    // 1. Zapisywanie nowego quizu
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Quiz::create($data);

        return redirect()->route('quizzes.index')->with('success', 'Utworzono nowy quiz!');
    }

    // 2. Usuwanie quizu
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz został usunięty.');
    }

    // 3. Formularz edycji
    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    // 4. Aktualizacja quizu
    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update($data);

        return redirect()->route('quizzes.index')->with('success', 'Quiz zaktualizowany!');
    }
}