<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CurriculumSubjectDataTable;
use App\DataTables\SubjectDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurriculumSubjectRequest;
use App\Models\CurriculumSubject;
use App\Models\Department;
use App\Models\section_subjectss;
use App\Models\Subject;
use DB;
use Illuminate\Http\Request;


class CurriculumSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        if (request()->ajax()) {
            return datatables()->of(CurriculumSubject::where('curriculum_id', $id)->get())
                ->addColumn('action', function ($query) {
                    // return $deleteBtn = '<button class="btn btn-danger delete-item"> - </button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        // $department = Department::all();
        return view('Roles.Super_Administrator.curriculum_subjects.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->ajax()) {
            return datatables()->of(section_subjectss::where('is_active', 1))
                ->addColumn('lab_name', function ($query) {
                    return $query->laboratory->description ?? '';
                })
                ->addColumn('action', function ($query) {
                    $addbtn = '<button type="submit" class="btn btn-success" onclick="addSubject(
                        ' . $query->subject_id . ', \'' . $query->semester_id . '\', \'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \'' . $query->total_units . '\', 
                        \'' . $query->lab_id . '\',\'' . $query->time . '\',\'' . $query->day . '\',\'' . $query->room . '\',
                    )">+</button>';
                    return $addbtn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        // $subjects = Subject::all();
        // return response()->json($subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(CurriculumSubjectRequest $request)
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $hasDuplicate = CurriculumSubject::where('curriculum_id', $request->curriculum_id)->where('code', $request->code)->first();
            if ($hasDuplicate) {
            }

            $subject = new CurriculumSubject([
                ...$request->only([
                    'curriculum_id',
                    'semester_id',
                    'code',
                    'descriptive_tittle',
                    'total_units',
                    'lecture_units',
                    'lab_units',
                    'pre_requisite',
                    'total_hrs_per_week',
                    'is_active'
                ])
            ]);
            $subject->save();
            return response(['status' => 'success', 'message' => 'Added Successfully']);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // return $dataTable->render('Roles.Super_Administrator.curriculum_subjects.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = CurriculumSubject::findOrFail($id);


        $subject->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
    public function getSemesterbByCurriculum(string $semester_id)
    {
        try {
            return CurriculumSubject::where('curriculum_id', $semester_id)->get();
        } catch (\Exception $e) {
        }
    }
    public function deleteCurriculumSubject(String $id)
    {
        $subject = CurriculumSubject::findOrFail($id);

        $subject->delete();

        return response(['status' => 'success', 'message' => 'Subject Deleted Successfully']);
    }
    public function updateCurriculumSubject(string $id, CurriculumSubjectRequest $request)
    {
        // dd($request->all());
        try {
            $curriculumSubject = CurriculumSubject::findOrFail($id);
            $curriculumSubject->update($request->only([
                'semester_id',
                'year_level',
                'code',
                'descriptive_tittle',
                'total_units',
                'lecture_units',
                'lab_units',
                'pre_requisite',
                'total_hrs_per_week'
            ]));
            $curriculumSubject->save();

            // return back()->with('success', 'Subject Updated Successfully!!');
            return response(['status' => 'success', 'message' => 'Subject Updated Successfully']);
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function deleteSubjects(Request $request)
    {
        $id = $request->input('id');
        if (!empty($id)) {
            CurriculumSubject::whereIn('id', $id)->delete();
            return response()->json(['success' => 'Records deleted successfully.']);
        }
    }
}
