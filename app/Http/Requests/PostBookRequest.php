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
            'isbn'=>['bail','string','digits:13','unique:books'],
            'title'=>'string',
            'description'=>'string',
            'authors'=>['array','exists:authors,id'],
            'authors.*'=>'integer'
        ];
    }
}
