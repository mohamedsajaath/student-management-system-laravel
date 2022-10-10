<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $index = $this->route('index');

        return [
            'index' => [
                'required', 'max:10',
            ],
            'first' => ['required', 'max:15'],
            'last' => ['required', 'max:15'],
            'age' => ['required'],
            'description' => ['required']
        ];
    }
}
