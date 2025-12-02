<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    // 1. Wyświetl formularz
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }

    // 2. Zapisz pytanie do bazy
    public function store(Request $request, Quiz $quiz)
    {
        // Walidacja danych
        $data = $request->validate([
            'text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D', // Musi być jedną z liter
        ]);

        // Tworzenie pytania w bazie
        Question::create([
            'quiz_id' => $quiz->id,
            'text' => $data['text'],
            'options' => [ // Pakujemy odpowiedzi do tablicy (JSON)
                'A' => $data['option_a'],
                'B' => $data['option_b'],
                'C' => $data['option_c'],
                'D' => $data['option_d'],
            ],
            'correct_answer' => $data['correct_answer'] // Tu zapisujemy np. "C"
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Dodano nowe pytanie!');
    }
}
