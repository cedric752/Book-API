<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'authors' => 'required|array',
            'authors.*.id' => 'required|exists:authors,id|integer',
            'genres' => 'required|array',
            'genres.*.id' => 'required|exists:genres,id|integer',
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Name of the author',
                'example' => 'Dolfje Weerwolfje'
            ],
        ];
    }

}
