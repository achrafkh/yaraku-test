<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $input = $this->all();
        return [
            'title' => [
                'required', 'min:3',
                Rule::unique('books')->where(function ($query) use ($input) {
                    return $query->where('title', $input['title'])
                        ->where('author', $input['author']);
                }),

            ],
            'author' => ['required', 'min:2'],

        ];
    }

    public function messages()
    {
        return [
            'title.unique' => 'This combination of title and author Already exists!',
        ];
    }
}
