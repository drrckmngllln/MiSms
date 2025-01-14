<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\cashierlogs;
use App\Models\CreateAccount;
use App\Models\CreateAccountHighSchool;
use App\Models\fee_summary;
use App\Models\FeeCollectionHistory;
use App\Models\studentAssesment;
use App\Models\studentDiscount;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeSummaries extends Controller
{
    //
    public function feesummaries(Request $request)
    {
        // 
        $downpayment = $request->input('downpayment');
        $payable = $request->input('payable');
        $remainingAmounts = $payable;
        $newTotalAss = $request->input('total_assessment') - $downpayment;
        $selectedFees = $request->selected_fees;
        $selectedFeesArray = !empty($selectedFees) ? explode(',', $selectedFees) : [];
        $type = $request->scholarship === 'on' ? 'Scholarship/'  . $request->particulars : 'Receipt';
        if ($downpayment > $payable) {
            $downpayment = $payable;
        }

        $studentFeeSummaries = new fee_summary([
            'or_number' => $request->input('or_number'),
            'particulars' => $request->input('particulars'),
            'id_number' => $request->input('id_number'),
            'downpayment' => $downpayment,
            'total_assessment' => $newTotalAss,
            'cahier_in_charge' => $request->input('cahier_in_charge'),
            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'excess' => $request->input('excess'),
            'downpayment2' => $request->input('downpayment2'),
            'type' => $type,
            'school_year' => $request->school_year,
        ]);

        $studentCahierlogs = new cashierlogs([
            ...$request->only([
                'name',
                'or_number',
                'particulars',
                'school_year',
                'department',
                'credit',
                'debit',
                'balance'
            ])
        ]);


        $studentFeeSummaries->save();
        $studentCahierlogs->save();

        //naka base siya sa id_number 
        $createAccount = CreateAccount::where('id_number', $request->id_number)->first();
        if ($createAccount) {
            $createAccount->update(['status' => 'OFFICIALLY ENROLLED']);
        }
        $createAccountHS = CreateAccountHighSchool::where('id_number', $request->id_number)->first();
        if ($createAccountHS) {
            $createAccountHS->update(['status' => 'OFFICIALLY ENROLLED']);
        }
        $idNumber = $request->input('id_number');
        $or_number = $request->input('or_number');
        // dd($or_number);

        $latestSemester = studentAssesment::where('id_number', $idNumber)
            ->max('semester');

        $newDownpayment = 0;
        $subtractAmount = 0;
        $newPrelims = 0;
        $newMidterms = 0;
        $newSemi_finals = 0;
        $newFinals = 0;
        if (!empty($selectedFeesArray)) {
            $studentFeeSummaries2 = studentAssesment::where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('semester', 'desc')
                ->get();


            // dd($studentFeeSummaries2);
            if ($studentFeeSummaries2->isNotEmpty()) {
                $subtractAmount = $request->input('downpayment');
                $payableAmount = $request->input('payable');
                $collectAll = $request->input('collect_all');
                $exessAmount = 0;

                $studentFeeSummaries2->each(function ($summary) use ($subtractAmount, &$exessAmount, &$PRELIMS, &$payableAmount, &$newDownpayment, &$newPrelims,  &$newMidterms, &$newSemi_finals, &$newFinals, &$newTotalAssestment, &$selectedFeesArray, $request) {

                    $currentComputation2Tuition = $summary->computation2Tuition;
                    $amountToDeduct = min($subtractAmount, $currentComputation2Tuition);

                    $newComputation2Tuition = max($currentComputation2Tuition - $amountToDeduct, 0);

                    if (in_array($summary->otherFees_id, $selectedFeesArray)) {
                        $summary->update(['computation2Tuition' => $newComputation2Tuition]);

                        $exessAmount = max($subtractAmount - $amountToDeduct, 0);

                        FeeCollectionHistory::create([
                            'id_number' => $summary->id_number,
                            'or_number' => $request->or_number,
                            'category' => $summary->category,
                            'subCategory' => $summary->fee_type,
                            'amount_subtracted' => $amountToDeduct,
                            'other_fees_id' =>  $summary->otherFees_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    $currentDownpayment = $summary->downpayment;
                    $currentTotal = $summary->total_assessment;


                    $newDownpayment = $summary->downpayment;
                    $newPrelims = $summary->prelims;
                    $newMidterms = $summary->midterms;
                    $newSemi_finals =  $summary->semi_finals;
                    $newFinals = $summary->finals;
                    $newTotalAssestment = $summary->total_assessment;
                    // dd($newTotalAssestment);


                    $exessAmount = max($subtractAmount - $currentDownpayment, 0);
                    // dd($exessAmount);
                    $newDownpayment = max($currentDownpayment - $subtractAmount, 0);
                    // dd($exessAmount);
                    $PaymentFields = ['prelims', 'midterms', 'semi_finals', 'finals', 'total_assessment'];

                    if ($subtractAmount > $payableAmount) {
                        $newTotalAssestment = max($currentTotal - $payableAmount, 0);
                        if ($summary->downpayment > 0) {
                            $amountDown = min($payableAmount, $summary->downpayment);
                            $newDownpayment = max($summary->downpayment - $amountDown, 0);
                            $summary->update(['downpayment' => $newDownpayment]);
                        } elseif ($summary->prelims > 0) {
                            $amountPrelims = min($payableAmount, $summary->prelims);
                            $newPrelims = max($summary->prelims - $amountPrelims, 0);
                            $summary->update(['prelims' => $newPrelims]);
                            $exessAmount -= $amountPrelims;
                        } else if ($summary->midterms > 0) {
                            $amountMidterms = min($payableAmount, $summary->midterms);
                            $newMidterms = max($summary->midterms - $amountMidterms, 0);
                            $summary->update(['midterms' => $newMidterms]);
                            $exessAmount -= $amountMidterms;
                        } else if ($summary->semi_finals > 0) {
                            $amountSemis = min($payableAmount, $summary->semi_finals);
                            $newSemi_finals = max($summary->semi_finals - $amountSemis, 0);
                            $summary->update(['semi_finals' => $newSemi_finals]);
                            $exessAmount -= $amountSemis;
                        } else if ($summary->finals > 0) {
                            $amountFinals = min($payableAmount, $summary->finals);
                            $newFinals = max($summary->finals - $amountFinals, 0);
                            $summary->update(['finals' => $newFinals]);
                            $exessAmount -= $amountFinals;
                        }
                    } else {
                        foreach ($PaymentFields as $field) {
                            //Deduct exess Amount   
                            $currentValue = $summary->{$field};
                            $excessAmountForField = min($exessAmount, $currentValue);
                            $newValue = max($currentValue - $excessAmountForField, 0);
                            $summary->update([$field => $newValue]);
                            ${'new' . ucwords($field)} = $newValue;
                            $exessAmount -= $excessAmountForField;
                            // dd(${'new' . ucwords($field)});
                            $newTotalAssestment = max($currentTotal - $subtractAmount, 0);
                        }
                    }
                    $summary->update([
                        'downpayment' => $newDownpayment,
                        'prelims' => $newPrelims,
                        'midterms' => $newMidterms,
                        'semi_finals' => $newSemi_finals,
                        'finals' => $newFinals,
                        'total_assessment' => $newTotalAssestment,
                    ]);

                    //downpayment subtract to total assestment
                });


                return response(['status' => 'success', 'message' => 'Success', 'data' => [
                    'newDownpayment' => $newDownpayment,
                    'newPrelims' => $newPrelims,
                    'newMidterms' => $newMidterms,
                    'newSemis' => $newSemi_finals,
                    'newFinals' => $newFinals,
                    'PRELIMS' => $PRELIMS,
                    'newTotalAssestment' => $newTotalAssestment,

                    'exessAmount' => $exessAmount,
                ]]);
            }
        } else {
            $studentFeeSummaries = studentAssesment::where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('semester', 'desc')
                ->get();
            $deductions = new Collection();
            $totalAmount = $payable;

            $tuitionTotal = studentAssesment::where('category', 'Tuition Fees')
                ->where('id_number', $idNumber)
                ->sum('computation2Tuition');

            $labTotal = studentAssesment::where('category', 'Laboratory Fees')
                ->where('id_number', $idNumber)
                ->sum('computation2Tuition');

            $miscTotal = studentAssesment::where('category', 'Miscellaneous Fee')
                ->where('id_number', $idNumber)
                ->sum('computation2Tuition');

            $otherTotal = studentAssesment::whereNotIn('category', ['Tuition Fees', 'Laboratory Fees', 'Miscellaneous Fee'])
                ->where('id_number', $idNumber)
                ->sum('computation2Tuition');


            $totalCategoryAmount = $tuitionTotal + $labTotal + $miscTotal + $otherTotal;


            $tuitionPercentage = $tuitionTotal / $totalCategoryAmount * 100;
            $labPercentage = $labTotal / $totalCategoryAmount * 100;
            $miscPercentage = $miscTotal / $totalCategoryAmount * 100;
            $otherPercentage = 100 - ($tuitionPercentage + $labPercentage + $miscPercentage);


            $tuitionFeeAmount = $totalAmount * ($tuitionPercentage / 100);
            $labFeeAmount = $totalAmount * ($labPercentage / 100);
            $miscFeeAmount = $totalAmount * ($miscPercentage / 100);
            $otherFeeAmount = $totalAmount * ($otherPercentage / 100);


            $decimalRemainingBalance = 9.0;

            $tuitionFees = studentAssesment::where('category', 'Tuition Fees')
                ->where('id_number', $idNumber)
                ->orderBy('computation', 'asc')
                ->get();

            $remainingTuitionAmount = $tuitionFeeAmount;
            $totalTuitionFees = 0;

            foreach ($tuitionFees as $fee) {
                if ($remainingTuitionAmount == 0) break;
                $amountSubtracted = min($remainingTuitionAmount, $fee->computation2Tuition);
                $remainingTuitionAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;
                $totalTuitionFees += $amountSubtracted;

                if (abs($fee->computation2Tuition) < $decimalRemainingBalance) {
                    $fee->computation2Tuition = 0;
                }
                $fee->save();
            }

            foreach ($tuitionFees as $fee) {
                if ($remainingTuitionAmount == 0) break;
                $amountSubtracted = min($remainingTuitionAmount, $fee->computation2Tuition);
                $remainingTuitionAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;
                $totalTuitionFees += $amountSubtracted;
                $fee->save();
            }

            if ($totalTuitionFees > 0) {
                $tuitionFees = DB::table('student_assesments')
                    ->where('id_number', $idNumber)
                    ->where('category', 'Tuition Fees')
                    ->get(['fee_type', 'id_number', 'school_year', 'semester']);

                foreach ($tuitionFees as $fee) {
                    $deductions->push([
                        'id_number' => $fee->id_number,
                        'or_number' => $or_number,
                        'category' => 'Tuition Fees',
                        'fee_type' => $fee->fee_type,
                        'AmountSubtract' => $totalTuitionFees,
                    ]);
                }
            }

            // Laboratory Fees Deduction
            $labFees = studentAssesment::where('category', 'Laboratory Fees')
                ->where('id_number', $idNumber)
                ->orderBy('computation', 'asc')
                ->get();

            $remainingLabAmount = $labFeeAmount;
            $totalLabFeeDeduction = 0;
            foreach ($labFees as $fee) {
                if ($remainingLabAmount == 0) break;
                $amountSubtracted = min($remainingLabAmount, $fee->computation2Tuition);
                $remainingLabAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;
                $totalLabFeeDeduction += $amountSubtracted;
                $fee->save();

                $deductions->push([
                    'id_number' => $idNumber,
                    'or_number' => $or_number,
                    'category' => 'Laboratory Fees',
                    'fee_type' => $fee->fee_type,
                    'AmountSubtract' => $amountSubtracted,
                ]);
            }

            // Miscellaneous Fees Deduction
            $miscFees = studentAssesment::where('category', 'Miscellaneous Fee')
                ->where('id_number', $idNumber)
                ->orderBy('computation', 'asc')
                ->get();

            $remainingMiscAmount = $miscFeeAmount;
            $totalMiscFeeDeduction = 0;
            foreach ($miscFees as $fee) {
                if ($remainingMiscAmount == 0) break;
                $amountSubtracted = min($remainingMiscAmount, $fee->computation2Tuition);
                $remainingMiscAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;
                $totalMiscFeeDeduction += $amountSubtracted;
                $fee->save();

                $deductions->push([
                    'id_number' => $idNumber,
                    'or_number' => $or_number,
                    'category' => 'Miscellaneous Fee',
                    'fee_type' => $fee->fee_type,
                    'AmountSubtract' => $amountSubtracted,
                ]);
            }

            // Other Fees Deduction
            $otherFees = studentAssesment::whereNotIn('category', ['Tuition Fees', 'Laboratory Fees', 'Miscellaneous Fee'])
                ->where('id_number', $idNumber)
                ->orderBy('computation', 'asc')
                ->get();

            $remainingOtherAmount = $otherFeeAmount;
            $totalOtherFeeDeduction = 0;
            foreach ($otherFees as $fee) {
                if ($remainingOtherAmount == 0) break;
                $amountSubtracted = min($remainingOtherAmount, $fee->computation2Tuition);
                $remainingOtherAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;
                $totalOtherFeeDeduction += $amountSubtracted;
                $fee->save();

                $deductions->push([
                    'id_number' => $idNumber,
                    'or_number' => $or_number,
                    'category' => 'Other Fees',
                    'fee_type' => $fee->fee_type,
                    'AmountSubtract' => $amountSubtracted,
                ]);
            }


            foreach ($deductions as $deduction) {
                // dd($deduction);
                FeeCollectionHistory::create([
                    'id_number' => $deduction['id_number'],
                    'or_number' => $deduction['or_number'],
                    'category' => $deduction['category'],
                    'subCategory' => $deduction['fee_type'],
                    'amount_subtracted' => $deduction['AmountSubtract'],
                ]);
            }

            if ($studentFeeSummaries->isNotEmpty()) {

                $subtractAmount = $request->input('downpayment');
                $payableAmount = $request->input('payable');
                $collectAll = $request->input('collect_all');
                $exessAmount = 0;

                //subtract natin yung amount
                // dd($subtractAmount);
                $studentFeeSummaries->each(function ($summary) use ($subtractAmount, &$exessAmount, &$PRELIMS, &$payableAmount, &$newDownpayment, &$newPrelims,  &$newMidterms, &$newSemi_finals, &$newFinals, &$newTotalAssestment) {

                    $currentDownpayment = $summary->downpayment;
                    $currentTotal = $summary->total_assessment;


                    $newDownpayment = $summary->downpayment;
                    $newPrelims = $summary->prelims;
                    $newMidterms = $summary->midterms;
                    $newSemi_finals =  $summary->semi_finals;
                    $newFinals = $summary->finals;
                    $newTotalAssestment = $summary->total_assessment;
                    // dd($newTotalAssestment);


                    $exessAmount = max($subtractAmount - $currentDownpayment, 0);
                    // dd($exessAmount);
                    $newDownpayment = max($currentDownpayment - $subtractAmount, 0);
                    // dd($exessAmount);
                    $PaymentFields = ['prelims', 'midterms', 'semi_finals', 'finals', 'total_assessment'];

                    if ($subtractAmount > $payableAmount) {
                        $newTotalAssestment = max($currentTotal - $payableAmount, 0);
                        if ($summary->downpayment > 0) {
                            $amountDown = min($payableAmount, $summary->downpayment);
                            $newDownpayment = max($summary->downpayment - $amountDown, 0);
                            $summary->update(['downpayment' => $newDownpayment]);
                        } elseif ($summary->prelims > 0) {
                            $amountPrelims = min($payableAmount, $summary->prelims);
                            $newPrelims = max($summary->prelims - $amountPrelims, 0);
                            $summary->update(['prelims' => $newPrelims]);
                            $exessAmount -= $amountPrelims;
                        } else if ($summary->midterms > 0) {
                            $amountMidterms = min($payableAmount, $summary->midterms);
                            $newMidterms = max($summary->midterms - $amountMidterms, 0);
                            $summary->update(['midterms' => $newMidterms]);
                            $exessAmount -= $amountMidterms;
                        } else if ($summary->semi_finals > 0) {
                            $amountSemis = min($payableAmount, $summary->semi_finals);
                            $newSemi_finals = max($summary->semi_finals - $amountSemis, 0);
                            $summary->update(['semi_finals' => $newSemi_finals]);
                            $exessAmount -= $amountSemis;
                        } else if ($summary->finals > 0) {
                            $amountFinals = min($payableAmount, $summary->finals);
                            $newFinals = max($summary->finals - $amountFinals, 0);
                            $summary->update(['finals' => $newFinals]);
                            $exessAmount -= $amountFinals;
                        }
                    } else {
                        foreach ($PaymentFields as $field) {
                            //Deduct exess Amount   
                            $currentValue = $summary->{$field};
                            $excessAmountForField = min($exessAmount, $currentValue);
                            $newValue = max($currentValue - $excessAmountForField, 0);
                            $summary->update([$field => $newValue]);
                            ${'new' . ucwords($field)} = $newValue;
                            $exessAmount -= $excessAmountForField;
                            // dd(${'new' . ucwords($field)});
                            $newTotalAssestment = max($currentTotal - $subtractAmount, 0);
                        }
                    }
                    //downpayment subtract to total assestment
                    $summary->update([
                        'downpayment' => $newDownpayment,
                        'prelims' => $newPrelims,
                        'midterms' => $newMidterms,
                        'semi_finals' => $newSemi_finals,
                        'finals' => $newFinals,
                        'total_assessment' => $newTotalAssestment,
                    ]);
                });

                return response(['status' => 'success', 'message' => 'Success', 'data' => [
                    'newDownpayment' => $newDownpayment,
                    'newPrelims' => $newPrelims,
                    'newMidterms' => $newMidterms,
                    'newSemis' => $newSemi_finals,
                    'newFinals' => $newFinals,
                    'PRELIMS' => $PRELIMS,
                    'newTotalAssestment' => $newTotalAssestment,

                    'exessAmount' => $exessAmount,
                ]]);
            }
        }

        //Tuition Fee
        //Tuition Fee (20%)
        $date = $request->input('date');
    }
    public function fee_summaries_all()
    {
        if (request()->ajax()) {
            return datatables()->of(fee_summary::where('is_locked', false)
                ->select('created_at', 'particulars', 'or_number', 'id_number', 'downpayment', 'total_assessment')
                ->get())


                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
