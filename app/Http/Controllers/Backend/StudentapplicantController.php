<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\StudentApplicantDataTable;
use App\DataTables\StudentsAdmittedDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAppEditRequest;

use App\Http\Requests\StudentEditRequest;
use App\Mail\StudentApproved;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\EnrolledStudent;
use App\Models\Section;
use App\Models\StudentApplicant;
use App\Models\StudentApplicantEdit;
use App\Models\StudentsAdmitted;
use App\Models\TuitionFee;
use App\Traits\ImageUploadTrait as ImageUploadTraitAlias;
use App\Traits\Form138Trait as Form138TraitAlias;
use App\Traits\GoodmoralTrait as GoodmoralAlias;
use App\Traits\BirthCertificateTrait as BirthCertificateAlias;
use App\Traits\HonorableDismissal as HonorableDismissalAlias;
use App\Traits\NcaeResult as NcaeResultAlias;
use App\Traits\PoliceClearance as PoliceClearanceAlias;
use App\Traits\ReportcardTrait as ReportcardTraitAlias;
use App\Traits\StudentTruecopyofGradeTrait as StudentTruecopyofGradeTraitAlias;;

use App\Traits\TranscriptofRecord as TranscriptofRecordAlias;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

use File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;

class StudentapplicantController extends Controller
{

