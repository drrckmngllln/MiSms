<?php

namespace App\Http\Controllers\Backend\Functionality\Offerings;

use App\DataTables\CurriculumDataTable;
use App\DataTables\CurriculumSubjectDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurriculumRequest;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Current;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Curriculum::all())
                ->addColumn('action', function ($query) {
                    $btnContainer = '<div class="d-flex justify-content-center">';

                    $showSubjects = '<a class="btn btn-success waves-effect waves-light mx-1" onclick="throwID(' . $query->id . ')">Subjects</i></a>';
                    $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editCurriculum
                    (' . $query->id . ',\' ' . $query->code . ' \', \'' . $query->description . '\', \'' . $query->campus_id . '\', 
                    \'' . $query->course_id . '\', \'' . $query->effective . '\', \'' . $query->expires . '\', \'' . $query->status . '\')">';
                    $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                    $editBtn .= '<i class="ri-edit-2-fill"></i>';
                    $editBtn .= '</button></a>';

                    $deleteBtn = '<form action="' . route('superadmin.curriculum.destroy', $query->id) . '" method="POST">';
                    $deleteBtn .= csrf_field();
                    $deleteBtn .= method_field('DELETE');
                    $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                    $deleteBtn .= '</form>';

                    $btnContainer .= $showSubjects . $editBtn . $deleteBtn;
                    $btnContainer .= '</div>';
                    return $btnContainer;
                })
                // 1 to 1 relationship
                ->addColumn('campus_id', function ($query) {
                    $campuses = Campus::all();
                    foreach ($campuses as $campus) {
                        if ($query->campus_id == $campus->id) {
                            return $campus->description;
                        }
                    }
                })
                ->addColumn('course_id', function ($query) {
                    $courses = Course::all();
                    foreach ($courses as $course) {
                        if ($query->course_id == $course->id) {
                            return $course->code;
                        }
                    }
                })
                ->addColumn('status', function ($query) {
                    if ($query->status == 1) {
                        return '<h5><span class="badge bg-success">Active</h5>';
                    } else {
                        return '<h5><span class="badge bg-danger">Inactive</h5>';
                    }
                })
                ->addColumn('section', function ($query) {
                    return $query->section?->section_code;
                })
                ->rawColumns(['action', 'campus_id', 'course_id', 'status', 'section'])
                ->addIndexColumn()
                ->make(true);
        }
        $campus = Campus::all();
        $course = Course::all();
        $sections = Section::all();
        return view('Roles.Super_Administrator.functionality.offerings.curriculum.index', compact('campus', 'course', 'sections'));
        // return $dataTable->render('Roles.Super_Administrator.functionality.offerings.curriculum.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurriculumRequest $request)
    {
        $curriculums = new Curriculum([
            ...$request->only([
                'code',
                'description',
                'campus_id',
                'course_id',
                'effective',
                'expires',
                'status'
            ])
        ]);
        $curriculums->save();

        return redirect()->back()->with('success', 'Curriculum Add Success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (request()->ajax()) {
            return datatables()->of(CurriculumSubject::where('curriculum_id', $id)->get())
                ->addColumn('action', function ($query) {
                    $btnContainer = '<div class="d-flex justify-content-center">';


                    $deleteBtn = '<form action="' . route('superadmin.curriculum_subjects.destroy', $query->id) . '" method="POST">';
                    $deleteBtn .= csrf_field();
                    $deleteBtn .= method_field('DELETE');
                    $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                    $deleteBtn .= '</form>';

                    $btnContainer .= $deleteBtn;
                    $btnContainer .= '</div>';
                    return $btnContainer;
                })
                // 1 to 1 relationship

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('Roles.Super_Administrator.curriculum_subjects.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $curriculum = Curriculum::findOrFail($id);

        return view('Roles.Super_Administrator.curriculum_subjects.index', compact('curriculum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurriculumRequest $request, string $id)
    {
        // dd($request->all());
        $curriculums = Curriculum::findOrFail($id);
        $curriculums->update($request->only([
            'code',
            'description',
            'campus_id',
            'course_id',
            'effective',
            'expires',
            'status'
        ]));


        return redirect()->back()->with('success', 'Update Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $testing =  CurriculumSubject::where('curriculum_id', $id)->delete();
        // dd($testing);

        $curriculum->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }
    public function getCurriculumByCourse(string $course_id)
    {
        return Curriculum::where('course_id', $course_id)->where('status', 1)->select('id', 'code')->get();
    }
}
