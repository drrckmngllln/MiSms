<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CreateAccount;
use App\Models\CreateAccountHighSchool;
use App\Models\fee_summary;
use App\Models\laboratoryModel;
use App\Models\MiscFee;
use App\Models\OtherFee;
use App\Models\SchoolYear;
use App\Models\studentAssesment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeeCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $activeSchoolYear = SchoolYear::where('status', 1)->first();
        $semester = $activeSchoolYear?->semester;
        $school_year = SchoolYear::all();

        $user = Auth::user();
        $role = $user->roles->first()->name;
        $name = $user->name;
        $id = $user->id;

        $otherFees = OtherFee::where('semester', $semester)->get();
        $fees = collect();
        foreach ($otherFees as $fee) {
            $fees->push([
                'id' => $fee->id,
                'description' => $fee->description,
                'semester' => $fee->semester ?? 'N/A',
                'campus' => $fee->campus?->code ?? 'N/A',
                'campus_id' => $fee->campus_id,
            ]);
        }
        // dd($name);
        return view('Roles.Super_Administrator.fee_collection.index', compact('school_year', 'name', 'role', 'fees', 'id'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function feeCollectionselectStudents()
    {

        $createAccountTable = CreateAccount::select('id', 'id_number', 'last_name', 'first_name', 'middle_name', 'status', 'course_id', 'campus_id')->get();
        // dd($createAccountTable);
        $addStudentHS = CreateAccountHighSchool::select('id', 'id_number', 'last_name', 'first_name', 'middle_name', 'status', 'course_id')->get();
        $addStudent = new Collection([...$createAccountTable, ...$addStudentHS]);
        if (request()->ajax()) {
            return datatables()->of($addStudent)
                ->addColumn('action', function ($query) {

                    if ($query instanceof CreateAccount) {
                        $student_subject = $query->student_subject;
                    } else {
                        $student_subject = $query->student_subject_highSchool;
                    }
                    $student_assessment = $query->student_assestment;

                    $courseCode = optional(optional($student_subject)->course)->code ?? '';
                    $yearLevel = optional($student_subject)->year_level ?? '';
                    $studentSemester = optional($student_subject)->semester ?? '';
                    // Payment values
                    $studentDownpayment = optional($student_assessment)->downpayment ?? '';
                    $studentPrelims = optional($student_assessment)->prelims ?? '';
                    $studentMidterms = optional($student_assessment)->midterms ?? '';
                    $studentSemiFinals = optional($student_assessment)->semi_finals ?? '';
                    $studentFinals = optional($student_assessment)->finals ?? '';
                    $studentTotal = optional($student_assessment)->total_assessment ?? '';
                    $TotalAss = optional($student_assessment)->totalAss ?? '';

                    // dd($query->student_assestment->total_assessment);

                    $addbtn = '<button type="button" class="btn btn-success" onclick="addSelectStudent(' . $query->id . ',
                    \'' . $query->id_number . '\', \'' . $query->status . '\',\'' . $query->last_name . '\',
                    \'' . $query->first_name . '\',\'' . $query->middle_name . '\',\'' . $courseCode . '\', 
                    \'' . $yearLevel . '\', \'' . $studentSemester . '\',\'' . $studentDownpayment . '\', 
                    \'' . $studentPrelims . '\', \'' . $studentMidterms . '\',\'' . $studentSemiFinals . '\',
                    \'' . $studentFinals . '\',\'' . $studentTotal . '\',\'' . $TotalAss . '\', \'' . $query->campus_id . '\', \'' . $query->student_subject?->school_year . '\',
                        \'' . $query->student_assestment?->sdownpayment . '\', \'' . $query->student_assestment?->sprelims . '\',\'' . $query->student_assestment?->smidterms . '\',
                     \'' . $query->student_assestment?->ssemi_finals . '\',     \'' . $query->student_assestment?->sfinals . '\' ,\'' . $query->student_assestment?->stotal_assessment . '\',
                     \'' . $query->student_subject?->department_id . '\' , \'' . $query->student_subject?->campus_id . '\',\'' . $query->student_subject?->course_id . '\'  
                    )">+</button>';
                    return $addbtn;
                })
                ->addColumn('course', function ($query) {

                    return $query?->course?->code;
                    // dd($query->course->code);
                })



                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function showStudentDetails($id)
    {
        $studentSelect = CreateAccount::find($id);
        if ($studentSelect) {
            return view('Roles.Super_Administrator.fee_collection.index', ['student' => $studentSelect]);
        } else {
            abort(404, 'Student not found');
        }
    }
    public function getfeetypecomputation(Request $request, $id_number)
    {
        // dd($id_number);
        $latestSemester = studentAssesment::where('id_number', $id_number)
            ->max('semester');
        if (request()->ajax()) {
            return datatables()->of(studentAssesment::where('id_number', $id_number)
                ->where('semester', $latestSemester)->orderBy('semester', 'desc')
                ->get())


                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function getFeeSummariesOnIdnumber(Request $request, $id_number)
    {
        // dd($id_number);
        $table = fee_summary::with('studentAssessment')->where('id_number', $id_number)
            ->get();

        // dd($table);
        if (request()->ajax()) {
            return datatables()->of($table)
                ->addColumn('created_at', function ($row) {

                    return $row->created_at->format('Y-m-d');
                })
                ->addColumn('discount', function ($row) {

                    return $row->studentAssessment?->discount?->discount_target;
                })
                ->addColumn('discountAmount', function ($row) {

                    return $row->studentAssessment?->discountCompute;
                })
                ->addColumn('discountMiscFee', function ($row) {

                    return $row->studentAssessment?->discountComputeMiscFee;
                })
                ->addColumn('department', function ($row) {
                    return $row->create_account?->department?->code;
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function getNewBreakDown(Request $request, $id_number)
    {
        $latestSemester = studentAssesment::where('id_number', $id_number)
            ->max('semester');

        $data = studentAssesment::select(
            'downpayment',
            'prelims',
            'midterms',
            'semi_finals',
            'finals',
            'total_assessment'
        )
            ->where('id_number', $id_number)
            ->where('semester', $latestSemester)

            ->distinct()

            ->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
