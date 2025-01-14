<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CourseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CreateAccount;
use App\Models\Department;
use App\Models\Level;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        try {
            if (request()->ajax()) {

                return datatables()->of(Course::all())
                    ->addColumn('action', function ($query) {
                        $btnContainer = '<div class="d-flex justify-content-center">';

                        $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editCourses
                        (' . $query->id . ',\' ' . $query->code . ' \', \'' . $query->description . '\', \'' . $query->campus_id . '\', 
                        \'' . $query->department_id . '\', \'' . $query->max_units . '\', \'' . $query->is_offered . '\', \'' . $query->is_active . '\')">';
                        $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                        $editBtn .= '<i class="ri-edit-2-fill"></i>';
                        $editBtn .= '</button></a>';



                        $deleteBtn = '<form action="' . route('superadmin.courses.destroy', $query->id) . '" method="POST">';
                        $deleteBtn .= csrf_field();
                        $deleteBtn .= method_field('DELETE');
                        $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                        $deleteBtn .= '</form>';

                        $btnContainer .= $editBtn . $deleteBtn;
                        $btnContainer .= '</div>';
                        return $btnContainer;
                    })
                    ->addColumn('is_active', function ($query) {
                        if ($query->is_active == 1) {
                            return $statusColumn = '<h5><span class="badge bg-success">Active</span></h5>';
                        } else {
                            return $statusColumn = '<h5><span class="badge bg-danger">Inactive</span></h5>';
                        }
                    })
                    // ->addColumn('level_id', function ($query) {
                    //     $levels = Level::all();
                    //     foreach ($levels as $level) {
                    //         if ($query->level_id == $level->id) {
                    //             return $level->description;
                    //         }
                    //     }
                    // })
                    ->addColumn('campus_id', function ($query) {
                        $campuses = Campus::all();
                        foreach ($campuses as $campus) {
                            if ($query->campus_id == $campus->id) {
                                return $campus->description;
                            }
                        }
                    })
                    ->addColumn('department_id', function ($query) {
                        $departments = Department::all();
                        foreach ($departments as $department) {
                            if ($query->department_id == $department->id) {
                                return $department->description;
                            }
                        }
                    })
                    ->addColumn('is_offered', function ($query) {
                        if ($query->is_offered == 1) {
                            return '<h5><span class="badge bg-success">Yes</span></h5>';
                        } else if ($query->is_offered == 0) {
                            return '<h5><span class="badge bg-danger">No</span></h5>';
                        }
                    })
                    ->rawColumns(['action', 'is_active', 'level_id', 'campus_id', 'is_offered'])
                    ->addIndexColumn()
                    ->make(true);
            }
            $courses = Course::all();
            $campus = Campus::all();
            $departments = Department::all();
            return view('Roles.Super_Administrator.courses.index', compact('courses', 'campus', 'departments'));
        } catch (\Exception $e) {
            dd($e);
        }
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
    public function store(CourseRequest $request)
    {
        $courses = new Course([
            ...$request->only([
                'code',
                'description',
                'campus_id',
                'department_id',
                'max_units',
                'is_offered',
                'is_active'
            ])
        ]);
        $courses->save();

        return redirect()->back()->with('success', 'Course Add Success!');
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
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->only([
            'code',
            'description',
            'level_id',
            'campus_id',
            'department_id',
            'max_units',
            'is_offered',
            'is_active'
        ]));
        $course->save();

        return back()->with('success', 'Course Update Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully']);
    }

    public function getCourseData()
    {

        try {
            $studentAccount = CreateAccount::with('course')
                ->get()
                ->groupBy('course_id');

            $data = [
                'labels' => [],
                'data' => [],
            ];
            foreach ($studentAccount as $courseId => $accountsPerCourse) {
                $course = $accountsPerCourse->first()->course;
                $data['labels'][] = $course->code;
                $data['data'][] = $accountsPerCourse->count();
            }

            return response()->json($data);
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function getMaleFemale()
    {
        $studentCounts = CreateAccount::where('status', 'OFFICIALLY ENROLLED')
            ->selectRaw('SUM(CASE WHEN gender = "Male" THEN 1 ELSE 0 END) as Male, 
                     SUM(CASE WHEN gender = "Female" THEN 1 ELSE 0 END) as Female')
            ->first();
        return response()->json(['data' => $studentCounts->Male + $studentCounts->Female, 'Female' => $studentCounts->Female, 'Male' => $studentCounts->Male]);;
    }
    public function createaccount(Request $request)
    {
        if ($request->ajax()) {
            $data = CreateAccount::with('course', 'student_subject')
                ->where('status', 'OFFICIALLY ENROLLED')
                ->get();
            $datatables = datatables()->of($data)
                ->addIndexColumn()

                ->addColumn('course', function ($query) {
                    return $query?->course?->code;
                })
                ->addColumn('year_level', function ($query) {
                    return $query?->student_subject?->year_level;
                })
                ->addColumn('section', function ($query) {
                    return $query?->student_subject?->section?->section_code;
                })

                ->addColumn('action', function ($query) {
                    // $addbtn = '<button type="button" id="PrintStudentWithGrades" class="btn btn-success" 
                    //     )"><i class="ri-download-line"></i></button>';
                    // return $addbtn;
                    $printStudentSubject = route('superadmin.generate.printStudentSubject', $query->id);

                    $downloadBtn = '<a href="' . $printStudentSubject . '" class="btn btn-success"><i class="ri-download-line"></i></a>';
                    return $downloadBtn;
                })

                ->rawColumns(['action']);
            return $datatables->make(true);
        }
    }
}
