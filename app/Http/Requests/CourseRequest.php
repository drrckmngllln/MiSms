<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'code' => ['required', 'unique:courses,code,' . $this->id],
            'description' => ['required'],
            'campus_id' => ['required'],
            'department_id' => ['required'],
            'max_units' => ['required'],
            'is_offered' => ['required'],
            'is_active' => ['required']
        ];
    }
}
