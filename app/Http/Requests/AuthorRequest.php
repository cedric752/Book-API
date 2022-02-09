<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:50',
            'age' => 'required|numeric|min:1|max:120',
            'email' => 'required|email|min:5|max:65',
            'books' => 'required|array',
            'books.*.id' => 'required|exists:books,id',
        ];
    }
}
