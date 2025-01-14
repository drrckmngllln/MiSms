<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\StudentsAdmittedDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentEditRequest;
use App\Models\Course;
use App\Models\Section;
use App\Models\StudentApplicant;
use App\Models\StudentsAdmitted;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use App\Traits\ImageUploadTrait as ImageUploadTraitAlias;
use File;

class AdmittedStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageUploadTraitAlias;
    public function index(StudentsAdmittedDataTable $dataTable)
    {

        $courses = Course::all();
        return $dataTable->render('Roles.Super_Administrator.admitstudents.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());

        $request->validate(StudentsAdmitted::$rules);
        //dito is isasave natin yung name into fullname
        $fullname = $request->input('last_name') . ' ' . $request->input('middle_name') . ' ' . $request->input('first_name') . ' ' . $request->input('prefix');
        $found = StudentApplicant::where('fullname', '=', $fullname)->get();

        // // dd($found);
        //eto naman yung message bag natin sa error
        if ($found->isNotEmpty()) {

            $customErrorMessages = new MessageBag([
                'fullname' => 'Full name is already taken.',
            ]);

            throw ValidationException::withMessages($customErrorMessages->toArray());
        }

        $section = Section::whereRaw('COALESCE(number_of_students, 0) < max_number_of_students')
            ->where('course_id', $request->course_id)
            ->first();

        if (!$section) {
            throw ValidationException::withMessages(['course_id' => 'No available slot for this course']);
        }

        $admittedstudents = new StudentsAdmitted([
            ...$request->only([
                'curriculum_id', 'image', 'last_name', 'middle_name', 'first_name', 'prefix', 'email', 'date_of_birth', 'place_of_birth', 'religion', 'nationality', 'gender', 'civil_status', 'dialect',
                'contact_number', 'complete_address', 'fathers_fullname', 'fathers_occupation', 'mothers_fullname', 'mothers_occupation', 'parents_address', 'parents_contact_number', 'guardian_fullname', 'guardian_address', 'employer_details',
                'primary_school', 'secondary_school', 'junior_highschool', 'senior_highschool', 'last_school_attended', 'lastschool_name', 'lastschool_address', 'course_id', 'currirulum_id', 'student_type', 'year_level', 'form_138', 'transcript_of_record',
                'honorable_dismissal', 'birth_certificate', 'ncae_copt', 'good_moral', 'true_copy_of_grades', 'police_clearance',
            ]),
        ]);

        $schoolYear = '2023-2024';
        $semester = '';
        // Find the last enrolled student and increment the ID
        $lastEnrolledStudent = StudentsAdmitted::where('status', 1)
            ->orderBy('student_id', 'desc')
            ->first();

        if ($lastEnrolledStudent) {
            $lastStudentID = $lastEnrolledStudent->student_id;
            $lastStudentIDParts = explode('-', $lastStudentID);
            $studentNumber = (int) $lastStudentIDParts[2] + 1;
        } else {
            $studentNumber = 1; // Start from 1
        }

        // Format the ID with leading zeros
        $studentID = $schoolYear . '-' . $semester . '' . str_pad($studentNumber, 4, '0', STR_PAD_LEFT);

        // Save the ID in the database
        $admittedstudents->student_id = $studentID;
        $admittedstudents->image = $this->uploadImage($request, 'image', 'studentimage');

        $admittedstudents->fullname = $fullname;

        $admittedstudents->section_id = $section->id;
        $admittedstudents->enrollmentStatus = 'Pre Enrolled';

        $section->increment('number_of_students', 1);

        $admittedstudents->save();
        $request->session()->flash('success', 'User data successfully saved!');


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentEditRequest $request, String $id)
    {
        //
        $admittedstudents = StudentsAdmitted::findOrFail($id);
        $fullname = $request->input('last_name') . ' ' . $request->input('middle_name') . ' ' . $request->input('first_name') . ' ' . $request->input('prefix');
        $admittedstudents->update($request->only(
            'first_name',
            'middle_name',
            'last_name',
            'prefix',
            'email',
            'date_of_birth',
            'place_of_birth',
            'religion',
            'nationality',
            'gender',
            'civil_status',
            'dialect',
            'contact_number',
            'complete_address',
            'fathers_fullname',
            'fathers_occupation',
            'mothers_fullname',
            'mothers_occupation',
            'parents_address',
            'parents_contact_number',
            'guardian_fullname',
            'guardian_address',
            'employer_details',
            'primary_school',
            'secondary_school',
            'junior_highschool',
            'senior_highschool',
            'last_school_attended',
            'lastschool_name',
            'lastschool_address',
            'course',
            'currirulum_id',
            'student_type',
            'year_level',




        ));

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request, 'image', 'studentimage');

            // Delete the old image if it exists
            if (File::exists($admittedstudents->image)) {
                File::delete($admittedstudents->image);
            }

            $admittedstudents->image = $imagePath;
        }
        // dd($request->all());
        $admittedstudents->fullname = $fullname;
        $admittedstudents->form_138 = $request->form_138 ? 1 : 0;
        $admittedstudents->transcript_of_record = $request->transcript_of_record ? 1 : 0;
        $admittedstudents->honorable_dismissal = $request->honorable_dismissal ? 1 : 0;
        $admittedstudents->birth_certificate = $request->birth_certificate ? 1 : 0;
        $admittedstudents->ncae_copt = $request->ncae_copt ? 1 : 0;
        $admittedstudents->good_moral = $request->good_moral ? 1 : 0;
        $admittedstudents->true_copy_of_grades = $request->true_copy_of_grades ? 1 : 0;
        $admittedstudents->police_clearance = $request->police_clearance ? 1 : 0;
        $admittedstudents->save();


        $request->session()->flash('success', 'User updated successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $admittedstudents = StudentsAdmitted::findOrFail($id);
        //check natin using die dump function
        //dd($slider);

        //delete first yung image sa may storage
        if ($admittedstudents->image)
            $this->deleteImage($admittedstudents->image);
        //next delete our data from database
        $admittedstudents->delete();
        //next delete our data from database


        $section = Section::where('course_id', $admittedstudents->course_id)->first();
        if ($section) {
            $section->decrement('number_of_students', 0);
        }

        //gawa tayu ng response

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
    public function changeStatus(Request $request)
    {
    }
}
