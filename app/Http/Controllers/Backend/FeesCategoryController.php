<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FeesCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\FeesCategory;
use Illuminate\Http\Request;

class FeesCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FeesCategoryDataTable $dataTable)
    {
        //
        $courses = Course::all();
        return $dataTable->render('Roles.Super_Administrator.feescategory.index', compact('courses'));
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

        $request->validate(FeesCategory::$rules);
        $feescategory = new FeesCategory([
            ...$request->only([
                'category', 'freetype', 'course_id', 'year_level', 'amount', 'remarks'
            ])
        ]);
        $feescategory->save();
        return redirect()->back()->with('success', 'Fees Category Added Successfully');
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
