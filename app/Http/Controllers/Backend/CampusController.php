<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CampusDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampusRequest;
use App\Models\Campus;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CampusDataTable $dataTable)
    {
        return $dataTable->render('Roles.Super_Administrator.campus.index');
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
    public function store(CampusRequest $request)
    {
        $campus = new Campus([
            ...$request->only([
                'code',
                'description',
                'address',
                'is_active'
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
            'modify_user' => 'Creating Campus Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $campus->save();


        return redirect()->back()->with('success', 'Campus Create Success!');
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
        $campuses = Campus::findOrFail($id);
        $request->validate([
            'code' => ['required', 'unique:campuses,code,' . $campuses->id],
            'description' => ['required'],
            'address' => ['required'],
            'is_active' => ['required']
        ]);
        $campuses->code = $request->code;
        $campuses->description = $request->description;
        $campuses->address = $request->address;
        $campuses->is_active = $request->is_active;

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update Campus Entry '  . $request->code . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);

        $campuses->save();

        return redirect()->back()->with('success', 'Campus Update Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $campus = Campus::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Campus Entry '  . $campus->code . ' ' . $campus->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $campus->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
}