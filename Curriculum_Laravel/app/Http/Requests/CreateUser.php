<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
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
            'name' => 'required|string|max:255',
            'gender' => 'required|integer',
            'birthday' => 'required|date',
            'height' => 'required|numeric',
            'target_weight' => 'required|numeric',
            'exercise_level' => 'required|integer',
        ];
    }
}
