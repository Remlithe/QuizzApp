<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sprawdź, czy użytkownik jest administratorem (jeśli nie obsługuje tego middleware)
        return true; 
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:quizzes,title',
            'description' => 'nullable|string',
            'is_active' => 'boolean', // Domyślnie 0, ale może przyjść 1 z formularza
        ];
    }
    
    public function messages(): array
    {
        return [
            'title.required' => 'Tytuł quizu jest wymagany.',
            'title.unique' => 'Quiz o takim tytule już istnieje.',
        ];
    }
}