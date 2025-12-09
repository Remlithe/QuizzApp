<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:quizzes,title',
            'description' => 'nullable|string|max:500',
        ];
    }
}
