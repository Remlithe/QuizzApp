<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes.
     */
    public function index()
    {
        // Fetch all quizzes from the database, ordered by the newest first.
        $quizzes = Quiz::latest()->get();

        // Pass the quizzes to the view.
        return view('quizzes.index', ['quizzes' => $quizzes]);
    }

    public function showQuestion(Quiz $quiz, $questionNumber = 1)
    {
        // Eager load questions to avoid N+1 problem
        $quiz->load('questions');
        $questions = $quiz->questions;
        $totalQuestions = $questions->count();

        if ($questionNumber < 1 || $questionNumber > $totalQuestions) {
            abort(404, 'Nie ma pytania o takim numerze.');
        }

        // Get the current question based on the number
        $currentQuestion = $questions->get($questionNumber - 1);

        // Get user's progress from the session
        $progress = session()->get('quiz_progress.' . $quiz->id, []);

        // Get the answer for the current question, if it exists
        $userAnswer = $progress[$currentQuestion->id] ?? null;

        return view('quizzes.show', [
            'quiz' => $quiz,
            'questions' => $questions,
            'currentQuestion' => $currentQuestion,
            'questionNumber' => $questionNumber,
            'totalQuestions' => $totalQuestions,
            'progress' => $progress,
            'userAnswer' => $userAnswer,
        ]);
    }

    public function storeAnswer(Request $request, Quiz $quiz, $questionNumber)
    {
        $request->validate([
            'answer' => 'required',
            'question_id' => 'required|exists:questions,id',
        ]);

        $progress = session()->get('quiz_progress.' . $quiz->id, []);
        $progress[$request->question_id] = $request->answer;
        session()->put('quiz_progress.' . $quiz->id, $progress);

        $totalQuestions = $quiz->questions()->count();

        if ($questionNumber >= $totalQuestions) {
            // If it's the last question, go to results
            return redirect()->route('quizzes.results', $quiz->id);
        } else {
            // Go to the next question
            return redirect()->route('quizzes.question', ['quiz' => $quiz->id, 'questionNumber' => $questionNumber + 1]);
        }
    }

    public function showResults(Quiz $quiz)
    {
        $progress = session()->get('quiz_progress.' . $quiz->id, []);
        $questions = $quiz->questions->keyBy('id');
        
        $correctCount = 0;
        foreach ($progress as $questionId => $userAnswer) {
            if (isset($questions[$questionId]) && $questions[$questionId]->correct_answer === $userAnswer) {
                $correctCount++;
            }
        }

        // Clear progress after showing results
        session()->forget('quiz_progress.' . $quiz->id);

        return view('quizzes.results', [
            'quiz' => $quiz,
            'correctCount' => $correctCount,
            'totalAnswered' => count($progress),
            'totalQuestions' => $questions->count(),
        ]);
    }
}