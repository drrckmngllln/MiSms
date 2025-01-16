<?php

namespace App\Helpers;

use App\Models\studentAssesment;


class FeeHelper
{
    // public static function processStudentFees($request)
    // {
    //     $idNumber = $request->input('id_number');
    //     $studentFeeSummaries = studentAssesment::where('id_number', $idNumber)->get();

    //     $newDownpayment = 0;
    //     $subtractAmount = 0;
    //     $newPrelims = 0;
    //     $newMidterms = 0;
    //     $newSemi_finals = 0;
    //     $newFinals = 0;

    //     if ($studentFeeSummaries->isNotEmpty()) {

    //         $subtractAmount = $request->input('downpayment');
    //         $payableAmount = $request->input('payable');
    //         // dd($subtractAmount);
    //         $collectAll = $request->input('collect_all');
    //         //subtract natin yung amount
    //         $studentFeeSummaries->each(function ($summary) use ($subtractAmount, &$exessAmount, &$PRELIMS, &$payableAmount, &$newDownpayment, &$newPrelims,  &$newMidterms, &$newSemi_finals, &$newFinals, &$collectAll) {

    //             $currentDownpayment = $summary->downpayment;
    //             $currentTotal = $summary->total_assessment;

    //             // excessAmount calculation
    //             $exessAmount = max($subtractAmount - $currentDownpayment, 0);
    //             $newDownpayment = max($currentDownpayment - $subtractAmount, 0);


    //             if ($collectAll) {
    //                 //foreach
    //                 $PaymentFields = ['downpayment', 'prelims', 'midterms', 'semi_finals', 'finals'];

    //                 foreach ($PaymentFields as $field) {
    //                     //Deduct exess Amount   

    //                     $currentValue = $summary->{$field};
    //                     $excessAmountForField = min($exessAmount, $currentValue);
    //                     $newValue = max($currentValue - $excessAmountForField, 0);
    //                     $summary->update([$field => $newValue]);
    //                     ${'new' . ucwords($field)} = $newValue;

    //                     $exessAmount -= $excessAmountForField;
    //                     // dd(${'new' . ucwords($field)});
    //                     if ($exessAmount === 0) {
    //                         break;
    //                     }
    //                 }
    //             }
    //             $newTotalAssestment = max($currentTotal - $subtractAmount, 0);

    //             $summary->update([
    //                 'downpayment' => $newDownpayment,
    //                 'total_assessment' => $newTotalAssestment,
    //             ]);
    //         });
    //         return response(['status' => 'success', 'message' => 'Success', 'data' => [
    //             'newDownpayment' => $newDownpayment,
    //             'newPrelims' => $newPrelims,
    //             'newMidterms' => $newMidterms,
    //             'newSemis' => $newSemi_finals,
    //             'newFinals' => $newFinals,
    //             'PRELIMS' => $PRELIMS,
    //             'exessAmount' => $exessAmount,
    //         ]]);
    //     }
    // }
}