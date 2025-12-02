<?php

use App\Http\Controllers\QuizController;


Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');

Route::get('/quizzes/{quiz}', function (App\Models\Quiz $quiz) {
    return redirect()->route('quizzes.question', [
        'quiz' => $quiz->id,
        'questionNumber' => 1
    ]);
})->name('quizzes.start');

Route::get('/quizzes/{quiz}/question/{questionNumber?}', [QuizController::class, 'showQuestion'])
    ->name('quizzes.question');

// 2. Nowa trasa do obsługi przesłania odpowiedzi
Route::post('/quizzes/{quiz}/answer/{questionNumber}', [QuizController::class, 'storeAnswer'])
    ->name('quizzes.store_answer');

    Route::get('/quizzes/{quiz}/results', [QuizController::class, 'showResults'])
    ->name('quizzes.results');

    // Formularz dodawania pytania do konkretnego quizu
Route::get('/admin/quizzes/{quiz}/questions/create', [App\Http\Controllers\AdminQuestionController::class, 'create'])
    ->name('admin.questions.create');

// Zapis pytania w bazie
Route::post('/admin/quizzes/{quiz}/questions', [App\Http\Controllers\AdminQuestionController::class, 'store'])
    ->name('admin.questions.store');

    // --- ZARZĄDZANIE QUIZAMI (CRUD) ---

// Zapisz nowy quiz
Route::post('/admin/quizzes', [App\Http\Controllers\AdminQuizController::class, 'store'])->name('admin.quizzes.store');

// Usuń quiz
Route::delete('/admin/quizzes/{quiz}', [App\Http\Controllers\AdminQuizController::class, 'destroy'])->name('admin.quizzes.destroy');

// Edycja quizu (formularz i aktualizacja)
Route::get('/admin/quizzes/{quiz}/edit', [App\Http\Controllers\AdminQuizController::class, 'edit'])->name('admin.quizzes.edit');
Route::put('/admin/quizzes/{quiz}', [App\Http\Controllers\AdminQuizController::class, 'update'])->name('admin.quizzes.update');