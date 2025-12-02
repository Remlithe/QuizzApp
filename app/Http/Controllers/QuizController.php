<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();

        return view('quizzes.index', compact('quizzes'));
    }

    public function showQuestion(Quiz $quiz, $questionNumber = 1)
    {
        // 1. Pobierz wszystkie pytania
        $questions = $quiz->questions()->get();

        if ($questions->isEmpty()) {
        return redirect()->route('quizzes.index')
            ->with('error', 'Ten quiz nie ma jeszcze dodanych pytań.');
    }
        // Sprawdzenie, czy numer pytania jest prawidłowy
        if ($questionNumber < 1 || $questionNumber > $questions->count()) {
        return redirect()->route('quizzes.question', ['quiz' => $quiz->id, 'questionNumber' => 1]);
    }

        // 2. Pobierz aktualne pytanie (kolekcja jest 0-indeksowana, stąd -1)
        $currentQuestion = $questions->get($questionNumber - 1);

        // 3. Pobierz postęp z sesji (odpowiedzi użytkownika)
        $progress = Session::get('quiz_progress_' . $quiz->id, []);
        $userAnswer = $progress[$currentQuestion->id] ?? null;

        return view('quizzes.show', [
            'quiz' => $quiz,
            'questions' => $questions,       // Lista pytań do panelu bocznego
            'currentQuestion' => $currentQuestion, // Bieżące pytanie
            'questionNumber' => (int)$questionNumber, // Numer pytania (1, 2, 3...)
            'totalQuestions' => $questions->count(),
            'userAnswer' => $userAnswer,     // Ostatnia odpowiedź użytkownika
            'progress' => $progress          // Wszystkie odpowiedzi
        ]);
    }
    public function storeAnswer(Request $request, Quiz $quiz, $questionNumber)
    {
        // ... (Kroki 1-5, zapisywanie odpowiedzi w sesji, pozostają bez zmian)
        $request->validate(['answer' => 'required']);

    // 🛑 ZMIANA: Rzutowanie na (int)
    $questionId = (int) $request->input('question_id'); 
    $answer = $request->input('answer');

    $sessionKey = 'quiz_progress_' . $quiz->id;
    $progress = Session::get($sessionKey, []);

    // Zapisujemy pod kluczem będącym liczbą
    $progress[$questionId] = $answer; 

    Session::put($sessionKey, $progress);

    // ... reszta kodu (przekierowania) bez zmian ...
    
    // Skopiuj resztę logiki przekierowania z poprzednich kroków
    $nextQuestionNumber = (int)$questionNumber + 1;
    if ($nextQuestionNumber <= $quiz->questions()->count()) {
        return redirect()->route('quizzes.question', ['quiz' => $quiz->id, 'questionNumber' => $nextQuestionNumber]);
    }
    return redirect()->route('quizzes.results', ['quiz' => $quiz->id]);
    }
    public function showResults(Quiz $quiz)
    {

        // 1. Pobierz wszystkie poprawne odpowiedzi z bazy (tylko kolumny 'id' i 'correct_answer')
        $questions = $quiz->questions()->pluck('correct_answer', 'id');
        
        // 2. Pobierz odpowiedzi użytkownika z sesji
        $sessionKey = 'quiz_progress_' . $quiz->id;
        $userAnswers = Session::get($sessionKey, []);

        $correctCount = 0;
        $totalAnswered = count($userAnswers);

        // 3. Logika oceniania
        foreach ($userAnswers as $questionId => $userAnswer) {
        // Rzutowanie na int dla pewności
        $correctAnswer = $questions->get((int)$questionId); 
        
        if ($correctAnswer && $userAnswer === $correctAnswer) {
            $correctCount++;
        }
        }
        // 4. Usuń postęp z sesji po zakończeniu quizu (opcjonalnie, ale zalecane)
        Session::forget($sessionKey);

        // 5. Wyświetl widok wyników
        return view('quizzes.results', [
            'quiz' => $quiz,
            'correctCount' => $correctCount,
            'totalAnswered' => $totalAnswered,
            'totalQuestions' => $quiz->questions()->count() // Wszystkie pytania
        ]);
        
    }
}