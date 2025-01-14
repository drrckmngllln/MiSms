<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'section_code' => ['required', 'unique:sections,section_code,' . $this->id],
            'course_id' => ['required'],
            'year_level' => ['required'],
            'number_of_students' => ['nullable'],
            'max_number_of_students' => ['required'],
            'status' => ['required'],
            'department_id' => ['required'],
            'remarks' => ['required'],
        ];
    }
}
