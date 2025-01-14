<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\ImportstudentList as ImportsImportstudentList;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportStudentList extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        try {
            $file = $request->file('excel_file');
            $this->validate($request, [
                'excel_file' => 'required|mimes:xlsx,xls'
            ]);
            Excel::import(new ImportsImportstudentList, $file);
            $request->session()->flash('success', 'Student Added Successfully');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
