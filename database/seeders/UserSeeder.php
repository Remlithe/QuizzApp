<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ta metoda stworzy użytkownika admin@example.com, jeśli nie istnieje,
        // lub zaktualizuje go, jeśli już jest w bazie.
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // Pamiętaj, aby zmienić to hasło w środowisku produkcyjnym!
                'email_verified_at' => now(), // Opcjonalnie: od razu oznacz email jako zweryfikowany
            ]
        );
    }
}
