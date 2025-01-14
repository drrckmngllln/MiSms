<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\MiscFeeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use App\Models\MiscFee;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MiscFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MiscFeeDataTable $dataTable)
    {
        //

        $campus = Campus::all();
        $course = Course::all();
        return $dataTable->render('Roles.Super_Administrator.miscfee.index', compact('campus', 'course'));
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
        $request->validate(MiscFee::$rules);

        $miscfee = new MiscFee([
            ...$request->only([
                'category',
                'description',
                'semester',
                'campus_id',
                'first_year',
                'second_year',
                'third_year',
                'fourth_year',
                'course_id',
            ])
        ]);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Creating Misc Fees Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);

        $miscfee->save();
        $request->session()->flash('success', 'Miscellaneous Added Successfully');
        return redirect()->back();
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
        $request->validate(MiscFee::$rules);
        $miscfee = MiscFee::findOrFail($id);
        $miscfee->update(
            $request->only(['category', 'description', 'semester', 'campus_id', 'first_year', 'second_year', 'third_year', 'fourth_year', 'course_id'])
        );

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update Misc Fees Entry '  . $request->category . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $miscfee->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $miscfee = MiscFee::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Miscfee Fees Entry '  . $miscfee->category . ' ' . $miscfee->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $miscfee->delete();

        return response(['status' => 'success', 'message', 'Miscellaneous Deleted Successfully']);
    }
}