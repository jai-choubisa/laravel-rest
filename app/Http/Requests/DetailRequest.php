<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
            'sourceId' => 'required|string',
            'year' => 'int',
            'limit' => 'int',
            'comicId' => 'int'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sourceId.required' => 'Please provide sourceId',
            'year.int' => 'Please provide valid year',
            'limit.int' => 'Please provide valid limit',
            'comicId.int' => 'Please provide valid comic id'
        ];
    }
}
