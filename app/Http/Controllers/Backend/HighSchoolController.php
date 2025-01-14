<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CreateAccount;
use App\Models\CreateAccountHighSchool;
use App\Models\Curriculum;
use App\Models\Department;
use App\Models\laboratoryModel;
use App\Models\MiscFee;
use App\Models\OtherFee;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\student_Subject_highSchool;
use App\Models\studentAssesment;
use App\Models\StudentsSection;
use App\Models\StudentSubject;
use App\Models\TuitionFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class HighSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $department = Department::all();
        $course = Course::all();
        $campus = Campus::all();
        $curriculum = Curriculum::all();
        $sch_years = SchoolYear::all();

        return view('Roles.Super_Administrator.highschool.index',  compact('course', 'campus', 'curriculum', 'sch_years', 'department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = CreateAccountHighSchool::all();

            // dd($data);
            $datatables = datatables()->of($data)
                // ->addIndexColumn()

                ->addColumn('action', function ($query) {
                    $btncontainer = '<div class="d-flex justify-content-center">';

                    $deleteBtn = '<form action="' . route('superadmin.highSchool.destroy', $query->id) . '" method="POST">';
                    $deleteBtn .= csrf_field();
                    $deleteBtn .= method_field('DELETE');
                    $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                    $deleteBtn .= '</form>';

                    $editbtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editHighSchool" onclick="highSchool
                    (' . $query->id . ', \'' . $query->id_number . '\',\'' . $query->sy_enrolled . '\', \'' . $query->school_year . '\', \'' . $query->last_name . '\', \'' . $query->first_name . '\', \'' . $query->middle_name . '\', \'' . $query->gender . '\',\'' . $query->civil_status . '\', \'' . $query->date_of_birth . '\', \'' . $query->place_of_birth . '\', \'' . $query->nationality . '\', \'' . $query->religion . '\',\'' . $query->course_id . '\',\'' . $query->admission_date . '\',\'' . $query->campus_id . '\',\'' . $query->discount_id . '\',\'' . $query->control_number . '\',\'' . $query->email . '\',\'' . $query->home_address . '\',\'' . $query->type_of_students . '\', \'' . $query->year_level . '\', \'' . $query->elementary . '\',\'' . $query->year_graduated_elem . '\',\'' . $query->junior_high_school . '\',\'' . $query->year_graduated_elem_jhs . '\',\'' . $query->senior_high_school . '\',\'' . $query->year_graduated_elem_shs . '\',\'' . $query->mothers_fullname . '\',\'' . $query->occupation_mother . '\',\'' . $query->contact_number_mother . '\',\'' . $query->fathers_fullname . '\',\'' . $query->occupation_father . '\',\'' . $query->contact_number_father . '\' )">';
                    $editbtn .= '<button type="button" class="btn btn-primary waves-effect waves-light mx-1"><i class="ri-edit-2-fill"></i></button></a>';

                    $approveStudent = '<a href="#" data-bs-toggle="modal" data-bs-target="#selectCurriculum" onclick="approveStudent(' . $query->id . ', \'' . $query->first_name . '\', \'' . $query->middle_name . '\', \'' . $query->last_name . '\', \'' . $query?->course?->code . '\', \'' . $query?->course?->id . '\' )">';
                    $approveStudent .= '<button type="button" class="btn btn-primary waves-effect waves-light">Approve</button></a>';

                    $enrllBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#enrollStudent" ' .
                        'onclick="enrollStudents(' . $query->id  . ', \'' . $query->id_number . '\',\'' . $query?->curriculum?->id . '\',
                        \'' . $query?->course?->id . '\',\'' . $query?->curriculum?->campus_id . '\',\'' . $query->first_name . '\',
                        \'' . $query->middle_name . '\',\'' . $query->last_name . '\')">';
                    $enrllBtn .= '<button type="button" class="btn btn-success waves-effect waves-light">Enroll Student</button></a>';


                    $accBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#accountingModal" ' .
                        'onclick="studentAss(' . $query->id . ', \'' . $query->id_number . '\',\'' . $query->first_name . '\', \'' . $query->middle_name . '\',  \'' . $query->last_name . '\',\'' . $query->course_id . '\',\'' . $query->campus_id . '\', \'' . $query?->studentSubjectss?->year_level . '\',\'' . $query?->studentSubjectss?->semester . '\',\'' . $query->school_year . '\')">';
                    $accBtn .= '<button type="button" class="btn btn-success waves-effect waves-light mx-1">  Accounting</button></a>';

                    $viewSubBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#viewSubModal" ' .
                        'onclick="studentSub(' . $query->id . ', \'' . $query->id_number . '\', \'' . $query->first_name . '\',\'' . $query->middle_name . '\', \'' . $query->last_name . '\', \'' . $query->school_year . '\', \'' . $query->course_id . '\',\'' . $query->campus_id . '\',\'' . $query?->studentSubjectss?->year_level . '\',\'' . $query->curriculum_id . '\',\'' . $query?->studentSubjectss?->semester . '\',\'' . $query?->studentSubjectss?->school_year . '\',\'' . $query?->studentSubjectss?->department_id . '\')">';
                    $viewSubBtn .= '<button type="button" class="btn btn-secondary waves-effect waves-light mx--10"><i class="ri-eye-fill"></i></button></a>';

                    $printBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="" ' .
                        'onclick="printStudentAssessment(' . $query->id . ', \'' . $query->id_number . '\', \'' . $query->first_name . '\',\'' . $query->middle_name . '\', \'' . $query->last_name . '\', \'' . $query->school_year . '\', \'' . $query->course?->code . '\')">';
                    $printBtn .= '<button type="button" class="btn btn-secondary waves-effect waves-light mx-1"><i class="ri-printer-line"></i></button></a>';


                    if (Auth::check()) {
                        $user = Auth::user();
                        if ($query->status === 'PENDING') {
                            $btncontainer .= $approveStudent;
                            $btncontainer .= $editbtn;
                            $btncontainer  .= $deleteBtn;
                        } else if ($query->status === 'FOR ENROLLMENT') {
                            $btncontainer .= $enrllBtn;
                            $btncontainer .= $editbtn; // default

                            if ($user->hasRole('Registrar')) {
                                $btncontainer .= $deleteBtn;
                            }
                        } else if ($query->status === 'ACCOUNTING') {
                            if (
                                $user->hasRole('Finance Cashier') ||
                                $user->hasRole('Super Admin for Finance') ||
                                $user->hasRole('Super Admin for Accounting') ||
                                $user->hasRole('Super_Administrator')
                            ) {
                                $btncontainer .= $accBtn;
                                $btncontainer .= $viewSubBtn;
                            } else if ($user->hasRole('Super_Administrator')) {
                                $btncontainer .= $editbtn;
                                // $btncontainer .= $accBtn;
                            } else if (
                                $user->hasRole('Registrar') ||
                                $user->hasRole('High School Department Super Administrator') ||
                                $user->hasRole('Evaluator')
                            ) {
                                $btncontainer .= $viewSubBtn;
                                $btncontainer .= $editbtn;
                            }
                        } else if ($query->status === 'PROCEED TO CASHIER') {
                            $btncontainer .= $printBtn;
                            if ($user->hasRole('Registrar')) {
                                // $btncontainer .= $viewSubBtn;
                            }
                        } else if ($query->status === 'OFFICIALLY ENROLLED') {
                            // default

                            if ($user->hasRole('Super Admin for Finance')) {
                                $btncontainer .= $printBtn;
                            } else if ($user->hasRole('Super_Administrator')) {
                                $btncontainer .= $deleteBtn;
                                // $btncontainer .= $viewSubBtn;
                                // $btncontainer .= $studentIntersession;
                                $btncontainer .= $printBtn;
                                $btncontainer .= $editbtn;
                            } else if (
                                $user->hasRole('Registrar') ||
                                $user->hasRole('High School Department Super Administrator')
                            ) {
                                // $btncontainer .= $studentIntersession;
                                // $btncontainer .= $viewSubBtn;
                                $btncontainer .= $deleteBtn;
                            } else if ($user->hasRole('Evaluator')) {
                                // $btncontainer .= $viewSubBtn;
                                // $btncontainer .= $studentIntersession;
                            } else if ($user->hasRole('Super Admin for Accounting')) {
                                $btncontainer .= $printBtn;
                            }
                        } else if ($query->status === 'CANCEL ACCOUNT') {
                            // $btncontainer .= $studentIntersession;
                        }
                    }
                    $btncontainer .= '</div>';
                    return $btncontainer;
                })
                ->addColumn('status', function ($query) {
                    if ($query->status == 'PENDING') {
                        $statusHtml = '<div class="font-size-13"><span class="badge bg-warning align-middle me-2">PENDING</span></div>';
                    } elseif ($query->status == 'FOR ENROLLMENT') {
                        $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">FOR ENROLLMENT</span></div>';
                    } elseif ($query->status == 'ACCOUNTING') {
                        $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">PROCEED TO ACCOUNTING</span></div>';
                    } elseif ($query->status == 'PROCEED TO CASHIER') {
                        $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">PROCEED TO CASHIER</span></div>';
                    } elseif ($query->status == 'OFFICIALLY ENROLLED') {
                        $statusHtml = '<div class="font-size-13"><span class="badge bg-success align-middle me-2">OFFICIALLY ENROLLED</span></div>';
                    } elseif ($query->status == 'CANCEL ACCOUNT') {
                        $statusHtml = '<div class="font-size-13"><span class="badge bg-danger align-middle me-2">CANCEL ACCOUNT</span></div>';
                    }

                    // Create the toggle switch HTML
                    // Combine the status badge and toggle switch
                    return $statusHtml;
                })
                ->addColumn('course', function ($query) {
                    return $query?->course?->code;
                })
                ->rawColumns(['action', 'time', 'status']);
            return $datatables->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $createaccountHighSchool = new CreateAccountHighSchool([
            ...$request->only([
                'id_number',
                'last_name',
                'first_name',
                'middle_name',
                'gender',
                'civil_status',
                'date_of_birth',
                'place_of_birth',
                'nationality',
                'religion',
                'control_number',
                'email',
                'home_address',
                'elementary',
                'year_graduated_elem',
                'junior_high_school',
                'year_graduated_elem_jhs',
                'senior_high_school',
                'year_graduated_elem_shs',
                'mothers_fullname',
                'occupation_mother',
                'contact_number_mother',
                'fathers_fullname',
                'occupation_father',
                'contact_number_father',
                'type_of_students',
                'course_id',
                'campus_id',
                'discount_id',
                'admission_date'
            ])
        ]);
        $createaccountHighSchool->save();
        // Magdagdag ng activity log
        $user = Auth::user();
        $dt = Carbon::now('Asia/Manila');
        $roleName = Role::find($user->roles()->first()?->id)?->name;
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Approve Account for ' . $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $request->session()->flash('success', 'Successfully Added');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
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
    public function update(Request $request, string $id)
    {
        //
        $request->validate(CreateAccountHighSchool::$rules);
        $createaccountHighSchool = CreateAccountHighSchool::findOrFail($id);
        $createaccountHighSchool->update(
            $request->only([
                'id_number',
                'last_name',
                'first_name',
                'middle_name',
                'gender',
                'civil_status',
                'date_of_birth',
                'place_of_birth',
                'nationality',
                'religion',
                'control_number',
                'email',
                'home_address',
                'elementary',
                'year_graduated_elem',
                'junior_high_school',
                'year_graduated_elem_jhs',
                'senior_high_school',
                'year_graduated_elem_shs',
                'mothers_fullname',
                'occupation_mother',
                'contact_number_mother',
                'fathers_fullname',
                'occupation_father',
                'contact_number_father',
                'type_of_students',
                'course_id',
                'campus_id',
                'discount_id',
                'admission_date',
                'year_level'

            ])
        );
        $user = Auth::User();

        $user = $request->User();
        $dt = Carbon::now('Asia/Manila');

        $roleName = Role::find($user->roles()->first()?->id)?->name;
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Approve Account for ' . $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),

        ];

        DB::table('activity_logs')->insert($activityLog);

        $createaccountHighSchool->save();
        $request->session()->flash('success', 'Edit Successfully Added');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $createaccounthighSchool = CreateAccountHighSchool::findOrFail($id);

        $user = Auth::user();
        $dt = Carbon::now('Asia/Manila');

        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Account for ' . $createaccounthighSchool->first_name . ' ' . $createaccounthighSchool->middle_name . ' ' . $createaccounthighSchool->last_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $createaccounthighSchool->delete();

        return response(['status' => 'success', 'message' => 'Student Account Deleted Successfully']);
    }
    public function changeStatus(Request $request, $id)
    {
        try {
            $student = CreateAccountHighSchool::find($id);
            $createAccount = CreateAccountHighSchool::where('id', $id)->first();
            if ($createAccount) {
                $createAccount->update(['status' => 'FOR ENROLLMENT']);
            }
            if ($request->has('curriculum_id')) {
                $student->curriculum_id = $request->curriculum_id;
            }
            // Perform any other updates if needed
            $student->save();
            return redirect()->back()->with('success', ' Curriculum Added successfully!');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function  getCurriculumHS(Request $request)
    {
        $courseId = $request->input('course_id');

        $curriculum = Curriculum::where('course_id', $courseId)->get();

        $user = Auth::User();

        $user = $request->User();
        $dt = Carbon::now('Asia/Manila');

        $roleName = Role::find($user->roles()->first()?->id)?->name;
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Approve Account for ' . $request->first_name . ' ' . $request->middle_name . ' ' .
                $request->last_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),

        ];

        DB::table('activity_logs')->insert($activityLog);

        return response()->json($curriculum);
    }
    public function studentSubHs(Request $request)
    {
        try {

            $createaccount = CreateAccountHighSchool::findOrFail($request->enrol_student_id);
            $createaccount->status = "ACCOUNTING";
            $user = $request->user();
            $dt = Carbon::now('Asia/Manila');

            $roleName = Role::find($user->roles()->first()?->id)?->name;
            $activityLog = [
                'username' => $user->name,
                'email' => $user->email,
                'role_name' => $roleName,
                'modify_user' => 'Enrolled Subject for ' . $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name,
                'date_time' => $dt->format('D, M j, Y g:i A'),
            ];

            DB::table('activity_logs')->insert($activityLog);
            $createaccount->save();

            $StudentSection = new StudentsSection([
                ...$request->only([
                    'full_name',
                    'id_number',
                    'curriculum_id',
                    'course_id',
                    'campus_id',
                    'year_level',
                    'semester',
                    'section_id',
                    'school_year'
                ])
            ]);


            $StudentSection->save();


            foreach ($request->subjects as $subject) {
                $subject = json_decode($subject);

                $lab_id = $subject->lab_id ?? null;

                if (!($lab_id)) {
                    $lab_id = laboratoryModel::where('description', $subject->lab_name)->first()?->id;
                }
                $course_id = $request->input('course_id');

                $section = Section::where('course_id', $course_id)->first();
                $existingEntry = student_Subject_highSchool::where('id_number', $request->id_number)
                    ->where('year_level', $request->year_level)
                    ->exists();
                $status = CreateAccountHighSchool::where('status', 'FOR ENROLLMENT');
                // dd($status);


                if (!$existingEntry) {
                    if ($section->number_of_students < $section->max_number_of_students) {

                        $section->number_of_students += 1;

                        $section->save();
                    } else {
                        return response(['status' => 'error', 'message' => 'Maximum number of students reached create another sections.']);
                    }
                }


                // dd($request->all());
                $newStudentSubject = new student_Subject_highSchool([
                    ...$request->only([
                        'id_number',
                        'curriculum_id',
                        'course_id',
                        'campus_id',
                        'year_level',
                        'semester',
                        'section_id',
                        'department_id',
                        'school_year'
                    ]),
                    // Mga field ng subject
                    'code' => $subject->code,
                    'descriptive_tittle' => $subject->descriptive_tittle,
                    'total_units' => $subject->total_units,
                    'lecture_units' => $subject->lecture_units,
                    'lab_units' => $subject->lab_units,
                    'pre_requisite' => $subject->pre_requisite,
                    'total_hrs_per_week' => $subject->total_hrs_per_week,
                    'lab_id' => $lab_id,
                    'subject_id' => $subject->subject_id,
                ]);

                $newStudentSubject->save();
            }

            return response(['status' => 'success', 'message' => 'Process Successfully Added! Proceed to Accounting']);
        } catch (\Exception $e) {
            // Handle exceptions if necessary
            dd($e);
        }
    }
    public function fees(Request $request)
    {
        // dd("testing");
        $year_level = $request->year_level;
        $campus_id = $request->campus_id;
        $semester = $request->semester;
        // dd($semester);
        $total_misc_fee = 0;
        //first kunin muna natin yung misc fee
        $misc_fees =  MiscFee::where('campus_id', $campus_id)->where('semester', $semester)->get();
        // dd($misc_fees);
        $mapped_misc_fees =  $misc_fees->map(function ($fee) use ($year_level, &$total_misc_fee) {
            $arr = [];

            switch ($year_level) {
                case 1:
                    $arr['amount'] = $fee->first_year;
                    break;
                case 2:
                    $arr['amount'] = $fee->second_year;
                    break;
                case 3:
                    $arr['amount'] = $fee->third_year;
                    break;
                case 4:
                    $arr['amount'] = $fee->fourth_year;
                    break;
            }
            //compute
            $arr['computation'] = $arr['amount'];
            $total_misc_fee += $arr['computation'];

            return [
                'category' => 'Miscellaneous Fee',
                'fee_type' => $fee->description,
                'lecture_units' => 1,
                ...$arr
            ];
        });
        // dd($mapped_misc_fees);
        //other fees
        $total_other_fees = 0;
        $other_fees = OtherFee::where('campus_id', $campus_id)->where('semester', $semester)->get();
        // dd($other_fees);
        $mapped_other_fees =  $other_fees->map(function ($fee) use ($year_level, &$total_other_fees) {
            $arr = [];
            switch ($year_level) {
                case 1:
                    $arr['amount'] = $fee->first_year;
                    break;
                case 2:
                    $arr['amount'] = $fee->second_year;
                    break;
                case 3:
                    $arr['amount'] = $fee->third_year;
                    break;
                case 4:
                    $arr['amount'] = $fee->fourth_year;
                    break;
            }
            //compute
            $arr['computation'] = $arr['amount'];
            $total_other_fees += $arr['computation'];
            return [
                'category' => 'Other Fees',
                'fee_type' => $fee->description,
                'lecture_units' => 1,
                ...$arr
            ];
        });
        // dd($mapped_other_fees);
        //Laboratory Fee
        // Laboratory Fees
        $total_laboratory_fees = 0;

        $laboratory_fees = student_Subject_highSchool::where('campus_id', $campus_id)->where('semester', $semester)
            ->with('laboratory')
            ->whereNotNull('lab_id')
            ->where('id_number', $request->student_id) // Idagdag ang kondisyon na hindi `null` ang lab_id
            ->get();
        // dd($laboratory_fees);

        $mapped_laboratory_fess = $laboratory_fees->map(function ($fee) use ($year_level, &$total_laboratory_fees, &$lab_units) {
            $arr = [];
            switch ($year_level) {
                case 1:
                    $arr['amount'] = $fee->laboratory ? $fee->laboratory->first_year : 0;
                    break;
                case 2:
                    $arr['amount'] = $fee->laboratory ? $fee->laboratory->second_year : 0;
                    break;
                case 3:

                    $arr['amount'] = $fee->laboratory ? $fee->laboratory->third_year : 0;
                    break;
                case 4:
                    $arr['amount'] = $fee->laboratory ? $fee->laboratory->fourth_year : 0;
                    break;
                default:
                    $arr['amount'] = 0;
            }
            $arr['computation'] = $arr['amount']  * $fee->lab_units;
            $total_laboratory_fees += $arr['computation'];
            return [
                'category' => 'Laboratory Fees',
                'fee_type' => $fee->laboratory->description,
                'lecture_units' => $fee->lab_units,
                ...$arr
            ];
        });
        //Tuition Fee
        //Rate
        $tuition_rate = TuitionFee::where('campus_id', $campus_id)->where('semester', $semester)->first();
        // dd($tuition_rate);
        $tuition_rate_amount = 0;
        switch ($year_level) {
            case 1:
                $tuition_rate_amount  = $tuition_rate->first_year;
                break;
            case 2:
                $tuition_rate_amount =  $tuition_rate->second_year;
                break;
            case 3:
                $tuition_rate_amount = $tuition_rate->third_year;
                break;
            case 4:
                $tuition_rate_amount = $tuition_rate->fourth_year;
                break;
        }
        //Units
        $lecture_units =  student_Subject_highSchool::where('id_number', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('campus_id', $request->campus_id)
            ->where('year_level', $request->year_level)
            ->where('semester', $request->semester)
            ->sum('lecture_units');
        // ->get();
        // dd($lecture_units);
        // dd($total_units);
        $tuition_fee = [
            'category' => 'Tuition Fees',
            'fee_type' => 'TUITION FEE/UNITS',
            'lecture_units' => $lecture_units,
            'computation' => 8750,
            'amount' => $tuition_rate_amount,
        ];

        // dd($tuition_fee);
        //next pwede na natin ipasok sa Datatable
        //all total fees
        // add natin dito yung iba para sa frontend
        $all_fees = [
            $tuition_fee,
            ...$mapped_misc_fees,
            ...$mapped_other_fees,
            ...$mapped_laboratory_fess
        ];

        $total = 0;
        foreach ($all_fees as $fee) {
            //compute total
            $total += $fee['computation'];
        }
        //test muna sa total
        // dd($total);

        return dataTables()->of($all_fees)
            ->with([
                //response lang from back end hindi siya mag papakita
                'total' => $total,
                // //ngayon okay na siya sa backend ngayon frontend naman
                // // 'other fees' => $mapped_other_fees

                //ngayon okay na sila meron na yung buong total indivudualy FE na next
                'total_misc_fee' => $total_misc_fee,
                'total_other_fees' => $total_other_fees,
                'total_tuition_fees' => 8750,
                'total_laboratory_fees' => $total_laboratory_fees,
            ])
            ->make(true);
    }

    public function studentFee(Request $request)
    {


        $year_level = $request->input('year_level');
        $total_misc_fee_per_year = $request->input('total_miscfee_first_year');

        // dd($total_misc_fee_per_year);
        foreach ($request->fees as $fee) {
            $fee = json_decode($fee);

            // dd($fee->lecture_units);
            switch ($year_level) {
                case 1:
                    $total_miscfee_first_year =  $total_misc_fee_per_year;
                    break;
                case 2:
                    $total_miscfee_second_year = $total_misc_fee_per_year;
                    break;
                case 3:
                    $total_miscfee_third_year = $total_misc_fee_per_year;
                    break;
                case 4:
                    $total_miscfee_fourth_year = $fee->total_misc_fee_per_year;
                    break;
                default:
                    break;
            }
            (new studentAssesment([
                //tung request dito is yungg mga form for example mga input
                ...$request->only([
                    'id_number',
                    'school_year',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals',
                    'total_assessment',
                    'total_miscfee_first_year',
                    'total_miscfee_second_year',
                    'total_miscfee_third_year',
                    'total_miscfee_fourth_year',
                    'sprelims',
                    'sdownpayment',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'stotal_assessment',
                    'semester'
                ]),
                // dito is yung mga subject lang na kailangan natin ilagay 
                'category' => $fee->category,
                'fee_type' => $fee->fee_type,
                'amount' => $fee->amount,
                'lecture_units' => $fee->lecture_units,
                'computation' => $fee->computation,
                'computation2Tuition' => $fee->computation,
                'total_miscfee_first_year' => $total_miscfee_first_year ?? null,
                'total_miscfee_second_year' => $total_miscfee_second_year ?? null,
                'total_miscfee_third_year' => $total_miscfee_third_year ?? null,
                'total_miscfee_fourth_year' => $total_miscfee_fourth_year ?? null,

            ]))->save();
        }
    }
}
