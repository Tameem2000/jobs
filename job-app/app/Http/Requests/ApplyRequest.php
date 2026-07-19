<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'resume_option' => ['required', 'string'],
            'resume_file' => ['required_if:resume_option,new_resume', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'resume_option' => 'Please select a resume option.',
            'resume_file.required_if' => 'Please upload your resume when selecting the "Upload a new resume" option.',
            'resume_file.file' => 'The resume must be a file.',
            'resume_file.mimes' => 'The resume must be a PDF file.',
            'resume_file.max' => 'The resume may not be greater than 5MB.',
        ];
    }
}
