<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CreateAccountDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CreateAccount;
use App\Models\CreateAccountHighSchool;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\Department;
use App\Models\fee_summary;
use App\Models\FeeType;
use App\Models\FullPackagefees;
use App\Models\laboratoryModel;
use App\Models\MiscFee;
use App\Models\nonassesed;
use App\Models\nonassessed;
use App\Models\OtherFee;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\section_subjectss;
use App\Models\studentAssesment;
use App\Models\StudentsSection;
use App\Models\StudentSubject;
use App\Models\Subject;
use App\Models\TuitionFee;
use Carbon\Carbon;
use Egulias\EmailValidator\Result\Reason\CRLFX2;
use GuzzleHttp\Promise\Create;
// use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use PDO;
use PHPUnit\Framework\Constraint\Count;
use Spatie\Permission\Commands\CreateRole;
use Spatie\Permission\Models\Role;
use Termwind\Components\Dd;
use Whoops\Util\Misc;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Services\DataTable as ServicesDataTable;

use function Ramsey\Uuid\v1;

class CreateAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(CreateAccountDataTable $dataTable)
    {
        $department = Department::all();
        $course = Course::all();
        $campus = Campus::all();
        $curriculum = Curriculum::all();
        $sch_years = SchoolYear::all();

        $activeSchoolYear = SchoolYear::where('status', 1)->first();
        $semester = $activeSchoolYear?->semester;

        $otherFees = OtherFee::where('semester', $semester)->get();


        return $dataTable->render('Roles.Super_Administrator.create_accounts.index', compact('course', 'campus', 'curriculum', 'department', 'sch_years', 'otherFees'));

        // Generate Excel export
        return $dataTable->excel();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(request $request)
    {
        try {
            // Check for duplicate entry
            $hasDuplicate = CurriculumSubject::where('curriculum_id', $request->curriculum_id)->first();
            if ($hasDuplicate) {
                return response(['status' => 'error', 'message' => 'Duplicate entry']);
            }
            // Fetch data for DataTable using AJAX
            if (request()->ajax()) {

                $subject = CurriculumSubject::all();
                return datatables()->of($subject)
                    // ->addColumn('section', function ($query) {
                    //     return $query?->section?->section_code;
                    // })
                    ->addColumn('lab_id', function ($query) {
                        return $query?->laboratory?->description;
                    })
                    ->addColumn('time', function ($query) {
                        return $query?->detailsofsubjects?->time;
                    })
                    ->addColumn('day', function ($query) {
                        return $query?->detailsofsubjects?->day;
                    })
                    ->addColumn('room', function ($query) {
                        return $query?->detailsofsubjects?->room;
                    })
                    ->addColumn('curriculum', function ($query) {
                        return $query?->curriculum?->code;
                    })
                    ->addColumn('action', function ($query) {
                        // Create button HTML for DataTable action column
                        $addbtn = '<button type="button" id="addSubjectButton" class="btn btn-success" onclick="addSubject( ' . $query->id . ', 
                        \'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \'' . $query->total_units . '\', 
                        \'' . $query->lecture_units . '\', \'' . $query->lab_units . '\', \'' . $query->pre_requisite . '\', 
                        \'' . $query->total_hrs_per_week . '\')">+</button>';

                        return $addbtn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            // Handle exceptions if any
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // $request->validate(CreateAccount::$rules);
        //handle duplicate entry
        $HandleName = CreateAccount::where('first_name', $request->first_name)
            ->where('middle_name', $request->middle_name)
            ->where('last_name', $request->last_name)
            ->get();
        $HandleIDNumber = CreateAccount::where('id_number', $request->id_number)->get();

        if (!$HandleName->isEmpty()) {
            $request->session()->flash('error', 'Name Already Exists or ID Number');
            return redirect()->back()->withInput();
        } else if (!$HandleIDNumber->isEmpty()) {
            $request->session()->flash('error', 'ID Number Exists');
            return redirect()->back()->withInput();
        }
        $createaccount = new CreateAccount([
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
                'admission_date',
                'island',
                'municipality',
                'barangay',
                'extention',
                'municipality_code',
                'barangay_code',
                'streetname',
                'houseno',
                'regioncode',
                'regionname',
            ])
        ]);
        $createaccount->save();

        // Add an activity log
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
        // dd($request->all());
        $request->validate(CreateAccount::$rules);
        $createaccount = CreateAccount::findOrFail($id);
        $createaccount->update(
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
                'year_level',
                'extention',
                'island',
                'municipality',
                'barangay',
                'municipality_code',
                'barangay_code',
                'regioncode',
                'regionname',
                'streetname',
                'houseno',


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
            'modify_user' => 'Edit Account for ' . $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),

        ];

        DB::table('activity_logs')->insert($activityLog);

        $createaccount->save();
        $request->session()->flash('success', 'Edit Successfully Added');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $createaccount = CreateAccount::with('student_assestment', 'student_subject',  'studentSection')->findOrFail($id);
        $user = Auth::user();
        $dt = Carbon::now('Asia/Manila');

        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Account for ' . $createaccount->first_name . ' ' . $createaccount->middle_name . ' ' . $createaccount->last_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $createaccount->delete();

        return response(['status' => 'success', 'message' => 'Student Account Deleted Successfully']);
    }
    public function getLastId()
    {
        $lastID = CreateAccount::latest()->first();

        if ($lastID) {
            return response(['lastID' => $lastID->id_number]);
        } else {
            return response(['lastID' => '2023-1-0000']);
        }
    }
    public function changeStatus(Request $request, $id)
    {
        // dd($request->all());
        try {
            $student = CreateAccount::findOrFail($id);

            // Update student record
            $student->status = 'FOR ENROLLMENT';
            if ($request->has('curriculum_id')) {
                $student->curriculum_id = $request->curriculum_id;
            }
            $student->save();

            return redirect()->back()->with('success', 'Curriculum Added successfully!');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function getSectionWithSubject($curriculum_id, $semester_id, $year_level)
    {
        if (request()->ajax()) {
            $subjects = CurriculumSubject::where('curriculum_id', $curriculum_id)->where('year_level', $year_level)
                ->where('semester_id', $semester_id);


            $datatables = datatables()->of($subjects)
                ->addIndexColumn()
                ->addColumn('action', function ($query) {

                    // $addDetails = '<a href="#">';
                    // $addDetails .= '<button type="button" class="btn btn-primary waves-effect waves-light OpenModal" onclick="hasAction(' . $query->id . ')">';
                    // $addDetails .= '+';
                    // $addDetails .= '</button></a>';
                    // return $addDetails;
                })
                // ->addColumn('time', function ($query) {
                //     return $query->detailsofsubjects?->time;
                // })
                // ->addColumn('day', function ($query) {
                //     return $query->detailsofsubjects?->day;
                // })
                // ->addColumn('room', function ($query) {
                //     return $query->detailsofsubjects?->room;
                // })
                // ->addColumn('instructor_id', function ($query) {
                //     return $query->detailsofsubjects?->instructorss->full_name;
                // })
                // ->addColumn('department', function ($query) {
                //     return $query->detailsofsubjects?->instructorss->department;
                // })
                ->rawColumns(['action', 'time', 'day', 'room', 'instructor_id', 'department']);
            return $datatables->make(true);
        }
    }
    public function  getSectionByCurriculum(string $curriculum_id, Request $request)
    {


        $curriculum = Curriculum::findOrFail($curriculum_id);
        $year_level = $request->input('year_level');
        $semester = $request->input('semester');
        $school_year = $request->input('school_year');


        $sections = Section::where('course_id', $curriculum->course_id)
            ->where('year_level', $year_level)
            ->where('semester', $semester)
            ->where('school_year', $school_year)
            ->select('id', 'section_code')
            ->whereRaw('number_of_students < max_number_of_students')
            ->get();
        // dd($school_year);
        return $sections;
    }
    public function studentSub(Request $request)
    {
        // dd($request->all());
        //onn this function is to update the status onn other database table using find or fail
        //annd using function the enrol->request is yun name ng input hidden
        try {
            $createaccount = CreateAccount::findOrFail($request->enrol_student_id);
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

            $existingSubject = StudentSubject::where('id_number', $request->id_number)
                ->where('school_year', $request->school_year)
                ->where('semester', $request->semester)
                ->first();
            // dd($existingSubject);
            foreach ($request->subjects as $subject) {
                $subject = json_decode($subject);

                $lab_id = $subject->lab_id ?? null;

                if (!($lab_id)) {
                    $lab_id = laboratoryModel::where('description', $subject->lab_name)->first()?->id;
                }
                $course_id = $request->input('course_id');

                $section = Section::where('course_id', $course_id)->where('year_level', $request->year_level)->first();
                $existingEntry = StudentSubject::where('id_number', $request->id_number)
                    ->where('year_level', $request->year_level)
                    ->exists();


                if (!$existingEntry) {
                    if ($section->number_of_students < $section->max_number_of_students) {

                        $section->number_of_students += 1;

                        $section->save();
                    } else {
                        return response(['status' => 'error', 'message' => 'Maximum number of students reached create another sections.']);
                    }
                }

                if ($existingSubject) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You have already enrolled in this subject for semester ' . $request->semester . ' on this school year '
                    ]);
                } else {
                    $newStudentSubject = new StudentSubject([
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
                        // Subject details
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
            }

            return response(['status' => 'success', 'message' => 'Process Successfully Added! Proceed to Accounting']);
        } catch (\Exception $e) {
            // Handle exceptions if necessary
            // dd($e);
        }
    }

    public function total_units(string $curriculum_id)
    {
        // $student = StudentSubject::where('id_numbe', $student_id)->first();
        $student = Curriculum::where('id_number', $curriculum_id)->first();

        $totalUnits = $student->subjects()->sum('total_units');
        // dd($totalUnits);

        // Return the result as a JSON response
        return response(['status' => 'success', 'message' => 'Summary details fetched successfully!', 'data' => $totalUnits]);
    }
    public function fees(Request $request)
    {
        $validate = $request->validate([
            'year_level' => 'required',
            'campus_id' => 'required',
            'semester' => 'required',
            'course_id' => 'required',
        ]);

        $year_level = $request->year_level;
        $campus_id = $request->campus_id;
        $semester = $request->semester;
        $course_id = $request->course_id;

        $campus = Campus::find($campus_id);
        if (!$campus) {
            return response()->json(['error' => 'Invalid campus selected'], 400);
        }
        $campus_code = $campus->code;


        $total_misc_fee = 0;
        $mapped_misc_fees = [];
        $mapped_laboratory_fess = [];
        $tuition_fee = [];
        $lecture_units = 0;
        $tuition_rate_amount = 0;
        $total_laboratory_fees = 0;


        // Miscellaneous Fees
        $misc_fees = MiscFee::where('campus_id', $validate['campus_id'])
            ->where('semester', $validate['semester'])
            ->get();

        $mapped_misc_fees = $misc_fees->map(function ($fee) use ($year_level, &$total_misc_fee) {
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

            $arr['computation'] = $arr['amount'];
            $total_misc_fee += $arr['computation'];
            return [
                'category' => 'Miscellaneous Fee',
                'fee_type' => $fee->description,
                'lecture_units' => 1,
                'miscfee_id' => $fee->id,
                ...$arr
            ];
            // dd($fee->id);
        });



        // Laboratory Fees
        $total_laboratory_fees = 0;
        $laboratory_fees = StudentSubject::where('campus_id', $validate['campus_id'])
            ->where('semester', $validate['semester'])
            ->with('laboratory')
            ->whereNotNull('lab_id')
            ->where('id_number', $request->student_id)
            ->get();

        $mapped_laboratory_fess = $laboratory_fees->map(function ($fee) use ($year_level, &$total_laboratory_fees) {
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
            $arr['computation'] = $arr['amount'] * $fee->lab_units;
            $total_laboratory_fees += $arr['computation'];
            return [
                'category' => 'Laboratory Fees',
                'fee_type' => $fee->laboratory->description,
                'lecture_units' => $fee->lab_units,
                'lab_id' => $fee->lab_id,
                ...$arr
            ];
        });

        // Tuition Fees
        $tuition_rate = TuitionFee::where('campus_id', $validate['campus_id'])
            ->where('semester', $validate['semester'])
            ->first();

        $tuition_rate_amount = 0;
        switch ($year_level) {
            case 1:
                $tuition_rate_amount = $tuition_rate->first_year;
                break;
            case 2:
                $tuition_rate_amount = $tuition_rate->second_year;
                break;
            case 3:
                $tuition_rate_amount = $tuition_rate->third_year;
                break;
            case 4:
                $tuition_rate_amount = $tuition_rate->fourth_year;
                break;
        }

        $lecture_units = StudentSubject::where('id_number', $request->student_id)
            ->where('course_id', $request->course_id)
            ->where('campus_id', $request->campus_id)
            ->where('year_level', $request->year_level)
            ->where('semester', $request->semester)
            ->sum('lecture_units');

        $tuition_fee = [
            'category' => 'Tuition Fees',
            'fee_type' => 'TUITION FEE/UNITS',
            'lecture_units' => $lecture_units,
            'computation' => $lecture_units * $tuition_rate_amount,
            'amount' => $tuition_rate_amount,
        ];

        $total_other_fees = 0;
        $other_fees = OtherFee::where('campus_id', $validate['campus_id'])
            ->where('semester', $validate['semester'])

            ->get();
        // dd($other_fees);
        $mapped_other_fees = $other_fees->map(function ($fee) use ($year_level, &$total_other_fees) {
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
            $arr['computation'] = $arr['amount'];
            $total_other_fees += $arr['computation'];
            return [
                'category' => 'Other Fees',
                'fee_type' => $fee->description,
                'lecture_units' => 1,
                'otherFees_id' => $fee->id,
                ...$arr
            ];
        });




        $total_fullpackage_fees = 0;
        $fpf_fees = FullPackagefees::where('campus_id', $validate['campus_id'])
            ->where('semester', $validate['semester'])
            ->where('course_id', $validate['course_id'])
            ->get();
        // dd($other_fees);
        $mapped_fullpackage_fees = $fpf_fees->map(function ($fee) use ($year_level, &$total_fullpackage_fees) {
            $arr = [];
            switch ($year_level) {
                case 1:
                    $arr['amount'] = null;
                    break;
                case 2:
                    $arr['amount'] = null;
                    break;
                case 4:
                    $arr['amount'] = $fee->fourth_year;
                    break;
                case 5:
                    $arr['amount'] = $fee->fifth_year;
                    break;
            }

            $arr['computation'] = $arr['amount'];
            $total_fullpackage_fees += $arr['computation'];


            if ($arr['amount'] !== null) {
                return [
                    'category' => 'Full Package',
                    'fee_type' => $fee->description,
                    'lecture_units' => 0,
                    ...$arr
                ];
            }
            return null;
        })->filter();
        // dd($semester == 2);
        if ($year_level >= 4 && $semester == 2 && $campus_code == 'MCNP') {
            $all_fees = $mapped_fullpackage_fees;
            $total_misc_fee = 0;
            $total_other_fees = 0;
            $total_tuition_fees = 0;
            $total_laboratory_fees = 0;
        } else {
            $all_fees = [
                $tuition_fee,
                ...$mapped_misc_fees,
                ...$mapped_other_fees,
                ...$mapped_laboratory_fess,
                ...$mapped_fullpackage_fees
            ];
        }
        // dd($all_fees);

        // Calculate total
        $total = 0;
        foreach ($all_fees as $fee) {
            $total += $fee['computation'];
        }

        return dataTables()->of($all_fees)
            ->with([
                'total' => $total,
                'total_misc_fee' => $total_misc_fee,
                'total_other_fees' => $total_other_fees,
                'total_tuition_fees' => $lecture_units * $tuition_rate_amount,
                'total_laboratory_fees' => $total_laboratory_fees,
                'total_fullpackage_fees' => $total_fullpackage_fees,
                // 'Lab_id',
            ])
            ->make(true);
    }

    public function studentFee(Request $request)
    {

        // dd($request->all());
        $year_level = $request->input('year_level');
        $total_misc_fee_per_year = $request->input('total_miscfee_first_year');
        foreach ($request->fees as $fee) {
            // dd($fee);
            $fee = json_decode($fee);
            $lab_id = property_exists($fee, 'lab_id') ? $fee->lab_id : null;
            $misc_id = property_exists($fee, 'miscfee_id') ? $fee->miscfee_id : null;
            $otherfees_id = property_exists($fee, 'otherFees_id') ? $fee->otherFees_id : null;

            // dd($lab_id);

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
                    $total_miscfee_fourth_year = $total_misc_fee_per_year;
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
                    'semester',
                    'course_id',
                    'year_level',
                    'campus_id',
                    'totalAss',
                    'or_number',

                ]),
                // dito is yung mga subject lang na kailangan natin ilagay
                'category' => $fee->category,
                'fee_type' => $fee->fee_type,
                'amount' => $fee->amount,
                'lecture_units' => $fee->lecture_units,
                'computation' => $fee->computation,
                'computation2Tuition' => $fee->computation,
                'tutionFees' => $fee->computation,
                'tutionFeesDeleteSub' => $fee->computation,
                'lab_id' => $lab_id,
                'miscfee_id' => $misc_id,
                'otherFees_id' => $otherfees_id,
                'total_miscfee_first_year' => $total_miscfee_first_year ?? null,
                'total_miscfee_second_year' => $total_miscfee_second_year ?? null,
                'total_miscfee_third_year' => $total_miscfee_third_year ?? null,
                'total_miscfee_fourth_year' => $total_miscfee_fourth_year ?? null,

            ]))->save();
            // dd(['computation2Tuition' => $fee->computation,]);
        }
        $studentId = $request->input('id_number');
        $student = CreateAccount::where('id_number', $studentId)->first();
        if ($student) {
            $student->status = 'PROCEED TO CASHIER';
            $student->save();
        }
        $studentHS = CreateAccountHighSchool::where('id_number', $studentId)->first();
        if ($studentHS) {
            $studentHS->status = 'PROCEED TO CASHIER';
            $studentHS->save();
        }

        $user = $request->user();
        $dt = Carbon::now('Asia/Manila');

        $roleName = Role::find($user->roles()->first()?->id)?->name;
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Confirm Assessment for ' . $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        return response(['status' => 'success', 'message' => 'Assessment Saved!']);
        return redirect()->back();
    }
    public function getSubjectEnrolled(Request $request)
    {

        try {
            if ($request->ajax()) {
                $latestSemester = StudentSubject::where('id_number', $request->id_number)->max('semester');
                // dd($latestSemester);
                $data = StudentSubject::with(['additionalSubjectDetails'])
                    ->where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->select('id', 'code', 'descriptive_tittle', 'pre_requisite', 'total_units', 'lecture_units', 'lab_units', 'subject_id', 'total_hrs_per_week')
                    ->get();

                // dd($data);
                $datatables = datatables()->of($data)
                    // ->addIndexColumn()
                    ->addColumn('action', function ($query) {
                        // dd($query);
                        $deletebtn = '<form action="' . route('superadmin.delete.subject', $query->id) . '" method="POST">';
                        $deletebtn .= csrf_field();
                        $deletebtn .= method_field('DELETE');
                        $deletebtn .= '<button class="btn btn-danger delete-items mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                        $deletebtn .= '</form>';
                        return $deletebtn;
                    })
                    ->addColumn('instructor', function ($query) {
                        // dd();
                        return $query?->latestDetailOfSubject?->instructorss?->full_name;
                    })
                    ->addColumn('time', function ($query) {
                        return $query?->latestDetailOfSubject?->time;
                    })
                    ->addColumn('room', function ($query) {
                        return $query?->latestDetailOfSubject?->room;
                    })
                    ->addColumn('day', function ($query) {
                        return $query?->latestDetailOfSubject?->day;
                    })
                    ->rawColumns(['action', 'time']);
                return $datatables->make(true);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function calculateUnits(string $id_number, string $semester)
    {
        try {
            $units = StudentSubject::where('id_number', $id_number)
                ->where('semester', $semester)
                ->selectRaw('SUM(total_units) as total_units, SUM(lecture_units) as lecture_units, SUM(lab_units) as lab_units')
                ->first();
            return response()->json([
                'total_units' => $units->total_units,
                'lecture_units' => $units->lecture_units,
                'lab_units' => $units->lab_units
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error calculating total units'], 500);
        }
    }
    public function get(request $request)
    {
        $curriculumId = $request->input('curriculum_id');
        $query = CurriculumSubject::where('curriculum_id', $curriculumId)
            ->orderBy('year_level', 'asc')
            ->select(
                'id',
                'year_level',
                'semester_id',
                'code',
                'lecture_units',
                'descriptive_tittle',
                'total_units',
                'lab_units',
                'pre_requisite',
                'total_hrs_per_week',
                'lab_id'
            );
        return DataTables::eloquent($query)
            ->addColumn('Check Box', function ($query) {
                $check = '<input type="checkbox" class="form-check-input check-item" name="check[]" value="' . $query->id . '">';
                return $check;
            })
            ->addColumn('action', function ($query) {
                $btnContainer = '<div class="d-flex justify-content-center">';

                $deleteBtn = '<form action="' . route('superadmin.delete.CSubject', $query->id) . '" method="POST">';
                $deleteBtn .= csrf_field();
                $deleteBtn .= method_field('DELETE');
                $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i
                class="ri-delete-bin-fill"></i></button>';
                $deleteBtn .= '</form>';

                // $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editCurriculumSubject" onclick="editCurriculumSubject
                //     (' . $query->id . ', \'' . $query->year_level . '\',\'' . $query->semester_id . '\', \'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \'' . $query->total_units . '\',\'' . $query->lecture_units . '\', \'' . $query->lab_units . '\',\'' . $query->pre_requisite . '\', \'' . $query->total_hrs_per_week . '\' )">';
                // $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light mx-1"><i class="ri-edit-2-fill"></i></button></a>';

                $btnContainer .= $deleteBtn;
                $btnContainer .= '</div>';
                return $btnContainer;
            })
            ->rawColumns(['Check Box', 'action'])
            ->toJson();
    }
    public function getsemester($semester)
    {
        $schoolYear = SchoolYear::find($semester);

        return response()->json(['semester' => $schoolYear->semester]);
    }
    public function getCurriculum(Request $request)
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
    public function addSubjectView(Request $request)
    {

        if (request()->ajax()) {
            // Query the section_subjectss where the school_year matches
            $sectionSubjects = section_subjectss::all();

            return datatables()->of($sectionSubjects)
                // ->addColumn('curriculum_id', function ($query) {
                //     return $query?->curriculum?->code;
                // })
                // ->addColumn('lab_name', function ($query) {
                //     return $query->laboratory->description ?? '';
                // })
                // ->addColumn('time', function ($query) {
                //     // dd($query?->detailsofsubjects?->time);
                //     return $query?->latestDetailOfSubject?->time;
                // })
                // ->addColumn('room', function ($query) {
                //     return $query?->latestDetailOfSubject?->room;
                // })
                // ->addColumn('day', function ($query) {
                //     return $query?->latestDetailOfSubject?->day;
                // })
                ->addColumn('section', function ($query) {
                    return $query?->section?->section_code;
                })
                ->addColumn('action', function ($query) {

                    $addbtn = '<button type="button" id="addSubjectViewButton" class="btn btn-success" onclick="addonStudentSubject('
                        . $query->id . ',\'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \''
                        . $query->total_units . '\', \'' . $query->lecture_units . '\', \'' . $query->lab_units . '\', 
                        \'' . $query->pre_requisite . '\', \'' . $query->total_hrs_per_week . '\', \'' . $query->lab_id . '\', 
                        \'' . $query?->create_account?->curriculum_id . '\', \'' . $query?->create_account?->course_id . '\', 
                        \'' . $query?->create_account?->campus_id . '\', \'' . $query?->create_account?->id_number . '\', 
                        \'' . $query?->studentSubjects?->year_level . '\', \'' . $query?->studentSubjects?->semester . '\',
                        \'' . $query?->studentSubjects?->section_id . '\',\'' . $query?->studentSubjects?->department_id . '\',
                         \'' . $query?->studentSubjects?->school_year . '\',
                         
                         )">+</button>';

                    return $addbtn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function getLastIDNumber()
    {
        $lastIdNumber = CreateAccount::max('id_number');

        return response()->json(['last_id_number' => $lastIdNumber]);
    }
    public function getLastORNumber(Request $request)
    {

        $role = $request->input('role');
        $name = $request->input('name');
        // dd($role);
        if ($role == 'Finance Cashier') {
            $lastOrNumber = fee_summary::where('cahier_in_charge', 'Finance Cashier')->where('name', $name)
                ->latest('created_at')
                ->value('or_number');
        } elseif ($role == 'Super Admin for Finance') {

            $lastOrNumber = fee_summary::where('cahier_in_charge', 'Super Admin for Finance')->where('name', $name)
                ->latest('created_at')
                ->value('or_number');
        } elseif ($role == 'Super_Administrator') {

            $lastOrNumber = fee_summary::where('cahier_in_charge', 'Super_Administrator')->where('name', $name)
                ->latest('created_at')
                ->value('or_number');
        }
        return response()->json(['last_or_number' => $lastOrNumber]);
    }
    public function changeStatusIntersssion(String $id)
    {
        $student = CreateAccount::find($id);
        $StudentStatus = CreateAccount::where('id', $id)->first();
        if ($StudentStatus) {
            $StudentStatus->update(['status' => 'PENDING']);
        }
        $student->save();
        return redirect()->back()->with('success', ' Enroll Student on Intersession!');
    }
    public function addSubjectenrolledstudent(Request $request)
    {
        try {
            // Check for duplicate entry
            $hasDuplicate = CurriculumSubject::where('curriculum_id', $request->curriculum_id)->first();
            if ($hasDuplicate) {
                return response(['status' => 'error', 'message' => 'Duplicate entry']);
            }
            // Fetch data for DataTable using AJAX
            if (request()->ajax()) {

                $subject = section_subjectss::all();
                return datatables()->of($subject)
                    // ->addColumn('section', function ($query) {
                    //     return $query?->section?->section_code;
                    // })
                    // ->addColumn('lab_id', function ($query) {
                    //     return $query?->laboratory?->description;
                    // })
                    // ->addColumn('time', function ($query) {
                    //     return $query?->detailsofsubjects?->time;
                    // })
                    ->addColumn('instructor_id', function ($query) {
                        return $query?->instructor?->full_name;
                    })
                    ->addColumn('section', function ($query) {
                        return $query?->section?->section_code;
                    })
                    ->addColumn('curriculum', function ($query) {
                        return $query?->curriculum?->code;
                    })
                    ->addColumn('action', function ($query) {
                        // Create button HTML for DataTable action column
                        $addbtn = '<button type="button" id="addSubjectButton" class="btn btn-success" onclick="addSubject( ' . $query->id . ', 
                        \'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \'' . $query->total_units . '\',
                        \'' . $query->lecture_units . '\', \'' . $query->lab_units . '\', \'' . $query->pre_requisite . '\', 
                        \'' . $query->total_hrs_per_week . '\',  \'' . $query->time . '\', \'' . $query->day . '\', \'' . $query->room . '\', \'' . $query->lab_id . '\', \'' . $query->instructor?->full_name . '\')">+</button>';

                        return $addbtn;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            // Handle exceptions if any
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
