<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Requests\QuizStoreRequest; // ⬅️ Dodany import
use App\Http\Requests\QuizUpdateRequest; // ⬅️ Dodany import

class AdminQuizController extends Controller
{
    // READ: Wyświetla listę wszystkich quizów w panelu admina
    public function index()
    {
        $quizzes = Quiz::with('questions')->latest()->paginate(10);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    // CREATE: Wyświetla formularz do tworzenia nowego quizu
    public function create()
    {
        return view('admin.quizzes.create');
    }

    // CREATE (STORE): Zapisuje nowy quiz w bazie danych
    public function store(QuizStoreRequest $request)
    {
        // Walidacja wykonana automatycznie przez QuizStoreRequest
        Quiz::create($request->validated());
        
        return redirect()->route('admin.quizzes.index')
                         ->with('success', 'Quiz został pomyślnie dodany!');
    }

    // EDIT: Wyświetla formularz edycji istniejącego quizu
    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    // UPDATE: Aktualizuje istniejący quiz w bazie danych
    public function update(QuizUpdateRequest $request, Quiz $quiz)
    {
        // Walidacja wykonana automatycznie przez QuizUpdateRequest
        $quiz->update($request->validated());
        
        return redirect()->route('admin.quizzes.index')
                         ->with('success', 'Quiz został pomyślnie zaktualizowany.');
    }

    // DELETE: Usuwa quiz z bazy danych
    public function destroy(Quiz $quiz)
    {
        // WAŻNE: Musisz zadbać o usunięcie powiązanych pytań (cascade delete w migracji)
        // Jeśli nie masz cascade delete, użyj: $quiz->questions()->delete();
        $quiz->delete();
        
        return redirect()->route('admin.quizzes.index')
                         ->with('success', 'Quiz został pomyślnie usunięty.');
    }
}