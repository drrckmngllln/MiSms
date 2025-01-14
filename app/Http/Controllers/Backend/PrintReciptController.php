<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CreateAccount;
use App\Models\FeeCollectionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberToWords\NumberToWords;
use Illuminate\Support\Str;


class PrintReciptController extends Controller
{
    //
    public function printrecipt(Request $request, $id)
    {

        $scholarship = $request->scholarship;
        $selectedFees = $request->selectedFees ? explode(',', $request->selectedFees) : [];


        $student = CreateAccount::with([
            'fee_summary',
            'fee_collection' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'studentSubjectss',
            'student_assestment',
        ])->find($id);
        $feeCollectionHistory = collect();
        $FeeCollection = collect();

        $totalAssessment = $student->student_assestment?->total_assessment;
        $FullPayment = $totalAssessment == 0 ? "FULL PAYMENT" : '';

        if (!empty($selectedFees)) {
            $feeCollectionHistory = FeeCollectionHistory::whereIn('other_fees_id', $selectedFees)
                ->where('id_number', $student->id_number)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {

            $FeeCollection = $student->fee_collection
                ->groupBy('subCategory')
                ->map(function ($group) {
                    return $group->sortByDesc('created_at')->first();
                })
                ->filter(function ($item) {
                    return $item->amount_subtracted !== "0.00" && $item->other_fees_id === null;
                })
                ->values();
        }
        $fees = !empty($selectedFees) ? $feeCollectionHistory : $FeeCollection;

        $studentData = [
            'id' => $student->id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'home_address' => $student->home_address,
            'downpayment' => $student?->fee_summary?->downpayment,
            'or_number' => $student?->fee_summary?->or_number,
            'created_at' => $student?->fee_summary?->created_at->format('d-m-y'),
            'downpaymentNumber' => $student?->fee_summary?->downpayment,
            'remainingBalance' => $student?->student_assestment?->total_assessment,
            'excess' => $student?->fee_summary?->excess,
            'downpayment2' => $student?->fee_summary?->downpayment2,
            'scholarship' => $scholarship,
            'particulars' => $student->fee_summary?->particulars,
            // 'computationformiscfeeandotherfee' => $student?->student_assestment?->first()->computation,
            // dd($student?->student_assestment?->first()->computation);
            // 'collection' => $isFullPayment,
            'fees' => $fees,
            'PaymenentStatus' => $FullPayment,
        ];
        // dd($studentData);
        $numericValue = $studentData['downpayment'];
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $paymentNumberToWords = $numberTransformer->toWords($numericValue);
        $capitalizedWords = Str::ucfirst($paymentNumberToWords);




        return view('Roles.Super_Administrator.fee_collection.printrecipt', compact('student', 'studentData', 'capitalizedWords'));
    }
    public function printreciptnonassessed(Request $request, $id)
    {
        // dd($request->all());
        $student = CreateAccount::with(['fee_summary', 'studentSubjectss', 'student_assestment', 'nonassessed'])
            ->find($id);
        $studentData = [
            'id' => $student->id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'home_address' => $student->home_address,
            'amount' => $student?->nonassessed?->payable,
            'particulars' => $student?->nonassessed?->particulars,
            'or_number' => $student?->fee_summary?->or_number,
            'created_at' => $student?->fee_summary?->created_at->format('d-m-y'),
            'downpaymentNumber' => $student?->fee_summary?->downpayment,
            'remainingBalance' => $student?->student_assestment?->total_assessment,
            'excess' => $student?->fee_summary?->excess,
            'downpayment2' => $student?->fee_summary?->downpayment2,

            // 'computationformiscfeeandotherfee' => $student?->student_assestment?->first()->computation,
            // dd($student?->student_assestment?->first()->computation);

        ];
        // dd($studentData);
        $numericValue = $studentData['amount'];
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $paymentNumberToWords = $numberTransformer->toWords($numericValue);
        $capitalizedWords = Str::ucfirst($paymentNumberToWords);



        // dd($studentData);
        return view('Roles.Super_Administrator.nonassessed.printrecipt', compact('student', 'studentData', 'capitalizedWords'));
    }
}
