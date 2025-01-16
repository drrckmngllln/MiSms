<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\DiscountHelper;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\CreateAccount;
use App\Models\StudentSubject;
use GuzzleHttp\Promise\Create;
use App\Models\studentAssesment;
use Maatwebsite\Excel\Files\Disk;
use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\StudentSelectDiscount;
use App\Models\TuitionFee;
use Yajra\DataTables\Facades\DataTables;

class StudentDiscount extends Controller
{
    //
    public function studentDiscountIndex()
    {
        $schoolYear = SchoolYear::all();
        return view('Roles.Super_Administrator.studentDiscount.index', compact('schoolYear'));
    }
    public function getStudents(Request $request)
    {


        if ($request->ajax()) {
            $data = CreateAccount::select('id_number', 'last_name', 'first_name')->get();

            return DataTables::of($data)->toJson();
        }
    }
    public function selectStudents(Request $request)
    {

        if (request()->ajax()) {
            return datatables()->of(Discount::select('id', 'code', 'discount_target', 'description', 'discount_percentage', 'discount_type', 'discount_code')->get())
                ->addColumn('action', function ($query) {
                    // Create button HTML for DataTable action column
                    // $inputField = '<input type="text" class="form-control" id="or_number_id' . $query->id . '" placeholder="OR Number">';
                    $addbtn = '<button type="button" class="btn btn-success" onclick="saveDiscount(' . $query->id . ',\'' . $query->code . '\', \'' . $query->discount_target . '\', \'' . $query->description . '\', 
                    \'' . $query->discount_percentage . '\',\'' . $query->discount_type . '\',
                    \'' . $query->discount_code . '\')">+</button>';
                    return $addbtn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function saveStudentDiscount(Request $request)
    {

        DiscountHelper::applyDiscount($request);
        return response(['status' => 'success', 'message' => 'Discount saved successfully']);
    }
    public function getStudentsDiscount(Request $request)
    {

        if (request()->ajax()) {
            return datatables()->of(StudentSelectDiscount::select('id', 'id_number', 'code', 'discount_target', 'description', 'discount_percentage', 'school_year', 'semester')->get())
                ->addColumn('action', function ($query) {

                    $deleteBtn = '<form action="' . route('superadmin.deleteSaved.Discount', $query->id) . '" method="POST">';
                    $deleteBtn .= csrf_field();
                    $deleteBtn .= method_field('DELETE');
                    $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                    $deleteBtn .= '</form>';

                    return $deleteBtn;
                })
                ->addColumn('school_year', function ($query) {
                    return $query?->schoolyear?->code;
                })
                ->rawColumns(['action'])
                ->setRowId('id')
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function deleteDiscount($id)
    {
        $createaccount = StudentSelectDiscount::findOrFail($id);
        $discountTarget = $createaccount->discount_target;

        // dd($createaccount);

        switch ($discountTarget) {
            case 'Tuition Fee 100%':
            case 'Tuition Fee 100% / Misc Fee 100%':
            case '35% Discount Crim/Ca':
            case 'cash 3%':
            case '5% Discount Tuition Fee Only':
            case '10% Discount Tuition Fee Only':
            case '100% Discount on Tuition Fee ORPHANS':
            case '25% Discount on Tuition Fee SK CHAIRMAN':
            case '2000 Discount TOP 6-10':
            case '500 Discount Average 85% and ABOVE':
            case '100% MCNP-ISAP SCHOLAR/GRANTEES':
            case 'Tuition Fee 80%/Misc Fee 100%':


                // Code for 100% discount
                $totalAssessment = studentAssesment::where('id_number', $createaccount->id_number)
                    ->where('school_year', $createaccount->school_year)
                    ->where('semester', $createaccount->semester)
                    ->whereNot('fee_type', $createaccount->description)
                    ->sum('computation');
                $studentDiscount = studentAssesment::where('id_number', $createaccount->id_number)
                    ->where('school_year', $createaccount->school_year)
                    ->where('semester', $createaccount->semester)
                    ->where('fee_type', $createaccount->description)
                    ->first();

                // dd($totalAssessment);
                $computation = $studentDiscount->lecture_units * $studentDiscount->amount;

                $studentDiscount->computation = $computation;
                $studentDiscount->discount_id = 0;

                $totalAssessment += $computation;
                $perSem = $totalAssessment / 5;
                $studentDiscount->save();

                $discountColumn = ['discount_id'];

                $columnsToStore = [
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals',
                ];
                studentAssesment::where('id_number', $createaccount->id_number)
                    ->where('school_year', $createaccount->school_year)
                    ->update([
                        'total_assessment' => $totalAssessment,
                        ...array_fill_keys($columnsToStore, $perSem),
                        'discount_id' =>  $studentDiscount->discount_id = 0,
                        ...array_fill_keys($discountColumn, $studentDiscount->discount_id = 0),
                        'discountCompute' => 0,
                    ]);

                $createaccount->delete();
                break;
            case 'Tuition Fee 50%':
                // Code for 50% discount
                $totalAssessment = studentAssesment::where('id_number', $createaccount->id_number)
                    ->where('school_year', $createaccount->school_year)
                    ->whereNot('fee_type', $createaccount->description)
                    ->sum('computation');
                $studentDiscount = studentAssesment::where('id_number', $createaccount->id_number)
                    ->where('school_year', $createaccount->school_year)
                    ->where('fee_type', $createaccount->description)
                    ->first();
                $computation = $studentDiscount->lecture_units * $studentDiscount->amount;
                // dd($computation);
                $studentDiscount->computation = $computation;
                $studentDiscount->discount_id = 0;
                $totalAssessment += $computation;
                $perSem = $totalAssessment / 5;
                $studentDiscount->save();
                $discountColumn = ['discount_id'];

                $columnsToStore = [
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];
                studentAssesment::where('id_number', $createaccount->id_number)
                    ->where('school_year', $createaccount->school_year)
                    ->update([
                        'total_assessment' => $totalAssessment,
                        ...array_fill_keys($columnsToStore, $perSem),
                        'discount_id' =>  $studentDiscount->discount_id = 0,
                        ...array_fill_keys($discountColumn, $studentDiscount->discount_id = 0),
                        'discountCompute' => 0,

                    ]);
                $createaccount->delete();
                break;


            default:
                break;
        }

        return response(['status' => 'success', 'message' => 'Student Account Deleted Successfully']);
    }
}
