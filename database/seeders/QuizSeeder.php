<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    Quiz::create([
        'title' => 'Laravel Core',
        'description' => 'Pytania o routing, kontrolery i Eloquent.'
    ]);

    Quiz::create([
        'title' => 'HTML/CSS Basics',
        'description' => 'Podstawy struktury i stylizacji stron.'
    ]);
}
}
