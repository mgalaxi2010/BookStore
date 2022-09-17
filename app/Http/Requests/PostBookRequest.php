<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'isbn'=>['required','bail','string','digits:13','unique:books'],
            'title'=>['required','string'],
            'description'=>['required','string'],
            'authors'=>['required','array'],
            'authors.*'=>['required','integer','exists:authors,id']
        ];
    }
}
