<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFood extends FormRequest
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
            'carbohydrate' => 'required|numeric|max:255',
            'protain' => 'required|numeric|max:255',
            'fat' => 'required|numeric|max:255',
            'image' => 'image|nullable',
            'general_weight' => 'required|integer',
            'unit' => 'required|string|max:255',
            'category_id' => 'required|integer',
        ];
    }
}
