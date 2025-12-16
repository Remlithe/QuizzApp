<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all(); // Lub Quiz::withCount('questions')->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }
    // Formularz tworzenia
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    // Zapisywanie nowego pytania
    public function store(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'text' => 'required|string',
            'options' => 'required|array|min:2', // Wymagamy tablicy opcji
            'options.A' => 'required|string',
            'options.B' => 'required|string',
            'options.C' => 'string',
            'options.D' => 'string',
            'correct_answer' => 'required|string|in:A,B,C,D',
        ]);

        $quiz->questions()->create([
            'text' => $data['text'],
            'options' => $data['options'], // Laravel automatycznie zmieni to na JSON dzięki $casts w modelu
            'correct_answer' => $data['correct_answer'],
        ]);

        return redirect()->route('admin.quizzes.edit', $quiz->id)->with('success', 'Pytanie dodane!');
    }

    // Formularz edycji
    public function edit(Quiz $quiz, Question $question)
    {
        $quiz = $question->quiz; 
        return view('admin.questions.edit', compact('question', 'quiz'));
    }

    // Aktualizacja pytania
    public function update(Request $request,Quiz $quiz, Question $question)
    {
        $data = $request->validate([
            'text' => 'required|string',
            'options' => 'required|array',
            'options.A' => 'required|string',
            'options.B' => 'required|string',
            'options.C' => 'string',
            'options.D' => 'string',
            'correct_answer' => 'required|string|in:A,B,C,D',
        ]);

        $question->update($data);

        return redirect()->route('admin.quizzes.edit', $question->quiz_id)->with('success', 'Pytanie zaktualizowane!');
    }

    // Usuwanie pytania
    public function destroy(Quiz $quiz,Question $question)
    {
        $quizId = $question->quiz_id; // Zapamiętujemy ID quizu przed usunięciem
        $question->delete();
        
        return redirect()->route('admin.quizzes.edit', $quizId)->with('success', 'Pytanie usunięte.');
    }
}