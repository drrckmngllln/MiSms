<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //where not in is para kapag ikaw ay superadmin for example hindi mo ma eedit ito sa loob  role and permission
        // $roles = Role::whereNotIn('name', ['role A', 'role B'])->get(); -> gagaminit natin to sa admin para hindi sila maka edit
        //yung permission ay naka lagay dito dahil gumamit tayu ng portal
        //yung permission dito isa dati ng naka relationship 
        $permissions = Permission::all();
        $roles = Role::all();


        return view('Roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());

        //first mag vavalidate tayu then save agad
        $validated = $request->validate(['name' => ['required', 'min:3']]);
        Role::Create($validated);

        return redirect()->back()->with('success', 'Successfully created');
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
        $permissions = Permission::all();
        return view('Roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        // dd($request->all());

        $validated = $request->validate(['name' => 'required']);
        $role->update($validated);

        return redirect()->back()->with('success', 'Successfully Edit Permission');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $curriculum = Role::findOrfail($id);

        $curriculum->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
    public function givePermission(Request $request, Role $role)
    {
        // dd($request->all());
        //first check natin kung meron siyang role at kung meron itong permission
        //at makikita natin dito kung yung role ay merong permissions
        //gagamit tayu ng if statement
        if ($role->hasPermissionTo($request->permission)) {
            //     //if we have
            return redirect()->back()->with('success', 'Permission exists.');
        }
        $role->givePermissionTo($request->permission);
        return redirect()->back()->with('success', 'Permission added.');
    }
    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            return response(['status' => 'success', 'message' => 'Permission Revoke']);
        }
        return response(['status' => 'success', 'message' => 'Not Exist']);
    }
    public function addPermissionsToRoles(string $id)
    {

        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id')
            ->all();

        // dd($rolePermissions);
        return view('Roles.addPermissionToRoles', compact('role', 'permissions', 'rolePermissions'));
    }
    public function givePermissiontoRole(string $id, Request $request)
    {
        // dd($request->all());

        try {
            $request->validate([
                'permission' => 'required'
            ]);
            $role = Role::findOrFail($id);
            $role->syncPermissions($request->permission);
            return redirect()->back()->with('success', 'Successfully Sync');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
