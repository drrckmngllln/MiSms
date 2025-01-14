<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CreateAccount;
use App\Models\fee_summary;
use App\Models\studentAssesment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class StatementofAccountController extends Controller
{
    //
    public function soa()
    {
        $Students = CreateAccount::all();

        return view('Roles.Super_Administrator.SOA.index', compact('Students'));
    }
    public function getFeeSummaries()
    {

        if (request()->ajax()) {
            return datatables()->of(fee_summary::with('studentAssessment')->get())
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->addColumn('last_name', function ($row) {
                    return $row->create_account?->last_name;
                })
                ->addColumn('first_name', function ($row) {
                    return $row->create_account?->first_name;
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
    public function getTotalAssessment(Request $request, $id_number)
    {
        $query = studentAssesment::select('id_number', 'school_year', 'total_assessment', 'created_at', 'or_number', 'totalAss')
            ->where('id_number', $id_number)
            ->groupBy(['school_year', 'id_number', 'total_assessment', 'created_at', 'or_number', 'totalAss'])
            ->orderBy('created_at', 'asc')
            ->get();

        $feeSummaries = fee_summary::where('id_number', $id_number)
            ->orderBy('date', 'asc')
            ->get();

        $result = [];
        $addedSchoolYears = [];

        if (count($query)) {
            foreach ($query as $q) {
                $schoolYearId = $q->sy?->code;


                if (in_array($schoolYearId, $addedSchoolYears)) {
                    continue;
                }

                $tableData = [];
                $totalAss = $q->totalAss;
                $currentBalance = $totalAss;

                $tableData[] = [
                    'date' => $q->created_at->format('m/d/Y'),
                    'transaction' => 'Assessment',
                    'doc_no' => $q->or_number,
                    'debit' => $totalAss,
                    'credit' => '',
                    'balance' => $currentBalance,
                ];

                foreach ($feeSummaries->where('school_year', $q->school_year)->where('id_number', $id_number) as $fee) {
                    $currentBalance -= $fee->downpayment;
                    $tableData[] = [
                        'date' => Carbon::createFromFormat('Y-m-d', $fee->date)->format('m/d/Y'),
                        'transaction' => $fee->type,
                        'doc_no' => $fee->or_number,
                        'debit' => '',
                        'credit' => '-' . $fee->downpayment,
                        'balance' => $currentBalance . '.00',
                    ];
                }

                $result[] = [
                    'school_year_id' => $schoolYearId,
                    'tableData' => $tableData,
                ];

                // Idagdag ang schoolYearId sa listahan ng mga nadagdag na school years
                $addedSchoolYears[] = $schoolYearId;
            }
        }

        return response()->json($result);
    }
}