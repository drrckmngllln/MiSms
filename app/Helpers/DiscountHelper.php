<?php

namespace App\Helpers;

use App\Models\CreateAccount;
use App\Models\fee_summary;
use App\Models\studentAssesment;
use App\Models\StudentSelectDiscount;
use App\Models\StudentSubject;

use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiscountHelper
{
    public static function applyDiscount($request)
    {
        // $exitDisc = StudentSelectDiscount::where('code', $request->code)->first();

        // if ($exitDisc) {
        //     return response(['status' => 'error', 'message' => 'Duplicate entry, select another']);
        // }

        // dd($request->all());
        $discount = new StudentSelectDiscount([
            ...$request->only(['id_number', 'code', 'discount_target', 'description', 'discount_percentage', 'school_year', 'semester'])
        ]);


        $discount->save();

        $latestSemester = studentAssesment::where('id_number', $request->id_number)->max('semester');
        $studentAssessment = studentAssesment::where('id_number', $request->id_number)
            ->where('semester', $latestSemester)
            ->orderBy('semester', 'desc')
            ->first();

        if ($studentAssessment) {
            self::processDiscount($request, $studentAssessment, $discount->id);
        }
    }
    public static function processDiscount($request, $studentAssessment, $discount_id)
    {
        $latestSemester = studentAssesment::where('id_number', $request->id_number)->max('semester');
        $studentAssessment = studentAssesment::where('id_number', $request->id_number)
            ->where('semester', $latestSemester)
            ->orderBy('created_at', 'desc')
            ->first();
        // dd($studentAssessment);
        //for the Son and daughters of employee
        if ($studentAssessment) {
            $discountPercentage = $request->discount_percentage;
            $discountTarget = $request->discount_target;
            $discountID = $request->discount_id;

            if (!is_numeric($discountPercentage) || $discountPercentage < 0 || $discountPercentage > 5000) {
                return response(['status' => 'error', 'message' => 'Invalid discount percentage']);
            }

            // $paymentFields = ['finals', 'semi_finals', 'midterms', 'prelims', 'downpayment', 'computation'];
            if ($discountPercentage == 100 && $discountTarget == 'Tuition Fee 100%') {
                $newtuition =  $studentAssessment->discountCompute = $studentAssessment->computation;

                // dd($studentAssessment->computation2Tuition);
                $newTotalAss = $studentAssessment->total_assessment - $studentAssessment->computation;


                $studentAssessment->computation2Tuition = 0;
                $newAmountlab = $newTotalAss;
                $discount = $studentAssessment->discountCompute = $studentAssessment->tutionFeesDeleteSub;
                // dd($discount);

                $perSemlab = $newAmountlab / 5;

                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];


                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;



                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount Tuition Fee 100% to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);

                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $newtuition,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $newtuition,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $newtuition,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,
                ]);
            } elseif ($discountPercentage == 50 && $discountTarget == 'Tuition Fee 50%') {
                // Calculate 50% of 'computation'
                $totalDiscount = floatval(0.50 * $studentAssessment->computation2Tuition);
                $totalDiscount = number_format($totalDiscount, 2, '.', '');
                $totalDiscount1 = 0.50 * $studentAssessment->computation;
                // $totalDiscount1 = number_format($totalDiscount, 2, '.', '');
                // dd($totalDiscount1);
                $new25 =    $studentAssessment->discountCompute = $totalDiscount1;
                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount1;

                $newTuition =  $studentAssessment->computation2Tuition - $totalDiscount1;
                $studentAssessment->computation2Tuition = $newTuition;



                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;
                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];

                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply DiscountTuition Fee 50% to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $new25,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $new25,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $new25,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 100 && $discountTarget == 'Tuition Fee 100%/Misc Fee 100%') {
                // dd("testing");

                $totalMiscFees = studentAssesment::where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)
                    ->where('category', 'Miscellaneous Fee')
                    ->sum('computation');


                $testing = $totalMiscFees + $studentAssessment->computation;
                $studentAssessment->discountCompute = $testing;
                $studentAssessment->discountComputeMiscFee = $totalMiscFees;
                $newTotalAss = $studentAssessment->total_assessment -  $testing;
                // dd($newTotalAss);
                $studentAssessment->computation2Tuition = 0;
                $studentAssessment->discountComputeMiscFee = $studentAssessment->total_miscfee_first_year;
                $studentAssessment->total_miscfee_first_year = 0;
                $discount = $studentAssessment->discountCompute = $studentAssessment->tutionFeesDeleteSub;


                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;
                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];


                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount to Tuition Fee 100% / Misc Fee 100% Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_miscfee_first_year' => 0,
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $discount,
                        'discountComputeMiscFee' => $totalMiscFees,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),
                    ]);
                studentAssesment::where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)
                    ->where('category', 'Miscellaneous Fee')
                    ->update([
                        'computation2Tuition' => 0
                    ]);
                studentAssesment::where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)
                    ->where('category', 'Tuition Fee')
                    ->update([
                        'computation2Tuition' => 0
                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' =>  $testing,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $studentAssessment->discountCompute + ($studentAssessment->discountComputeMiscFee ?? 0),
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 100 && $discountTarget == 'Misc Fee 100%') {
                $studentAssessment->discountComputeMiscFee = $studentAssessment->total_miscfee_first_year;
                $newTotalAss = $studentAssessment->total_assessment -= $studentAssessment->total_miscfee_first_year;
                $studentAssessment->total_miscfee_first_year = 0;
                $studentAssessment->computation2Tuition = 0;

                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];


                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount Misc Fee 100% to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);

                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_miscfee_first_year' => 0,
                        'total_assessment' => $newTotalAss,
                        'discountComputeMiscFee' => $studentAssessment->discountComputeMiscFee,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),
                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $studentAssessment->discountCompute,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $studentAssessment->discountCompute,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 100 && $discountTarget == 'Tuition Fee 80%/Misc Fee 100%') {
                // dd("testing");
                $computationDiscount = 0.8 * $studentAssessment->computation;
                $studentAssessment->discountCompute = $computationDiscount;
                $newTotalAss =  $studentAssessment->total_assessment -= $computationDiscount;
                $studentAssessment->computation -= $computationDiscount;

                $studentAssessment->discountComputeMiscFee = $studentAssessment->total_miscfee_first_year;
                $newTotalAss = $studentAssessment->total_assessment -= $studentAssessment->total_miscfee_first_year;
                $studentAssessment->total_miscfee_first_year = 0;

                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;
                $discount = $studentAssessment->discountCompute = $studentAssessment->tutionFeesDeleteSub;


                $columnsToStoreslab = ['sdownpayment', 'sprelims', 'smidterms', 'ssemi_finals', 'sfinals'];



                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount Tuition Fee 80%/Misc Fee 100% to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_miscfee_first_year' => 0,
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $discount,
                        'discountComputeMiscFee' => $studentAssessment->discountComputeMiscFee,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),
                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $studentAssessment->discountCompute,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $studentAssessment->discountCompute,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 35 && $discountTarget == '35% Discount Crim/Ca') {
                // Calculate 35% of 'total_assessment'


                // $totalTuitionFees = studentAssesment::where('id_number', $request->id_number)
                //     ->where('semester', $latestSemester)
                //     ->where('category', 'Tuition Fees')
                //     ->sum('computation2Tuition');


                // $totalDiscount = 0.35 * $totalTuitionFees;

                // $totalDiscount1 = 0.35 * $studentAssessment->computation;
                // $newtotaltuition = abs($totalDiscount - $studentAssessment->computation2Tuition);
                // $studentAssessment->computation2Tuition - $newtotaltuition;

                // $studentAssessment->computation2Tuition = $newtotaltuition;
                // $newTotalAss =  $studentAssessment->total_assessment - $totalDiscount;

                $totalDiscount = floatval(0.35 * $studentAssessment->computation2Tuition);
                $totalDiscount = number_format($totalDiscount, 2, '.', '');
                $totalDiscount1 = 0.35 * $studentAssessment->computation;
                // $totalDiscount1 = number_format($totalDiscount, 2, '.', '');
                // dd($totalDiscount1);
                $new25 =    $studentAssessment->discountCompute = $totalDiscount1;
                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount1;

                $newTuition =  $studentAssessment->computation2Tuition - $totalDiscount1;
                $studentAssessment->computation2Tuition = $newTuition;

                // dd($studentAssessment->total_assessment - $totalDiscount);

                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;
                $discount = $studentAssessment->discountCompute = $studentAssessment->tutionFeesDeleteSub;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];




                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 35% Discount Crim/Ca to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $new25,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $new25,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $new25,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 3 && $discountTarget == 'cash 3000') {
                $totalDiscount = 3000;

                $newTuition = abs($totalDiscount - $studentAssessment->computation2Tuition);
                $studentAssessment->computation2Tuition = $newTuition;

                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount;

                $discount = $studentAssessment->discountCompute = $totalDiscount;

                $newAmountlab = $newTotalAss;

                $perSem = $newAmountlab / 5;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];

                // Pinagsama ang parehong columns


                $perSem = round($newAmountlab / 5, 3);

                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount cash 3% to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);

                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newAmountlab,
                        'discountCompute' => $totalDiscount,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSem), // Apply to both with 's' and without
                    ]);
                // dd($studentAssessment->sdownpayment);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $totalDiscount,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $totalDiscount,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 5 && $discountTarget == '5% Discount Tuition Fee Only') {

                $totalDiscount = floatval(0.05 * $studentAssessment->computation2Tuition);
                $totalDiscount = number_format($totalDiscount, 2, '.', '');
                $totalDiscount1 = 0.05 * $studentAssessment->computation;
                // $totalDiscount1 = number_format($totalDiscount, 2, '.', '');
                // dd($totalDiscount1);
                $new25 =    $studentAssessment->discountCompute = $totalDiscount1;
                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount1;

                $newTuition =  $studentAssessment->computation2Tuition - $totalDiscount1;
                $studentAssessment->computation2Tuition = $newTuition;



                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;
                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];
                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 5% Discount Tuition Fee Only to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);

                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $new25,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $new25,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $new25,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 10 && $discountTarget == '10% Discount Tuition Fee Only') {
                $totalDiscount = floatval(0.1 * $studentAssessment->computation2Tuition);
                $totalDiscount = number_format($totalDiscount, 2, '.', '');
                $totalDiscount1 = 0.1 * $studentAssessment->computation;
                // $totalDiscount1 = number_format($totalDiscount, 2, '.', '');
                // dd($totalDiscount1);
                $new25 =    $studentAssessment->discountCompute = $totalDiscount1;
                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount1;

                $newTuition =  $studentAssessment->computation2Tuition - $totalDiscount1;
                $studentAssessment->computation2Tuition = $newTuition;



                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;
                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];


                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 10% Discount Tuition Fee Only to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);


                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $new25,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $new25,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $new25,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 100 && $discountTarget == '100% Discount on Tuition Fee ORPHANS') {
                $studentAssessment->discountCompute = $studentAssessment->computation;
                $newTotalAss = $studentAssessment->total_assessment -= $studentAssessment->computation;
                $studentAssessment->computation2Tuition = 0;

                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];




                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 100% Discount on Tuition Fee ORPHANS to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);

                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $studentAssessment->discountCompute,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $studentAssessment->discountCompute,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $studentAssessment->discountCompute,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 25 && $discountTarget == '25% Discount on Tuition Fee') {

                $totalDiscount = floatval(0.25 * $studentAssessment->computation2Tuition);
                $totalDiscount = number_format($totalDiscount, 2, '.', '');
                $totalDiscount1 = 0.25 * $studentAssessment->computation;
                // $totalDiscount1 = number_format($totalDiscount, 2, '.', '');
                // dd($totalDiscount1);
                $new25 =    $studentAssessment->discountCompute = $totalDiscount1;
                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount1;

                $newTuition =  $studentAssessment->computation2Tuition - $totalDiscount1;
                $studentAssessment->computation2Tuition = $newTuition;
                // dd($newTuition);
                // dd($newTotalAss);
                // $studentAssessment->computation -= $totalDiscount;
                // $discount = $studentAssessment->discountCompute = $studentAssessment->tutionFeesDeleteSub;
                // dd($studentAssessment->total_assessment - $totalDiscount);
                $newAmountlab = $newTotalAss;

                $perSemlab = $newAmountlab / 5;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];



                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 25% Discount on Tuition Fee SK CHAIRMAN to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $new25,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $new25,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $new25,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 2000 && $discountTarget == '2000 Discount TOP 6-10') {
                $totalDiscount = 2000;

                $newTuition = abs($totalDiscount - $studentAssessment->computation2Tuition);
                $studentAssessment->computation2Tuition = $newTuition;

                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount;

                $discount = $studentAssessment->discountCompute = $totalDiscount;

                $newAmountlab = $newTotalAss;

                $perSem = $newAmountlab / 5;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];

                // Pinagsama ang parehong columns


                $perSem = round($newAmountlab / 5, 3);

                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 2000 Discount TOP 6-10 to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);

                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newAmountlab,
                        'discountCompute' => $totalDiscount,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSem), // Apply to both with 's' and without
                    ]);
                // dd($studentAssessment->sdownpayment);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $totalDiscount,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $totalDiscount,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            } elseif ($discountPercentage == 1000 && $discountTarget == '1000 Discount TOP 11-20') {
                $totalDiscount = 1000;

                $newTuition = abs($totalDiscount - $studentAssessment->computation2Tuition);
                $studentAssessment->computation2Tuition = $newTuition;

                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount;

                $discount = $studentAssessment->discountCompute = $totalDiscount;

                $newAmountlab = $newTotalAss;


                $perSemlab = $newAmountlab / 5;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];

                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 1000 Discount TOP 11-20 to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $discount,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSemlab),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $totalDiscount,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $totalDiscount,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,
                ]);
            } elseif ($discountPercentage == 500 && $discountTarget == '500 Discount Average 85% and ABOVE') {
                $totalDiscount = 500;

                $newTuition = abs($totalDiscount - $studentAssessment->computation2Tuition);
                $studentAssessment->computation2Tuition = $newTuition;

                $newTotalAss = $studentAssessment->total_assessment - $totalDiscount;

                $discount = $studentAssessment->discountCompute = $totalDiscount;

                $newAmountlab = $newTotalAss;

                $perSem = $newAmountlab / 5;


                $columnsToStoreslab = [
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals'
                ];



                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 500 Discount Average 85% and ABOVE to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];

                DB::table('activity_logs')->insert($activityLog);
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'total_assessment' => $newTotalAss,
                        'discountCompute' => $discount,
                        // 'totalAss' => $newTotalAss,
                        'stotal_assessment' => $newAmountlab,
                        ...array_fill_keys($columnsToStoreslab, $perSem),

                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $totalDiscount,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $totalDiscount,
                    'downpayment2' => $studentAssessment->discountCompute,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'discount_id' => $request->discount_id,

                ]);
            }


            $latestSemester = studentAssesment::where('id_number', $request->id_number)->max('semester');
            studentAssesment::where('id_number', $request->id_number)
                ->where('semester', $latestSemester)
                ->orderBy('semester', 'desc')
                ->update(['discount_id' => $discountID, 'select_discount_id' => $discount_id]);
            $studentAssessment->save();

            $twentyPercent = 0.2 * $studentAssessment->total_assessment;

            $user = Auth::user();
            $roleName = Role::find($user->roles()->first()?->id)?->name;

            $dt = Carbon::now('Asia/Manila');
            $activityLog = [
                'username' => $user->name,
                'email' => $user->email,
                'role_name' => $roleName,
                'modify_user' => 'Apply Discount to Student ID' . $studentAssessment->id_number,
                'date_time' => $dt->format('D, M j, Y g:i A'),
            ];

            // DB::table('activity_logs')->insert($activityLog);
            // $columnsToStore = ['downpayment', 'prelims', 'midterms', 'semi_finals', 'finals'];
            // studentAssesment::where('id_number', $studentAssessment->id_number)
            //     ->where('semester', $latestSemester)
            //     ->orderBy('semester', 'desc')
            //     ->update(array_fill_keys($columnsToStore, $twentyPercent));
            // fee_summary::create([
            //     'id_number' => $request->id_number,
            //     'date' => Carbon::now()->format('Y-m-d'),
            //     'downpayment' => $studentAssessment->discountCompute,
            //     'or_number' => $request->or_number,
            //     'particulars' => $discountTarget,
            //     'total_assessment' => $studentAssessment->total_assessment,
            //     'downpayment2' => $studentAssessment->discountCompute,
            //     'type' => 'Discount',

            // ]);

            // dd($esting);
            //fULL Scholarship
            if ($discountPercentage == 100 && $discountTarget == '100% MCNP-ISAP SCHOLAR/GRANTEES') {
                $propertiesToSetToZero = [
                    'computation2Tuition',
                    'total_miscfee_first_year',
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals',
                    'total_assessment',
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'stotal_assessment'
                ];
                $tuitionfee = studentAssesment::where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)

                    ->where('category', 'Tuition Fees')

                    ->sum('computation');
                $miscfee = studentAssesment::where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)

                    ->where('category', 'Miscellaneous Fee')

                    ->sum('computation');
                $otherfee = studentAssesment::where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)

                    ->where('category', 'Other Fees')

                    ->sum('computation');
                $labfee = studentAssesment::where('id_number', $request->id_number)
                    ->where('semester', $latestSemester)

                    ->where('category', 'Laboratory Fee')

                    ->sum('computation');

                $newAmount = $tuitionfee + $miscfee + $otherfee + $labfee;

                $user = Auth::user();
                $roleName = Role::find($user->roles()->first()?->id)?->name;

                $dt = Carbon::now('Asia/Manila');
                $activityLog = [
                    'username' => $user->name,
                    'email' => $user->email,
                    'role_name' => $roleName,
                    'modify_user' => 'Apply Discount 100% MCNP-ISAP SCHOLAR/GRANTEES to Student ID' . $studentAssessment->id_number,
                    'date_time' => $dt->format('D, M j, Y g:i A'),
                ];
                DB::table('activity_logs')->insert($activityLog);
                // Update properties directly in the database
                studentAssesment::where('id_number', $studentAssessment->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->update([
                        'discountCompute' => $newAmount,
                        ...array_fill_keys($propertiesToSetToZero, 0)
                    ]);
                fee_summary::create([
                    'id_number' => $request->id_number,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'downpayment' => $newAmount,
                    'or_number' => $request->or_number,
                    'particulars' => $discountTarget,
                    'total_assessment' => $studentAssessment->total_assessment,
                    'downpayment2' => $newAmount,
                    'discount_type' => $request->discount_type,
                    'discount_code' => $request->discount_code,
                    'reason/remarks' => $request->code,
                    'department_id' => $studentAssessment->department_id,
                    'type' => 'Discount',
                    'school_year' => $request->school_year,
                    'discount_id' => $request->discount_id,

                ]);
                CreateAccount::where('id_number', $request->id_number)
                    ->update(['status' => 'OFFICIALLY ENROLLED']);
            }
        }
    }
}
