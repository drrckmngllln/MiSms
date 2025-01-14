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
        return view('frontend.admissionform', compact('courses', 'schoolyears', 'campus', 'departments'));
    }
    public function student(Request $request)
    {
        // dd($request->all());

        $request->validate(CreateAccount::$rules);
        $createaccount = new CreateAccount([
            ...$request->only([
                'id_number', 'sy_enrolled', 'school_year', 'school_year', 'last_name', 'first_name', 'last_name', 'middle_name', 'gender', 'civil_status', 'date_of_birth', 'place_of_birth', 'nationality', 'religion', 'control_number', 'email', 'home_address', 'elementary', 'year_graduated_elem', 'junior_high_school', 'year_graduated_elem_jhs', 'senior_high_school', 'year_graduated_elem_shs', 'mothers_fullname', 'occupation_mother', 'contact_number_mother', 'fathers_fullname', 'occupation_father', 'contact_number_father', 'type_of_students', 'year_level', 'course_id', 'campus_id'
            ])
        ]);
        $createaccount->save();
        $request->session()->flash('success', 'Thank you for enrolling MNCP-ISAP');
        return redirect()->back();
    }
}
