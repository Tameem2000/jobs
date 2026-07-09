<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required',
            'companyId' => 'required',
            'categoryId' => 'required',
            'description' => 'required|string',

        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than 255 characters.',
            'location.required' => 'The location field is required.',
            'salary.numeric' => 'The salary must be a number.',
            'salary.min' => 'The salary must be at least 0.',
            'salary.required' => 'The salary field is required.',
            'type.required' => 'The type field is required.',
            'companyId.required' => 'The company field is required.',
            'categoryId.required' => 'The category field is required.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
