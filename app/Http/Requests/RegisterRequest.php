<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                'name' => 'required|string|min:5|max:30',
                'email' => 'unique:users,email|email|required',
                'password' => 'required|string|confirmed',
                'role_id' => 'required|integer|exists:roles,id|between:1,2'
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Name of the author',
                'example' => 'Hans Kazam'
            ],
            'password' => [
                'description' => 'password of the user',
                'example' => 'Kazam2021!'
            ],
            
        ];
    }
}
