<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'text' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string|max:255',
            'correct_answer' => 'required|string|in:A,B,C,D',
        ];
    }
}
