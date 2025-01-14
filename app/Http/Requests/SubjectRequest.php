<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'code' => ['required','unique:subjects,code'],
            'descriptive_tittle' => ['required'],
            'total_units' => ['required','numeric'],
            'lecture_units' => ['required','numeric'],
            'lab_units' => ['required','numeric'],
            'pre_requisite' => ['required'],
            'total_hrs_per_week' => ['required'],
            'is_active' => ['required']
        ];
    }
}
