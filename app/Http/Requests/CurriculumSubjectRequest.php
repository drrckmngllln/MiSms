<?php

namespace App\Http\Requests;

use App\Models\CurriculumSubject;
use Illuminate\Foundation\Http\FormRequest;

class CurriculumSubjectRequest extends FormRequest
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
            // 'curriculumID_code' => ['required', 'unique:curriculum_subjects,curriculumID_code'],
            // 'curriculum_id' => ['required'],
            'semester_id' => ['required'],
            'code' => ['required'],
            'descriptive_tittle' => ['required'],
            'total_units' => ['required'],
            'lecture_units' => ['required'],
            'lab_units' => ['required'],
            'pre_requisite' => ['required'],
            'total_hrs_per_week' => ['required'],
            // 'is_active' => ['required']
        ];
    }
}
