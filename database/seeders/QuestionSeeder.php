<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Quiz;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $laravelQuiz = Quiz::where('title', 'Laravel Core')->first();

    if ($laravelQuiz) {
        // Pytanie 1
        Question::create([
            'quiz_id' => $laravelQuiz->id,
            'text' => 'Co to jest Blade?',
            'options' => [ // NOWA KOLUMNA Z OPCJAMI
                'A' => 'Biblioteka JS do budowy interfejsów',
                'B' => 'Silnik szablonów Laravel', // Prawidłowa
                'C' => 'Wbudowany system cache\'owania',
                'D' => 'Narzędzie do migracji bazy danych',
            ],
            'correct_answer' => 'B' // Aktualizujemy, aby pasowało do opcji
        ]);

        // Pytanie 2
        Question::create([
            'quiz_id' => $laravelQuiz->id,
            'text' => 'Która klasa odpowiada za ORM?',
            'options' => [
                'A' => 'Router',
                'B' => 'Controller',
                'C' => 'Eloquent', // Prawidłowa
                'D' => 'Guzzle',
            ],
            'correct_answer' => 'C'
        ]);
    }
}
}
