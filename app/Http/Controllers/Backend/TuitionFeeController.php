<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\TuitionFeeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\TuitionFeeRequest;
use App\Models\Campus;
use App\Models\Course;
use App\Models\TuitionFee;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TuitionFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TuitionFeeDataTable $dataTable)
    {
        //
        $campus = Campus::all();
        $course = Course::all();
        return $dataTable->render('Roles.Super_Administrator.tuitionFees.index', compact('campus', 'course'));
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
        try {
            $request->validate(TuitionFee::$rules);
            $tuitionfee = new TuitionFee([
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
                'modify_user' => 'Creating Tuition Fees Entry ',
                'date_time' => $dt->format('D, M j, Y g:i A'),
            ];
            DB::table('activity_logs')->insert($activityLog);


            $tuitionfee->save();
            $request->session()->flash('success', 'Tuition Fee Addes Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
        }
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
        // dd($request->all());
        $request->validate(TuitionFee::$rules);
        $tuitionfee = TuitionFee::findOrFail($id);
        $tuitionfee->update(
            $request->only(['category', 'description', 'semester', 'campus_id', 'first_year', 'second_year', 'third_year', 'fourth_year', 'course_id'])
        );
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update Tuition Fees Entry '  . $request->category . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $tuitionfee->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tuitionfee = TuitionFee::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Tuition Fees Entry '  . $tuitionfee->category . ' ' . $tuitionfee->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $tuitionfee->delete();
        return response(['status' => 'success', 'message', 'Tuition Fee Deleted Successfully']);
    }
}