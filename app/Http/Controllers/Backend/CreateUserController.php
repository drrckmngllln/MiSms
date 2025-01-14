<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CreateUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        //

        $roles = Role::all();
        return $dataTable->render('Roles.Super_Administrator.createUser.index', compact('roles'));
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
        $request->validate(User::$rules);
        $user = new User([
            ...$request->only(['name', 'email']),
        ]);
        $user->password = bcrypt($request->password);
        $user->assignRole($request->roles);

        $user->save();
        return redirect()->back()->with('success', 'User Created Successfully with Roles');
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
        $request->validate(User::$rules);
        $user = User::findOrFail($id);

        $user->update([
            ...$request->only('name', 'email', 'roles'),
        ]);
        if ($request->password && $request->password !== '') {
            $user->password = bcrypt($request->password);
        }

        $newrole = $request->input('roles');
        // Check if the user has a role
        if ($user->hasRole($newrole)) {
            //meron
        } else {
            $user->syncRoles([$newrole]);
        }

        $user->save();
        return redirect()->back()->with('success', 'User Updated Successfully with Roles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);

        $user->delete();

        return response(['status' => 'success', 'message', 'User Deleted Successfully']);
    }
}
