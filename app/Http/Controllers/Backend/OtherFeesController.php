<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\OtherFeeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use App\Models\fee_summary;
use App\Models\OtherFee;
use App\Models\SchoolYear;
use App\Models\studentAssesment;
use App\Models\StudentSubject;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OtherFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OtherFeeDataTable $dataTable)
    {
        //

        $campus = Campus::all();
        $schoolyear = SchoolYear::all();
        $course = Course::all();
        $user = Auth::user();
        $role = $user->roles->first()->name;
        $name = $user->name;
        return $dataTable->render('Roles.Super_Administrator.otherfees.index', compact('campus', 'schoolyear', 'course', 'role', 'name'));
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
        // dd($request->all());
        $request->validate(OtherFee::$rules);

        $otherfees = new OtherFee([
            ...$request->only([
                'category',
                'description',
                'semester',
                'campus_id',
                'first_year',
                'second_year',
                'third_year',
                'fourth_year',
                'course_id'
            ])
        ]);

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Creating Other Fees Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);


        $otherfees->save();
        return redirect()->back()->with('success', 'Other Fees Added Successfully');
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
        // dd($request->all());
        $request->validate(OtherFee::$rules);
        $otherfees = OtherFee::findOrFail($id);
        $otherfees->update(
            $request->only(['category', 'description', 'semester', 'campus_id', 'first_year', 'second_year', 'third_year', 'fourth_year', 'course_id'])
        );

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update Other Fees Entry '  . $request->category . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $otherfees->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $otherfees = OtherFee::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Other Fees Entry '  . $otherfees->category . ' ' . $otherfees->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $otherfees->delete();

        return response(['status' => 'success', 'message', 'Other Fees Deleted Successfully']);
    }
    public function addotherFees(Request $request)
    {


        $request->validate(OtherFee::$rules);

        $semester = $request->input('semester');
        $campus  = $request->input('campus_id');
        $schoolyear  = $request->input('school_year');
        $course = $request->input('course_id');
        $yearlevel = $request->input('year_level');

        $queryAddotherFees = studentAssesment::where('semester', $semester)
            ->where('year_level', $yearlevel)
            ->where('campus_id', $campus)
            ->where('school_year', $schoolyear)
            ->where('course_id', $course)
            ->get();

        try {
            DB::beginTransaction();

            foreach ($queryAddotherFees as $assessment) {
                // Fetch the appropriate fee for the year level
                $fee = match ($assessment->year_level) {
                    1 => $request->first_year,
                    2 => $request->second_year,
                    3 => $request->third_year,
                    4 => $request->fourth_year,
                    default => 0
                };
                // Perform the computation
                $computation = $assessment->total_assessment + $fee;
                $portion = $computation / 5;
                $totalassessment = $assessment->totalAss + $fee;
                // dd($totalassessment);

                // Update the existing assessment
                $assessment->update([
                    'downpayment'  => $portion,
                    'prelims'      => $portion,
                    'midterms'     => $portion,
                    'semi_finals'  => $portion,
                    'finals'       => $portion,
                    'total_assessment' => $computation,
                    'stotal_assessment' => $computation,
                    'sdownpayment' => $portion,
                    'sprelims' => $portion,
                    'smidterms' => $portion,
                    'ssemi_finals' => $portion,
                    'sfinals' => $portion,
                    'totalAss' => $totalassessment,
                ]);

                //check duplicate entry for fee_type
                $existingFee = studentAssesment::where('id_number', $assessment->id_number)
                    ->where('school_year', $assessment->school_year)
                    ->where('semester', $assessment->semester)
                    ->where('fee_type', $request->fee_type)
                    ->first();
                if (!$existingFee) {
                    studentAssesment::create([
                        'school_year' => $assessment->school_year,
                        'id_number' => $assessment->id_number,
                        'semester' => $assessment->semester,
                        'fee_type' => $request->fee_type,
                        'category' => $request->category,
                        'amount' => $fee,
                        'lecture_units' => $assessment->lecture_units,
                        'computation' => $fee,
                        'computation2Tuition' => $fee,
                        'downpayment' => $portion,
                        'prelims' => $portion,
                        'midterms' => $portion,
                        'semi_finals' => $portion,
                        'finals' => $portion,
                        'total_assessment' => $computation,
                        'sdownpayment' => $portion,
                        'total_miscfee_first_year' => $assessment->total_miscfee_first_year,
                        'discount_id' => $assessment->discount_id,
                        'sprelims' => $portion,
                        'smidterms' => $portion,
                        'ssemi_finals' => $portion,
                        'sfinals' => $portion,
                        'stotal_assessment' => $computation,
                        'course_id' => $assessment->course_id,
                        'year_level' => $assessment->year_level,
                        'campus_id' => $assessment->campus_id,

                    ]);
                }

                $existingFeeSummary = fee_summary::where('id_number', $assessment->id_number)
                    ->where('particulars', $request->particulars)
                    ->first();
                if (!$existingFeeSummary) {
                    fee_summary::create([
                        'particulars' => $request->particulars,
                        'id_number' => $assessment->id_number,
                        'total_assessment' => $assessment->total_assessment,
                        'name' => $request->name,
                        'cahier_in_charge' => $request->cahier_in_charge,
                    ]);
                }
                // dd($testing); 

            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        // try {
        //     DB::beginTransaction();
        //     $testing = fee_summary::create([
        //         'particulars' => $request->particulars,
        //         'id_number' => $assessment->id_number,
        //         'total_assessment' => $assessment->total_assessment,
        //         'name' => $request->name,
        //         'cahier_in_charge' => $request->cahier_in_charge,

        //     ]);
        //     // dd($testing);
        //     //commit kapag successfully
        //     DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     dd($e);
        // }
        //save on other fees table
        $otherfees = new OtherFee([
            ...$request->only([
                'category',
                'description',
                'semester',
                'campus_id',
                'first_year',
                'second_year',
                'third_year',
                'fourth_year',
                'course_id'
            ])
        ]);
        $otherfees->save();
        //automatic delete if save

        //save on statement of account
        return redirect()->back()->with('success', ' Added Successfully!');
    }
}
