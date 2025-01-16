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
use Termwind\Components\Dd;

class FeeSummaries extends Controller
{
    //
    public function feesummaries(Request $request)
    {

        $downpayment = $request->input('payment2hidden');
        $payable = $request->input('downpayment22');
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
            'department_id' => $request->department_id,
            'role_name_id' => $request->role_name_id,
            'campus_id' => $request->campus_id,
            'payment_status' => $request->payment_status,
            'check_no' => $request->check_no,

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
                ->orderBy('created_at', 'desc')
                ->get();


            // dd($studentFeeSummaries2);
            // dd($studentFeeSummaries2);
            if ($studentFeeSummaries2->isNotEmpty()) {

                $subtractAmount = $request->input('payment2hidden');
                $payableAmount = $request->input('downpayment22');
                $collectAll = $request->input('collect_all');
                $exessAmount = 0;

                $studentFeeSummaries2->each(function ($summary) use (
                    $subtractAmount,
                    &$exessAmount,
                    &$PRELIMS,
                    &$payableAmount,
                    &$newDownpayment,
                    &$newPrelims,
                    &$newMidterms,
                    &$newSemi_finals,
                    &$newFinals,
                    &$newTotalAssestment,
                    &$selectedFeesArray,
                    $request
                ) {
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
                            'other_fees_id' => $summary->otherFees_id,
                            'year_level' => $request->year_level,
                            'campus_id' => $request->campus_id,
                            'course_id' => $request->course_id,
                            'department_id' => $request->department_id,
                            'role_name_id' => $request->role_name_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    $currentDownpayment = $summary->downpayment;
                    $currentTotal = $summary->total_assessment;

                    $newDownpayment = $summary->downpayment;
                    $newPrelims = $summary->prelims;
                    $newMidterms = $summary->midterms;
                    $newSemi_finals = $summary->semi_finals;
                    $newFinals = $summary->finals;
                    $newTotalAssestment = $summary->total_assessment;

                    $exessAmount = max($subtractAmount - $currentDownpayment, 0);
                    $newDownpayment = max($currentDownpayment - $subtractAmount, 0);

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
                        } elseif ($summary->midterms > 0) {
                            $amountMidterms = min($payableAmount, $summary->midterms);
                            $newMidterms = max($summary->midterms - $amountMidterms, 0);
                            $summary->update(['midterms' => $newMidterms]);
                            $exessAmount -= $amountMidterms;
                        } elseif ($summary->semi_finals > 0) {
                            $amountSemis = min($payableAmount, $summary->semi_finals);
                            $newSemi_finals = max($summary->semi_finals - $amountSemis, 0);
                            $summary->update(['semi_finals' => $newSemi_finals]);
                            $exessAmount -= $amountSemis;
                        } elseif ($summary->finals > 0) {
                            $amountFinals = min($payableAmount, $summary->finals);
                            $newFinals = max($summary->finals - $amountFinals, 0);
                            $summary->update(['finals' => $newFinals]);
                            $exessAmount -= $amountFinals;
                        }
                    } else {
                        foreach ($PaymentFields as $field) {
                            $currentValue = $summary->{$field};
                            $excessAmountForField = min($exessAmount, $currentValue);
                            $newValue = max($currentValue - $excessAmountForField, 0);
                            $summary->update([$field => $newValue]);
                            ${'new' . ucwords($field)} = $newValue;
                            $exessAmount -= $excessAmountForField;
                            $newTotalAssestment = max($currentTotal - $subtractAmount, 0);
                        }
                    }

                    $kahitano = $newTotalAssestment / 5;
                    // dd($kahitano);
                    $columns = [
                        'downpayment',
                        'prelims',
                        'midterms',
                        'semi_finals',
                        'finals',
                        'sdownpayment',
                        'sprelims',
                        'smidterms',
                        'ssemi_finals',
                        'sfinals'
                    ];

                    $summary->update([
                        'downpayment' => $newDownpayment,
                        'prelims' => $newPrelims,
                        'midterms' => $newMidterms,
                        'semi_finals' => $newSemi_finals,
                        'finals' => $newFinals,
                        'total_assessment' => abs($subtractAmount -  $summary->total_assessment),
                        'stotal_assessment' => abs($subtractAmount -  $summary->total_assessment),
                        ...array_fill_keys($columns, $kahitano),
                    ]);


                    return response([
                        'status' => 'success',
                        'message' => 'Success',
                        'data' => [
                            'newDownpayment' => $newDownpayment,
                            'newPrelims' => $newPrelims,
                            'newMidterms' => $newMidterms,
                            'newSemis' => $newSemi_finals,
                            'newFinals' => $newFinals,
                            'PRELIMS' => $PRELIMS,
                            'newTotalAssestment' => $newTotalAssestment,
                            'exessAmount' => $exessAmount,
                        ]
                    ]);
                });
            }
        } else {
            $studentFeeSummaries = studentAssesment::where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->get();
            // dd($studentFeeSummaries);
            $deductions = new Collection();

            // Calculate the total payable amount for the student
            $totalAmount = $payable;

            // Sum up the total fee amounts for each category
            $tuitionTotal = studentAssesment::where('category', 'Tuition Fees')
                ->where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->sum('computation2Tuition');

            $labTotal = studentAssesment::where('category', 'Laboratory Fees')
                ->where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->sum('computation2Tuition');

            $miscTotal = studentAssesment::where('category', 'Miscellaneous Fee')
                ->where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->sum('computation2Tuition');

            $otherTotal = studentAssesment::whereNotIn('category', ['Tuition Fees', 'Laboratory Fees', 'Miscellaneous Fee'])
                ->where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->sum('computation2Tuition');
            $totalCategoryAmount = $tuitionTotal + $labTotal + $miscTotal + $otherTotal;
            $tuitionPercentage = $tuitionTotal > 0 ? ($tuitionTotal / $totalCategoryAmount * 100) : 0;
            $labPercentage = $labTotal > 0 ? ($labTotal / $totalCategoryAmount * 100) : 0;
            $miscPercentage = $miscTotal > 0 ? ($miscTotal / $totalCategoryAmount * 100) : 0;
            $otherPercentage = 100 - ($tuitionPercentage + $labPercentage + $miscPercentage);
            $tuitionFeeAmount = round($totalAmount * ($tuitionPercentage / 100), 2);
            $labFeeAmount = round($totalAmount * ($labPercentage / 100), 2);
            $miscFeeAmount = round($totalAmount * ($miscPercentage / 100), 2);

            $otherFeeAmount = $totalAmount - ($tuitionFeeAmount + $labFeeAmount + $miscFeeAmount);

            $otherFeeAmount = round($otherFeeAmount, 2);


            $remainingTuitionAmount = $tuitionFeeAmount;
            $tuitionFees = studentAssesment::where('category', 'Tuition Fees')
                ->where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->latest('semester')
                ->orderBy('computation2Tuition', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            foreach ($tuitionFees as $fee) {
                if ($remainingTuitionAmount <= 0) break;
                $amountSubtracted = min($remainingTuitionAmount, $fee->computation2Tuition);
                $remainingTuitionAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;

                // Save the deduction to collection
                $deductions->push([
                    'id_number' => $fee->id_number,
                    'or_number' => $or_number,
                    'category' => 'Tuition Fees',
                    'fee_type' => $fee->fee_type,
                    'AmountSubtract' => $amountSubtracted,
                    'year_level' => $request->year_level,
                    'campus_id' => $request->campus_id,
                    'course_id' => $request->course_id,
                    'department_id' => $request->department_id,
                    'role_name_id' => $request->role_name_id,
                ]);
                $fee->save();
            }
            // Process the laboratory fees
            $remainingLabAmount = $labFeeAmount;
            $labFees = studentAssesment::where('category', 'Laboratory Fees')
                ->where('id_number', $idNumber)
                ->orderBy('computation2Tuition', 'asc')
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->get();

            foreach ($labFees as $fee) {
                if ($remainingLabAmount <= 0) break;
                $amountSubtracted = min($remainingLabAmount, $fee->computation2Tuition);
                $remainingLabAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;

                // Save the deduction to collection
                $deductions->push([
                    'id_number' => $idNumber,
                    'or_number' => $or_number,
                    'category' => 'Laboratory Fees',
                    'fee_type' => $fee->fee_type,
                    'AmountSubtract' => $amountSubtracted,
                    'lab_id' => $fee->lab_id ?? null,
                    'year_level' => $request->year_level,
                    'campus_id' => $request->campus_id,
                    'course_id' => $request->course_id,
                    'department_id' => $request->department_id,
                    'role_name_id' => $request->role_name_id,
                ]);
                $fee->save();
            }

            // Process the miscellaneous fees
            $remainingMiscAmount = $miscFeeAmount;
            $miscFees = studentAssesment::where('category', 'Miscellaneous Fee')
                ->where('id_number', $idNumber)
                ->orderBy('computation2Tuition', 'asc')
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->get();

            foreach ($miscFees as $fee) {
                if ($remainingMiscAmount <= 0) break;
                $amountSubtracted = min($remainingMiscAmount, $fee->computation2Tuition);
                $remainingMiscAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;

                // Save the deduction to collection
                $deductions->push([
                    'id_number' => $idNumber,
                    'or_number' => $or_number,
                    'category' => 'Miscellaneous Fee',
                    'fee_type' => $fee->fee_type,
                    'AmountSubtract' => $amountSubtracted,
                    'misc_fees_id' => $fee->miscfee_id ?? null,
                    'year_level' => $request->year_level,
                    'campus_id' => $request->campus_id,
                    'course_id' => $request->course_id,
                    'department_id' => $request->department_id,
                    'role_name_id' => $request->role_name_id,
                ]);
                $fee->save();
            }

            // Process the other fees
            $remainingOtherAmount = $otherFeeAmount;
            $otherFees = studentAssesment::whereNotIn('category', ['Tuition Fees', 'Laboratory Fees', 'Miscellaneous Fee'])
                ->where('id_number', $idNumber)
                ->orderBy('computation2Tuition', 'asc')
                ->where('semester', $latestSemester)
                ->orderBy('created_at', 'desc')
                ->latest('semester')
                ->get();

            foreach ($otherFees as $fee) {
                if ($remainingOtherAmount <= 0) break;
                $amountSubtracted = min($remainingOtherAmount, $fee->computation2Tuition);
                $remainingOtherAmount -= $amountSubtracted;
                $fee->computation2Tuition -= $amountSubtracted;

                // Save the deduction to collection
                $deductions->push([
                    'id_number' => $idNumber,
                    'or_number' => $or_number,
                    'category' => 'Other Fees',
                    'fee_type' => $fee->fee_type,
                    'AmountSubtract' => $amountSubtracted,
                    'otherFees_id' => $fee->otherFees_id ?? null,
                    'year_level' => $request->year_level,
                    'campus_id' => $request->campus_id,
                    'course_id' => $request->course_id,
                    'department_id' => $request->department_id,
                    'role_name_id' => $request->role_name_id,
                ]);
                $fee->save();
            }

            // Save deductions to FeeCollectionHistory
            foreach ($deductions as $deduction) {
                FeeCollectionHistory::create([
                    'id_number' => $deduction['id_number'],
                    'or_number' => $deduction['or_number'],
                    'category' => $deduction['category'],
                    'subCategory' => $deduction['fee_type'],
                    'amount_subtracted' => $deduction['AmountSubtract'],
                    'lab_id' => $deduction['lab_id'] ?? null,
                    'misc_fees_id' => $deduction['misc_fees_id'] ?? null,
                    'otherFees_id' => $deduction['otherFees_id'] ?? null,
                    'campus_id' => $deduction['campus_id'],
                    'year_level' => $deduction['year_level'],
                    'course_id' => $deduction['course_id'],
                    'department_id' => $deduction['department_id'],
                    'role_name_id' => $deduction['role_name_id'],
                ]);
            }

            if ($studentFeeSummaries->isNotEmpty()) {
                $subtractAmount = $request->input('payment2hidden');
                $payableAmount = $request->input('downpayment22');
                $collectAll = $request->input('collect_all');
                $exessAmount = 0;
                //subtract natin yung amount
                // dd($subtractAmount);
                $studentFeeSummaries->each(function ($summary) use (
                    $subtractAmount,
                    &$exessAmount,
                    &$PRELIMS,
                    &$payableAmount,
                    &$newDownpayment,
                    &$newPrelims,
                    &$newMidterms,
                    &$newSemi_finals,
                    &$newFinals,
                    &$newTotalAssestment,
                    &$downandcurrentprem,
                    &$currentTotal,
                ) {


                    $currentDownpayment = $summary->downpayment;
                    $currentTotal = $summary->total_assessment;

                    $newDownpayment = $summary->downpayment;
                    $newPrelims = $summary->prelims;
                    $newMidterms = $summary->midterms;
                    $newSemi_finals =  $summary->semi_finals;
                    $newFinals = $summary->finals;
                    $newTotalAssestment = $summary->total_assessment;


                    $exessAmount = max($subtractAmount - $currentDownpayment, 0);

                    $newDownpayment = max($currentDownpayment - $subtractAmount, 0);

                    $PaymentFields = ['downpayment', 'prelims', 'midterms', 'semi_finals', 'finals', 'total_assessment'];
                    $newTotal = ($newTotalAssestment - $subtractAmount);


                    if ($subtractAmount >= $summary->total_assessment) {
                        $summary->update([
                            'downpayment' => 0,
                            'prelims' => 0,
                            'midterms' => 0,
                            'semi_finals' => 0,
                            'finals' => 0,
                            'total_assessment' => 0,
                            'computation2Tuition' => 0,
                        ]);
                    } elseif ($subtractAmount > $payableAmount) {
                        $newTotalAssestment = max($currentTotal - $payableAmount, 0);
                        if ($summary->downpayment > 0) {
                            // dd("testing");
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
                        } else {
                            foreach ($PaymentFields as $field) {

                                $currentValue = $summary->{$field};
                                $excessAmountForField = min($exessAmount, $currentValue);
                                $newValue = max($currentValue - $excessAmountForField, 0);
                                $summary->update([$field => $newValue]);
                                ${'new' . ucwords($field)} = $newValue;
                                $exessAmount -= $excessAmountForField;
                                // dd(${'new' . ucwords($field)});
                                $newTotalAssestment = max($currentTotal - $subtractAmount, 0);
                            }
                            $summary->update([

                                'total_assessment' => $newTotalAssestment,
                            ]);
                        }
                    } else {
                        foreach ($PaymentFields as $field) {
                            switch ($field) {
                                case 'downpayment':
                                    if ($summary->downpayment > 0) {
                                        $downandcurrentprem = abs($subtractAmount -= $currentDownpayment += $newPrelims);
                                        $summary->update([
                                            'downpayment' => 0,
                                            'prelims' => $downandcurrentprem,
                                            'total_assessment' => $newTotal,
                                        ]);
                                        break 2;
                                    }
                                    break;

                                case 'prelims':
                                    if ($summary->downpayment == 0 && $summary->prelims > 0) {
                                        $passtomid = abs($subtractAmount -= $newPrelims += $newMidterms);
                                        $summary->update([
                                            'prelims' => 0,
                                            'midterms' => $passtomid,
                                            'total_assessment' => $newTotal,
                                        ]);
                                        break 2;
                                    }
                                    break;

                                case 'midterms':
                                    if ($summary->prelims == 0 && $summary->midterms > 0) {
                                        $passtosemeis = abs($subtractAmount -= $newMidterms + $newSemi_finals);

                                        $summary->update([
                                            'midterms' => 0,
                                            'semi_finals' => $passtosemeis,
                                            'total_assessment' => $newTotal,
                                        ]);
                                        break 2;
                                    }
                                    break;

                                case 'semi_finals':
                                    if ($summary->midterms == 0 && $summary->semi_finals > 0) {
                                        $passtofinals = abs($subtractAmount -= $newSemi_finals + $newFinals);
                                        $summary->update([
                                            'semi_finals' => 0,
                                            'finals' => $passtofinals,
                                            'total_assessment' => $newTotal,
                                        ]);
                                        break 2;
                                    }
                                    break;

                                case 'finals':
                                    if ($summary->semi_finals == 0) {
                                        $summary->update([
                                            'finals' => 0,
                                            'total_assessment' => 0,
                                        ]);
                                        break 2;
                                    }
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
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