    use ImageUploadTraitAlias, Form138TraitAlias, TranscriptofRecordAlias, HonorableDismissalAlias, NcaeResultAlias, GoodmoralAlias, BirthCertificateAlias, StudentTruecopyofGradeTraitAlias, PoliceClearanceAlias;
    /**
     * Display a listing of the resource.
     */
    public function index(StudentApplicantDataTable $dataTable)
    {
        //

        $courses = Course::all();
        $sections = Section::all();
        $curricullums = Curriculum::all();
        return $dataTable->render('Roles.Super_Administrator.studentapplicant.index', compact('courses', 'sections', 'curricullums'));
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
        //dd($request->all());
        $request->validate(StudentApplicant::$rules);
        $studentInformation = new StudentApplicant([
            ...$request->only([
                'semester', 'id_number', 'last_name', 'first_name', 'middle_name', 'suffix', 'gender', 'date_of_birth', 'place_of_birth', 'nationality',
                'religion', 'status'
            ])
        ]);
        $studentInformation->save();
        $request->session()->flash('success', 'Student Information Added Successfully');
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

        // dd($request->all());


        $userInformation = TuitionFee::findOrfail($id);
        $userInformation->update(
            $request->only('semester', 'id_number', 'last_name', 'first_name', 'middle_name', 'suffix', ' gender', 'date_of_birth', 'place_of_birth', 'nationality', 'religion', 'status')
        );
        $userInformation->save();

        return redirect()->back()->with('success', ' Updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $userInformation = StudentApplicant::findOrFail($id);
        //check natin using die dump function
        //dd($slider);

        //delete first yung image sa may storage
        if ($userInformation->image)
            $this->deleteImage($userInformation->image);
        //next delete our data from database
        $userInformation->delete();
        //next delete our data from database

        $section = Section::where('course_id', $userInformation->course_id)->first();
        if ($section) {
            $section->decrement('number_of_students', 1);
        }
        //gawa tayu ng response
        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
    public function changeStatus(Request $request)
    {

        $userInformation = StudentApplicant::findOrFail($request->id);
        $newStatus = $request->status == 'true' ? 1 : 0;

        $userInformation->status = $newStatus;

        if ($userInformation->save()) {
            $message = $newStatus === 1 ? 'Student Approved Successfully' : 'Student Disapproved Successfully';

            // Kapag nag disapprove, idelete ito sa database
            if ($newStatus === 0) {
                $userInformation->enrolled_student->delete();
            }
            return response(['status' => 'success', 'message' => $message]);
        } else {
            return response(['status' => 'error', 'message' => 'Failed to update status']);
        }


        // if ($userInformation->status == 1) {

        //     $userInformation->enrollmentStatus = 'Pre Enrolled';

        //     // When the student is approved, generate an ID
        //     $schoolYear = '2023-2024';
        //     $semester = '';
        //     // Find the last enrolled student and increment the ID
        //     $lastEnrolledStudent = StudentApplicant::where('status', 1)
        //         ->orderBy('student_id', 'desc')
        //         ->first();

        //     if ($lastEnrolledStudent) {
        //         $lastStudentID = $lastEnrolledStudent->student_id;
        //         $lastStudentIDParts = explode('-', $lastStudentID);
        //         $studentNumber = (int) $lastStudentIDParts[2] + 1;
        //     } else {
        //         $studentNumber = 1; // Start from 1
        //     }

        //     // Format the ID with leading zeros
        //     $studentID = $schoolYear . '-' . $semester . '' . str_pad($studentNumber, 4, '0', STR_PAD_LEFT);

        //     // Save the ID in the database
        //     $userInformation->student_id = $studentID;
        // }

        // $userInformation->save();

        // if ($userInformation->status == 1) {
        //     // Send an email to the user
        //     try {
        //         // You can also delete the record from the studentapplicant table if needed
        //         $admitted = new StudentsAdmitted([
        //             ...$userInformation->only([
        //                 'curriculum_id', 'image', 'last_name', 'middle_name', 'first_name', 'prefix', 'email', 'date_of_birth', 'place_of_birth', 'religion', 'nationality', 'gender', 'civil_status', 'dialect',
        //                 'contact_number', 'complete_address', 'fathers_fullname', 'fathers_occupation', 'mothers_fullname', 'mothers_occupation', 'parents_address', 'parents_contact_number', 'guardian_fullname', 'guardian_address', 'employer_details',
        //                 'primary_school', 'secondary_school', 'junior_highschool', 'senior_highschool', 'last_school_attended', 'lastschool_name', 'lastschool_address', 'course_id', 'currirulum_id', 'student_type', 'year_level',
        //             ]),
        //         ]);
        //         $admitted->status = 1;
        //         $fullname = $userInformation->last_name . ' ' . $request->middle_name . ' ' . $request->first_name . ' ' . $request->prefix;
        //         $admitted->student_id = $userInformation->student_id;
        //         $admitted->section_id = $userInformation->section_id;
        //         $admitted->enrollmentStatus = $userInformation->enrollmentStatus;
        //         $admitted->fullname = $fullname;
        //         $admitted->form_138 = $userInformation->form_138 ? 1 : 0;
        //         $admitted->transcript_of_record = $userInformation->transcript_of_record ? 1 : 0;
        //         $admitted->honorable_dismissal = $userInformation->honorable_dismissal ? 1 : 0;
        //         $admitted->birth_certificate = $userInformation->birth_certificate ? 1 : 0;
        //         $admitted->ncae_copt = $userInformation->ncae_copt ? 1 : 0;
        //         $admitted->good_moral = $userInformation->good_moral ? 1 : 0;
        //         $admitted->true_copy_of_grades = $userInformation->true_copy_of_grades ? 1 : 0;
        //         $admitted->police_clearance = $userInformation->police_clearance ? 1 : 0;
        //         $admitted->save();
        //         return response(['message' => 'Student Approved', 'admittedStudents'  => '']);
        //         // $userInformation->delete();
        //     } catch (\Exception $ex) {
        //         dd($ex);
        //     }

        //     //insert to admitted table delete to student applicant 

        // } else {
        //     return response(['message' => 'Student Disapproved']);
        // }
    }
    public function getLastId()
    {

        $lastID = StudentApplicant::latest()->first();

        if ($lastID) {
            return response(['lastID' => $lastID->id_number]);
        } else {
            return response(['lastID' => '2023-1-0000']);
        }
    }
    public function total_units(string $curriculum_id)
    {

        // Assuming Curriculum model has a subjects relationship
        $curriculum = Curriculum::findOrFail($curriculum_id);

        $totalUnits = $curriculum->subjects()->sum('total_units');

        // Return the result as a JSON response
        return response(['status' => 'success', 'message' => 'Summary details fetched successfully!', 'data' => $totalUnits]);
    }
}
