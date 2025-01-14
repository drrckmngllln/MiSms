<?php

namespace App\Http\Requests;

use App\Http\Controllers\Backend\Functionality\Offerings\CurriculumController;
use App\Models\Curriculum;
use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
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
            // 'code' => ['required', 'unique:curricula,code,' . $this->id],
            'code' => [],
            'description' => [],
            'campus_id' => [],
            'effective' => [],
            'expires' => [],
            'status' => [],
        ];
    }
}
