<?php

use App\Http\Controllers\QuizController;
// routes/web.php
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\AdminQuestionController;
// ... inne use

// Trasy publiczne (zakładam, że już istnieją)
Route::get('/quizzes', [App\Http\Controllers\QuizController::class, 'index'])->name('quizzes.index');
Route::get('/quizzes/{quiz}/start', [App\Http\Controllers\QuizController::class, 'start'])->name('quizzes.start');
Route::get('/quizzes/{quiz}/question/{questionNumber}', [App\Http\Controllers\QuizController::class, 'show'])->name('quizzes.question');
Route::post('/quizzes/{quiz}/store_answer/{questionNumber}', [App\Http\Controllers\QuizController::class, 'storeAnswer'])->name('quizzes.store_answer');
Route::get('/quizzes/{quiz}/results', [App\Http\Controllers\QuizController::class, 'results'])->name('quizzes.results');


// --- Panel Administratora ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // CRUD dla Quizów
    Route::post('quizzes', [AdminQuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/{quiz}/edit', [AdminQuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('quizzes/{quiz}', [AdminQuizController::class, 'update'])->name('quizzes.update');
    Route::delete('quizzes/{quiz}', [AdminQuizController::class, 'destroy'])->name('quizzes.destroy');

    // CRUD dla Pytań (zagnieżdżony w quizach)
    Route::prefix('quizzes/{quiz}/questions')->name('questions.')->group(function () {
        Route::get('/create', [AdminQuestionController::class, 'create'])->name('create');
        Route::post('/', [AdminQuestionController::class, 'store'])->name('store');
        Route::get('/{question}/edit', [AdminQuestionController::class, 'edit'])->name('edit');
        Route::put('/{question}', [AdminQuestionController::class, 'update'])->name('update');
        Route::delete('/{question}', [AdminQuestionController::class, 'destroy'])->name('destroy');
    });

});
