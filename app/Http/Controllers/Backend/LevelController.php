<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\LevelDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LevelRequest;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LevelDataTable $dataTable)
    {
        // $levels = Level::all();
        // return view('Roles.Super_Administrator.levels.index', compact('levels'));
        return $dataTable->render('Roles.Super_Administrator.levels.index');
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
    public function store(LevelRequest $request)
    {
        $levels = new Level([
            ...$request->only([
                'code', 'description', 'is_active'
            ])
        ]);
        $levels->save();

        return back()->with('success', 'Level Add Success!');
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
    public function update(Request $request, String $id)
    {
        $levelupdate = Level::findOrFail($id);
        $levelupdate->update($request->only([
            'code', 'description', 'is_active'
        ]));
        return back()->with('success', 'Level Update Success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $level = Level::findOrFail($id);
        $level->delete();
        return response(['status' => 'success', 'message', 'Deleted Successfully']);
    }
}
