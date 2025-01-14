<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\instructorDataTable;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\instructor;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(instructorDataTable $DataTables)
    {
        //
        $department = Department::all();
        return $DataTables->render('Roles.Super_Administrator.instructor.index', compact('department'));
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
        $request->validate(instructor::$rules);
        $instructor = new instructor([
            ...$request->only([
                'full_name'
            ])
        ]);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Creating Instructor Fees Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);
        $instructor->save();
        $request->session()->flash('success', 'Instructor Added Successfully');
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
        //
        // dd($request->all());

        $request->validate(instructor::$rules);
        $instructor = instructor::findOrFail($id);
        $instructor->update(
            $request->only(['full_name'])
        );
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update Laboratory Fees Entry '  . $request->full_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $instructor->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $instructor = instructor::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Instructor Fees Entry '  . $instructor->full_name,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $instructor->delete();

        return response(['status' => 'success', 'message', 'Instructor Deleted Successfully']);
    }
    public function getinsSub(Request $request)
    {
        dd($request->all());
    }
}