<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionSubject;
use App\Models\Subject;
use Illuminate\Http\Request;

class SectionSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        //
        if (request()->ajax()) {
            return datatables()->of(SectionSubject::where('section_id', $id)->get())
                ->addColumn('action', function ($query) {
                    return $deleteBtn = '<button class="btn btn-danger delete-item"> - </button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Roles.Super_Administrator.section_subjects.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        if (request()->ajax()) {
            return datatables()->of(Subject::where('is_active', 1))
                ->addColumn('action', function ($query) {
                    $addbtn = '<button type="submit" class="btn btn-success" onclick="addSubject(
                        ' . $query->id . ',\'' . $query->section_id . '\',\'' . $query->semester_id . '\', \'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', 
                        \'' . $query->total_units . '\', \'' . $query->lecture_units . '\', \'' . $query->lab_units . '\', \'' . $query->pre_requisite . '\', 
                        \'' . $query->total_hrs_per_week . '\', \'' . $query->is_active . '\'
                    )">+</button>';
                    return $addbtn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $hasDuplicate = SectionSubject::where('section_id', $request->section_id)->where('code', $request->code)->first();
        if ($hasDuplicate) {
            return response(['status' => 'error', 'message' => 'Duplicate Entry']);
        }
        $subject = new SectionSubject([
            ...$request->only([
                'section_id', 'semester_id', 'code', 'descriptive_tittle', 'total_units', 'lecture_units',
                'lab_units', 'pre_requisite', 'total_hrs_per_week', 'is_active'
            ])
        ]);
        $subject->save();
        return response(['status' => 'success', 'message' => 'Added Successfully']);
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
        $section_subject = SectionSubject::findOrFail($id);

        $section_subject->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
}
