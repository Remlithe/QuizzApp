<?php

use App\Http\Controllers\AdminQuestionController;
use App\Http\Controllers\AdminQuizController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('quizzes.index');
});

// A dashboard route is created by Breeze. It's a good landing page for logged-in users.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Public quiz routes
Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');

Route::get('/quizzes/{quiz}', function (App\Models\Quiz $quiz) {
    return redirect()->route('quizzes.question', [
        'quiz' => $quiz->id,
        'questionNumber' => 1
    ]);
})->name('quizzes.start');

Route::get('/quizzes/{quiz}/question/{questionNumber?}', [QuizController::class, 'showQuestion'])
    ->name('quizzes.question');

Route::post('/quizzes/{quiz}/answer/{questionNumber}', [QuizController::class, 'storeAnswer'])
    ->name('quizzes.store_answer');

Route::get('/quizzes/{quiz}/results', [QuizController::class, 'showResults'])
    ->name('quizzes.results');


// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Quiz Management (CRUD)
    Route::get('quizzes', [AdminQuizController::class, 'index'])->name('quizzes.index'); 
    Route::post('quizzes', [AdminQuizController::class, 'store'])->name('quizzes.store');
    Route::get('quizzes/create', [AdminQuizController::class, 'create'])->name('quizzes.create');
    Route::get('quizzes/{quiz}/edit', [AdminQuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('quizzes/{quiz}', [AdminQuizController::class, 'update'])->name('quizzes.update');
    Route::delete('quizzes/{quiz}', [AdminQuizController::class, 'destroy'])->name('quizzes.destroy');

    // Nested Question Management (CRUD)
    Route::prefix('quizzes/{quiz}/questions')->name('questions.')->group(function () {
        Route::get('/create', [AdminQuestionController::class, 'create'])->name('create');
        Route::post('/', [AdminQuestionController::class, 'store'])->name('store');
        Route::get('/{question}/edit', [AdminQuestionController::class, 'edit'])->name('edit');
        Route::put('/{question}', [AdminQuestionController::class, 'update'])->name('update');
        Route::delete('/{question}', [AdminQuestionController::class, 'destroy'])->name('destroy');
    });
});

// Profile routes (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes (from Breeze)
require __DIR__.'/auth.php';