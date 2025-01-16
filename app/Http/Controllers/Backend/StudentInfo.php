<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CreateAccount;
use App\Models\Department;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;

class StudentInfo extends Controller
{
    public function studentinfo()
    {
        $schoolyears = SchoolYear::all();
        $departments = Department::all();
        $campus = Campus::all();
        $courses = Course::all();
        return view('enrollStudent', compact('courses', 'schoolyears', 'campus', 'departments'));
    }
    public function student(Request $request)
    {

        // Validation rules
        $rules = [
            'id_number' => 'nullable',
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'gender' => 'required',
            'civil_status' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'nullable',
            'nationality' => 'nullable',
            'religion' => 'nullable',
            'control_number' => 'required',
            'email' => 'required',
            'home_address' => 'nullable',
            'elementary' => 'nullable',
            'year_graduated_elem' => 'nullable',
            'junior_high_school' => 'nullable',
            'year_graduated_elem_jhs' => 'nullable',
            'senior_high_school' => 'nullable',
            'year_graduated_elem_shs' => 'nullable',
            'mothers_fullname' => 'nullable',
            'occupation_mother' => 'nullable',
            'contact_number_mother' => 'nullable',
            'fathers_fullname' => 'nullable',
            'occupation_father' => 'nullable',
            'contact_number_father' => 'nullable',
            'type_of_students' => 'required',
            'course_id' => 'required',
            'campus_id' => 'required',
            'discount_id' => 'nullable',
            'admission_date' => 'required',
            'island' => 'nullable',
            'municipality' => 'nullable',
            'barangay' => 'nullable',
            'extention' => 'nullable',
            'municipality_code' => 'nullable',
            'barangay_code' => 'nullable',
            'streetname' => 'nullable',
            'houseno' => 'nullable',
            'regioncode' => 'nullable',
            'regionname' => 'nullable',
            'otherLives' => 'nullable',

        ];

        // Custom error messages (optional)
        $messages = [
            'id_number.required' => 'The ID number is required.',
            'email.unique' => 'This email is already in use.',
            'control_number.unique' => 'The control number must be unique.',
            'date_of_birth.before' => 'The date of birth must be before today.',
            // Add more messages as needed
        ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages);

        // Create the account
        $createaccount = new CreateAccount($validatedData);
        $createaccount->save();

        // Set success message and redirect
        $request->session()->flash('success', 'Thank you for enrolling MNCP-ISAP');
        return redirect()->back();
    }
}