<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\DepartmentDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentDataTable $dataTable)

    {
        $campus = Campus::all();
        return $dataTable->render('Roles.Super_Administrator.departments.index', compact('campus'));
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
    public function store(DepartmentRequest $request)
    {
        // dd($request->all());
        $departments = new Department([
            ...$request->only([
                'code',
                'description',
                'campus_id'
            ])
        ]);
        // Add an activity log
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Creating Department Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);


        $departments->save();
        return back()->with('success', 'Department Add Success');
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
    public function update(DepartmentRequest $request, string $id)
    {
        $department = Department::findOrFail($id);
        $request->validate([
            'code' => ['required', 'unique:departments,code,' . $department->id],
            'description' => ['required'],
            'campus_id' => ['required']
        ]);
        $department->code = $request->code;
        $department->description = $request->description;
        $department->campus_id = $request->campus_id;
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update Department Entry '  . $request->code . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);


        $department->save();

        return back()->with('success', 'Department Update Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Department Entry '  . $department->code . ' ' . $department->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $department->delete();
        return response(['status' => 'success', 'message', 'Deleted Successfully']);
    }
    public function getDepartmentByCourse(Request $request)
    {

        $course_id = $request->get('course_id');
        $department = Course::where('id', $course_id)->first();
        // dd($department);
        if ($department) {
            return response()->json(['department_id' => $department->department_id, 'description' => $department->description]);
        } else {
            return response()->json(['error' => 'Department not found'], 404);
        }
    }
}