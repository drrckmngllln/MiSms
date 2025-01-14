<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubjectDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Campus;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\Department;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubjectDataTable $dataTable)
    {
        return $dataTable->render('Roles.Super_Administrator.subjects.index');

        // if (request()->ajax()){
        //     return datatables()->of(Subject::all())
        //         ->addColumn('action', function($query){
        //             $actionbtn = '';
        //         })
        //         ->rawColumns(['action'])
        //         ->addIndexColumn()
        //         ->make(true);
        // }
        // return view('Roles.Super_Administrator.subjects.index');
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
    public function store(SubjectRequest $request)
    {
        $subjects = new Subject([
            ...$request->only([
                'semester_id', 'code', 'descriptive_tittle', 'total_units', 'lecture_units', 'lab_units',
                'pre_requisite', 'total_hrs_per_week', 'is_active'
            ])
        ]);
        $subjects->save();

        return back()->with('success', 'Subject Add Success!');
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
        $subject = Subject::findOrFail($id);
        $request->validate([
            'code' => ['required', 'unique:subjects,code,' . $subject->id],
            'descriptive_tittle' => ['required'],
            'total_units' => ['required', 'numeric'],
            'lecture_units' => ['required', 'numeric'],
            'lab_units' => ['required', 'numeric'],
            'pre_requisite' => ['required'],
            'total_hrs_per_week' => ['required'],
            'is_active' => ['required']
        ]);
        $subject->code = $request->code;
        $subject->descriptive_tittle = $request->descriptive_tittle;
        $subject->total_units = $request->total_units;
        $subject->lecture_units = $request->lecture_units;
        $subject->lab_units = $request->lab_units;
        $subject->pre_requisite = $request->pre_requisite;
        $subject->total_hrs_per_week = $request->total_hrs_per_week;
        $subject->is_active = $request->is_active;
        $subject->save();

        return back()->with('success', 'Subject Update Success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $subject = Subject::findOrFail($id);
        $subject->delete();
        return response(['status' => 'success', 'message', 'Deleted Successfully']);
    }
    public function getSubjectBySemester($curriculum_id, $semester_id, $year_level, Request $request, $section_code)
    {
        try {
            if (request()->ajax()) {

                $section_code = $request->input('section_code');
                $section = Section::where('section_code', $section_code)->first();

                $subjects = CurriculumSubject::with(['sections', 'latestDetailOfSubject', 'detailsofsubjects' => function ($query) {
                    $query->latest()->limit(1)->get();
                }])
                    ->where('curriculum_id', $curriculum_id)
                    ->where('year_level', $year_level)
                    ->where('semester_id', $semester_id)

                    ->get();
                // dd($subjects);

                $subjects->load(['detailsofsubjects' => function ($query) use ($section) {
                    $query->where('section_id', $section->id);
                }]);
                if ($subjects->isNotEmpty()) {
                    foreach ($subjects as $subject) {
                        foreach ($subject->sections as $section) {
                            if ($section->pivot->section_id === $section_code) {
                                $subject->detailsofsubjects()->update([
                                    'time' => null,
                                    'day' =>  null,
                                    'room' => null,
                                    'instructor_id' => null,
                                    'department' => null,
                                ]);
                            }
                        }
                    }
                }
                $datatables = datatables()->of($subjects)
                    ->addIndexColumn()
                    ->addColumn('action', function ($query) {
                        $addDetails = '<a href="#">';
                        $addDetails .= '<button type="button" class="btn btn-primary waves-effect waves-light OpenModal" onclick="hasAction(' . $query->id . ')">';
                        $addDetails .= '+';
                        $addDetails .= '</button></a>';

                        $view = '<a href="#">';
                        $view .= '<button type="button" class="btn btn-primary waves-effect waves-light OpenModal3" onclick="view(' . $query->id . ')">';
                        $view .= '<i class="ri-eye-fill"></i>';
                        $view .= '</button></a>';

                        $editbtn = '<a href="#">';
                        $editbtn .= '<button type="button" class="btn btn-primary waves-effect waves-light mx-1 OpenModal2" onclick="hasActionedit(' . $query?->latestDetailOfSubject?->id . ',\'' . $query?->latestDetailOfSubject?->time . '\', \'' . $query?->latestDetailOfSubject?->section_id . '\',\'' . $query?->latestDetailOfSubject?->day . '\',\'' . $query?->latestDetailOfSubject?->room . '\', \'' . $query?->latestDetailOfSubject?->instructor_id . '\',\'' . $query?->latestDetailOfSubject?->email . '\')">';
                        $editbtn .= 'Edit';
                        $editbtn .= '</button></a>';

                        return $addDetails . $editbtn . $view;
                        // $addDetails = '<a href="#" class="OpenModal" data-id="' . $query->id . '">';
                        // $addDetails .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                        // $addDetails .= '+';
                        // $addDetails .= '</button></a>';
                        // return $addDetails;
                    })
                    ->addColumn('time', function ($query) {
                        return $query->latestDetailOfSubject?->time;
                        // return $query->detailsofsubjects ? $query->detailsofsubjects->time : '';
                    })
                    ->addColumn('day', function ($query) {
                        return $query->latestDetailOfSubject?->day;
                    })
                    ->addColumn('room', function ($query) {
                        return $query->latestDetailOfSubject?->room;
                    })
                    ->addColumn('instructor_id', function ($query) {
                        return $query->latestDetailOfSubject?->instructorss->full_name;
                    })
                    ->addColumn('department', function ($query) {
                        return $query->latestDetailOfSubject?->instructorss?->department_id;
                    })

                    ->rawColumns(['action', 'time', 'day', 'room', 'instructor_id', 'department']);
                return $datatables->make(true);

                // $datatables = datatables()->of($subjects)
                //     ->addIndexColumn()
                //     ->addColumn('action', function ($query) {
                //         $addDetails = '<a href="#">';
                //         $addDetails .= '<button type="button" class="btn btn-primary waves-effect waves-light OpenModal" onclick="hasAction(' . $query->id . ')">';
                //         $addDetails .= '+';
                //         $addDetails .= '</button></a>';
                //         return $addDetails;
                //     })
                //     ->addColumn('time', function ($query) use ($section_code) {
                //         // if ($query->sections->contains('pivot.section_id', $section_code)) {
                //         //     return $query->detailsofsubjects?->time;
                //         // } else {
                //         //     return '';
                //         // }
                //         // return
                //         $query->detailsofsubjects()->where('subject_id', $section_code)->where('section_id', $section_code)->first()->time;
                //         // dd($query->detailsofsubjects);
                //     })
                //     ->addColumn('day', function ($query) use ($section_code) {
                //         if ($query->sections->contains('pivot.section_id', $section_code)) {
                //             return $query->detailsofsubjects?->day;
                //         } else {
                //             return '';
                //         }
                //     })
                //     ->addColumn('room', function ($query) use ($section_code) {
                //         if ($query->sections->contains('pivot.section_id', $section_code)) {
                //             return $query->detailsofsubjects?->day;
                //         } else {
                //             return '';
                //         }
                //     })
                //     ->addColumn('instructor_id', function ($query) use ($section_code) {
                //         if ($query->sections->contains('pivot.section_id', $section_code)) {
                //             return $query->detailsofsubjects?->instructorss->full_name;
                //         } else {
                //             return '';
                //         }
                //     })

                //     ->rawColumns(['action', 'time', 'day', 'room', 'instructor_id', 'department']);

                // return $datatables->make(true);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
