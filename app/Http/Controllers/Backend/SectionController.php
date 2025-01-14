<?php

namespace App\Http\Controllers\Backend;

use App\Exports\InstructorReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\adddetails;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\Department;
use App\Models\instructor;
use App\Models\Section;
use App\Models\section_subjectss;
use App\Models\SectionSubject;
use App\Models\StudentsSection;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Matrix\Decomposition\QR;
use Termwind\Components\Dd;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $activeSchoolYears = DB::table('school_years')->where('status', 1)->get();
                if ($activeSchoolYears->isNotEmpty()) {
                    $sections = Section::withCount('studentSections')
                        ->where(function ($query) use ($activeSchoolYears) {
                            foreach ($activeSchoolYears as $schoolYear) {
                                $query->orWhere(function ($subQuery) use ($schoolYear) {
                                    $subQuery->where('semester', $schoolYear->semester)
                                        ->whereBetween('from', [$schoolYear->from, $schoolYear->to])
                                        ->orWhereBetween('to', [$schoolYear->from, $schoolYear->to]);
                                });
                            }
                        })
                        ->get();
                    // dd($sections);
                }

                return datatables()->of($sections)
                    ->addColumn('action', function ($query) {
                        $btnContainer = '<div class="d-flex justify-content-center">';
                        // $showSubjects = '<a class="btn btn-success waves-effect waves-light mx-1" onclick="throwID(' . $query->id . ')">Subjects</i></a>';
                        $showSubjects = '<a href="#" data-bs-toggle="modal" data-bs-target="#showsubject" onclick="ShowSCR(' . $query->id . ', \'' . $query->section_code . '\', \'' . $query->course_id . '\', \'' . $query->year_level . '\')">';
                        $showSubjects .= '<button type="button" class="btn btn-success waves-effect waves-light">';
                        $showSubjects .= '<i>Subject</i>';
                        $showSubjects .= '</button></a>';

                        $editBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editSection
                        (' . $query->id . ',\'' . $query->section_code . '\', \'' . $query->course_id . '\',\'' . $query->number_of_students . '\', \'' . $query->max_number_of_students . '\', 
                        \'' . $query->status . '\', \'' . $query->year_level . '\',\'' . $query->remarks . '\', \'' . $query?->departments?->description . '\', \'' . $query->semester . '\')">';
                        $editBtn .= '<button type="button" class="btn btn-primary waves-effect waves-light">';
                        $editBtn .= '<i class="ri-edit-2-fill"></i>';
                        $editBtn .= '</button></a>';

                        $deleteBtn = '<form action="' . route('superadmin.sections.destroy', $query->id) . '" method="POST">';
                        $deleteBtn .= csrf_field();
                        $deleteBtn .= method_field('DELETE');
                        $deleteBtn .= '<button class="btn btn-danger delete-item mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                        $deleteBtn .= '</form>';
                        $viewSubBtn = '<a href="#" data-bs-toggle="modal" data-bs-target="#viewStudentSectionModal" ' .
                            'onclick="studentSection(' . $query->id . ')">';
                        $viewSubBtn .= '<button type="button" class="btn btn-secondary waves-effect waves-light mx-1"><i class="ri-eye-fill"></i></button></a>';


                        $btnContainer .= $editBtn . $deleteBtn . $showSubjects . $viewSubBtn;
                        $btnContainer .= '</div>';
                        return $btnContainer;
                    })
                    ->addColumn('course_id', function ($query) {
                        $courses = Course::where('is_active', 1)->get();
                        foreach ($courses as $course) {
                            if ($query->course_id == $course->id) {
                                return $course->code;
                            }
                        }
                    })
                    ->addColumn('numberofstudents', function ($query) {

                        $currentDate = date('Y-m-d');

                        if ($query->from && $query->to && $currentDate >= $query->from && $currentDate <= $query->to) {

                            return $query->student_sections_count;
                        } else {

                            return 0;
                        }
                        return $query->student_sections_count;
                    })
                    ->addColumn('status', function ($query) {
                        if ($query->status == 0) {
                            return '<h5><span class="badge bg-success">Available</span></h5>';
                        } else {
                            if ($query->number_of_students >= $query->max_number_of_students) {
                                return '<h5><span class="badge bg-danger">Full</span></h5>';
                            } else {
                                return '<h5><span class="badge bg-success">Available</span></h5>';
                            }
                        }
                    })
                    ->rawColumns(['action', 'course_id', 'status', 'numberofstudents'])
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            dd($e);
        }
        // $sectionSubject = section_subjectss::findOrFail($id);
        $courses = Course::where('is_active', 1)->get();
        $curriculums = Curriculum::all();
        $instructors = instructor::all();
        $department = Department::all();
        $coursess = Course::all();
        $sections = Section::all();
        $campus = Campus::all();

        $activeSchoolYear = DB::table('school_years')->where('status', 1)->first();
        return view('Roles.Super_Administrator.sections.index', compact('courses', 'curriculums', 'instructors', 'department', 'coursess', 'sections', 'activeSchoolYear', 'campus'));
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
    public function store(SectionRequest $request)
    {
        // dd($request->all());
        $request->validate(Section::$rules);
        $sections = new Section([
            ...$request->only([
                'section_code',
                'course_id',
                'semester',
                'year_level',
                'semester',
                'number_of_students',
                'max_number_of_students',
                'status',
                'department_id',
                'remarks',
                'from',
                'to',
                'school_year'
            ])
        ]);
        $sections->save();
        return back()->with('success', 'Section Add Success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        if (request()->ajax()) {
            return datatables()->of(SectionSubject::where('section_id', $id)->get())
                ->addColumn('action', function ($query) {
                    $btnContainer = '<div class="d-flex justify-content-center">';

                    $deleteBtn = '<form action="' . route('superadmin.delete.Subject', $query->id) . '" method="POST">';
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
        return view('Roles.Super_Administrator.section_subjects.index');
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
    public function update(SectionRequest $request, string $id)
    {
        $sections = Section::findOrFail($id);
        $sections->update($request->only([
            'section_code',
            'semester',
            'course_id',
            'year_level',
            'number_of_students',
            'max_number_of_students',
            'status',
            'remarks',
            'department_id'
        ]));
        $sections->save();

        return back()->with('success', 'Section Update Success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sections = Section::findOrFail($id);
        $sections->delete();
        return response(['status' => 'success', 'message', 'Section Deleted Successfully']);
    }
    public function getSectionByCourse(string $course_id)
    {
        return Curriculum::where('course_id', $course_id)->where('status', 1)->select('id', 'section_code')->get();
    }
    public function updateDetails(Request $request, string $id)
    {
        // dd($request->all());

        $adddetails = adddetails::findOrFail($id);
        $adddetails->update($request->only([
            'time',
            'day',
            'room',
            'instructor_id',
            'email',
            'section_id'
        ]));
        $adddetails->save();

        // return back()->with('success', 'Section Update Success');
        return response(['status' => 'success', 'message' => 'Edit Successfully']);
    }
    public function getSubjectWithInstructor(Request $request)
    {
        $subject_id = $request->input('subject_id');

        $viewTable = adddetails::with('subjectsss')
            ->where('subject_id', $subject_id)
            ->select(['instructor_id', 'time', 'day', 'room', 'subject_id'])
            ->get();

        // dd($viewTable);
        if (request()->ajax()) {
            return datatables()->of($viewTable)
                ->addColumn('instructor', function ($query) {
                    return $query?->instructorss?->full_name;
                })
                ->addColumn('semester', function ($query) {
                    return $query->subjectsss ? $query->subjectsss->semester_id : 'N/A';
                })
                // 1 to 1 relationship
                ->rawColumns(['instructor', 'semester'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function getStudentSection(Request $request)
    {

        $section_id = $request->input('section_id');


        $section = Section::where('id', $section_id)->first();


        $currentDate = date('Y-m-d');


        $viewTable = collect([]);

        if ($section && $section->from && $section->to) {
            $fromDate = $section->from;
            $toDate = $section->to;
            if ($currentDate >= $fromDate && $currentDate <= $toDate) {

                $viewTable = StudentsSection::where('section_id', $section_id)->get();
                // dd($viewTable);
            }
        }
        // Return the data via Yajra DataTables
        if ($request->ajax()) {
            return datatables()->of($viewTable)
                ->addColumn('section', function ($query) {
                    return $query->section ? $query->section->section_code : '';
                })
                ->rawColumns(['section', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function getSectionSub(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'school_year' => 'required|string',
            'curriculum_id' => 'required|integer|exists:curricula,id',
            'year_level' => 'required|integer',
            'semester_id' => 'required',
            'section_code' => 'required',
            'section_id' => 'required',
            'course_id' => 'required',
            'campus_id' => 'required',
        ]);

        $school_year = $request->input('school_year');
        $subjects = CurriculumSubject::with(['sections', 'latestDetailOfSubject', 'detailsofsubjects'])
            ->where('curriculum_id', $request->curriculum_id)
            ->where('year_level', $request->year_level)
            ->where('semester_id', $request->semester_id)
            ->get();

        $sectionID = Section::where('section_code', $request->section_code)
            ->first()->id;

        foreach ($subjects as $subj) {
            $ex = section_subjectss::where('section_id', $request->section_id)
                ->where('subject_id', $subj->id)
                ->exists();

            if (!$ex) {
                section_subjectss::create([
                    'course_id' => $request->course_id,
                    'year_level' => $subj->year_level,
                    'curriculum_id' => $subj->curriculum_id,
                    'semester_id' => $request->semester_id,
                    'subject_id' => $subj->id,
                    'code' => $subj->code,
                    'descriptive_tittle' => $subj->descriptive_tittle,
                    'total_units' => $subj->total_units,
                    'lecture_units' => $subj->lecture_units,
                    'lab_units' => $subj->lab_units,
                    'pre_requisite' => $subj->pre_requisite,
                    'total_hrs_per_week' => $subj->total_hrs_per_week,
                    'department_id' => $subj->department_id,
                    'time' => $subj->time,
                    'day' => $subj->day,
                    'room' => $subj->room,
                    'lab_id' => $subj->lab_id,
                    'section_id' => $request->section_id,
                    'school_year' => $school_year,
                    'campus_id' => $request->campus_id
                ]);
            }
        }

        return response(['success' => '']);
    }

    public function getSectionSubs($section_code, $year_level, $semester_id, $school_year, Request $request)
    {
        if (request()->ajax()) {
            $sectionID = Section::where('section_code', $section_code)->first()->id;
            $subjects = section_subjectss::where('section_id', $request->section_id)
                ->where('year_level', $year_level)
                ->where('semester_id', $semester_id)
                ->where('is_active', false)
                ->with('adddetails')
                ->get();

            $subjects->each(function ($subject) use ($school_year) {
                if ($subject->adddetails) {
                    $subject->filtered_adddetails = $subject->adddetails->where('school_year', $school_year)->first();
                } else {
                    $subject->filtered_adddetails = null;
                }
            });

            $datatables = datatables()->of($subjects)
                ->addIndexColumn()
                ->addColumn('action', function ($query) {
                    $btncontainer = '<div class="d-flex justify-content-center">';

                    $addDetails = '<a href="#">';
                    $addDetails .= '<button type="button" class="btn btn-primary waves-effect waves-light OpenModal" onclick="hasAction(' . $query->id . ',\'' . $query->time . '\', \'' . $query->room . '\', \'' . $query->day . '\', \'' . $query->instructor_id . '\', 
                    \'' . $query->section_id . '\', \'' . $query->subject_id . '\', \'' . $query?->adddetails?->id . '\')">';
                    $addDetails .= '+/Edit';
                    $addDetails .= '</button></a>';

                    $deleteBtn = '<form action="' . route('superadmin.delete.Subject', $query->id) . '" method="POST">';
                    $deleteBtn .= csrf_field();
                    $deleteBtn .= method_field('DELETE');
                    $deleteBtn .= '<button class="btn btn-danger delete-itemss mx-1" type="submit"><i class="ri-delete-bin-fill"></i></button>';
                    $deleteBtn .= '</form>';

                    $btncontainer .= $addDetails  . $deleteBtn;
                    $btncontainer .= '</div>';

                    return $btncontainer;
                })
                ->addColumn('time', function ($query) use ($school_year) {

                    $addDetail = $query->adddetailss?->where('subject_id', $query->subject_id)
                        ->where('school_year', $school_year)
                        ->first();
                    return $addDetail->time ?? '-';
                })
                ->addColumn('day', function ($query) use ($school_year) {

                    $addDetail = $query->adddetailss?->where('subject_id', $query->subject_id)
                        ->where('school_year', $school_year)
                        ->first();
                    return $addDetail->day ?? '-';
                })
                ->addColumn('room', function ($query) use ($school_year) {

                    $addDetail = $query->adddetailss?->where('subject_id', $query->subject_id)
                        ->where('school_year', $school_year)
                        ->first();
                    return $addDetail->room ?? '-';
                })
                ->addColumn('instructor', function ($query) use ($school_year) {

                    $addDetail = $query->adddetailss?->where('subject_id', $query->subject_id)
                        ->where('school_year', $school_year)
                        ->first();
                    return $addDetail?->instructorss->full_name ?? '-';
                })
                ->addColumn('department', function ($query) {
                    return $query->latestDetailOfSubject?->instructorss?->department_id ?? '-';
                })
                ->rawColumns(['action', 'time', 'day', 'room', 'instructor', 'department']);

            return $datatables->make(true);
        }
    }

    public function addSectionSub(Request $request)
    {
        // dd($request->all());
        $sectionID = Section::where('section_code', $request->section_code)
            ->first()->id;
        $ex = section_subjectss::where('section_id', $sectionID)
            ->where('subject_id', $request->subject_id)
            ->exists();

        if ($ex) {
            return response(['error' => 'Already exists in the section.']);
        }

        section_subjectss::create([
            ...$request->all(),
            'section_id' => $sectionID,
        ]);

        return response(['success' => 'Added Successfully']);
    }

    public function deleteSubject(String $id)
    {
        // dd($id);
        // $deleteSection  = section_subjectss::findOrFail($id);
        // $deleteSection->is_active = true;
        // $deleteSection->save();
        // return response(['success' => 'Delete Successfully']);
        $subject = section_subjectss::find($id);
        if ($subject) {
            $subject->is_active = true;
            $subject->save();
            return response()->json(['status' => 'success', 'message' => 'Subject deactivated successfully.']);
        }
        return response()->json(['status' => 'error', 'message' => 'Subject not found.']);
    }
    public function instructorHandles(Request $request)
    {
        if ($request->ajax()) {

            // dd($request->all());
            $instructorID = $request->input('id'); // Ensure this is an array
            $query = adddetails::where('instructor_id', $instructorID)
                ->select('section_id')
                ->distinct()
                ->with('sections')
                ->get();
            if ($query->isEmpty() || $query->contains(function ($item) {
                return $item->sections === null;
            })) {
                return response()->json([
                    'success' => false,

                ]);
            }
            $datatables = datatables()->of($query)


                ->addColumn('section', function ($query) {
                    return $query?->sections?->section_code;
                })
                ->addColumn('action', function ($query) {
                    $btnContainer = '<div class="d-flex justify-content-center">';


                    // $showSection = '<a class="btn btn-success waves-effect waves-light  onclick="sectionID(' . $query->sections->id . ')">Subjects</i></a>';

                    $sectionId = $query->sections->id;
                    $url = route('superadmin.sec.sub', ['id' => $sectionId]);
                    $button = '<a href="' . $url . '">';
                    $button .= '<button type="button" class="btn btn-success waves-effect waves-light" onclick="handleSectionWithSub(' . $sectionId . ')">';
                    $button .= 'Subjects';
                    $button .= '</button></a>';
                    return $button;

                    $btnContainer .= $sectionId;

                    $btnContainer .= '</div>';
                    return $btnContainer;
                })
                ->rawColumns(['action', 'section']);
            return $datatables->make(true);
        }
    }
    public function secSub(Request $request, $id)
    {

        $section = Section::find($id);

        return view('Roles.Super_Administrator.instructor.sectionSubject', compact('section'));
    }
    public function secwithSub(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $sectionID = $request->input('id');
            $instructorId = $request->input('instructor_id');


            $sectionSubject = adddetails::where('section_id', $sectionID)
                ->select('subject_id')
                ->where('instructor_id', $instructorId)
                ->get();
            // dd($sectionSubject);
            $datatables = datatables()->of($sectionSubject)
                // ->addIndexColumn()

                ->addColumn('section', function ($query) {
                    return $query?->subjectsss?->descriptive_tittle;
                })
                ->addColumn('action', function ($query) {
                    // return $query?->subjectsss?->descriptive_tittle;

                    $SubjectID = $query->subject_id;

                    $url = route('superadmin.students.enrolledSub', ['id' => $SubjectID]);
                    $button = '<a href="' . $url . '">';
                    $button .= '<button type="button" class="btn btn-secondary waves-effect waves-light" onclick="EnrolledStudentsSubject(' . $SubjectID . ')">';
                    $button .= 'Students Enrolled';
                    $button .= '</button></a>';
                    return $button;
                })

                ->rawColumns(['action', 'section']);
            return $datatables->make(true);
        }
    }
    public function studentsSubjectEnrolled(Request $request, $id)
    {
        $studentEnrolledSubject = Adddetails::where('subject_id', $id)->first();

        // dd($studentEnrolledSubject);

        return view('Roles.Super_Administrator.instructor.viewStudentSubjectEnrolled', compact('studentEnrolledSubject'));
    }
    public function enrolledStudentonSubject(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $instructorId = $request->input('instructor_id');
            $subjectID = $request->input('id');

            // Get the Adddetails with related student subjects and students
            $sectionSubjects = Adddetails::with('student_subjects.student')
                ->where('instructor_id', $instructorId)
                ->where('subject_id', $subjectID)
                ->get();

            // Flatten the data
            $data = [];
            foreach ($sectionSubjects as $detail) {
                foreach ($detail->student_subjects as $studentSubject) {
                    // dd($studentSubject?->course?->code);
                    if ($studentSubject->student) {
                        $data[] = [
                            'id_number' => $studentSubject->student->id_number,
                            'course_id' => $studentSubject?->course?->code,
                            'semester' => $studentSubject->semester,
                            'school_year' => $studentSubject?->schoolYear?->code,
                            'last_name' => $studentSubject->student->last_name,
                            'first_name' => $studentSubject->student->first_name,
                            'grade' => $studentSubject->grade,
                        ];
                    }
                }
            }

            // Return the data to DataTables
            return datatables()->of($data)->make(true);
        }
    }
    public function savegrade(Request $request)
    {
        $idNumber = $request->input('id_number');
        $field = $request->input('field');
        $value = $request->input('value');
        $subjectId = $request->input('subject_id');
        $semester = $request->input('semester');

        $studentSubject = StudentSubject::where('id_number', $idNumber)
            ->where('semester', $semester)
            ->where('subject_id', $subjectId)
            ->first();

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;
        $dt = Carbon::now('Asia/Manila');

        if ($studentSubject) {
            $existingValue = $studentSubject->$field;

            // Update the field
            $studentSubject->$field = $value;
            $studentSubject->save();

            // Check if the field had a value before
            $modifyAction = $existingValue ? 'Edit Grade to student ID Number ' : 'Add Grade to student ID Number ';

            // Update log
            $activityLog = [
                'username' => $user->name,
                'email' => $user->email,
                'role_name' => $roleName,
                'modify_user' => $modifyAction . $idNumber,
                'date_time' => $dt->format('D, M j, Y g:i A'),
            ];

            DB::table('activity_logs')->insert($activityLog);

            return response()->json(['success' => true]);
        }
    }
    public function  adddates(Request $request)
    {
        // dd($request->all());
        //validate
        $request->validate([
            'year_level' => 'required',
            'from' => 'date|required',
            'to' =>  'date|required',
        ]);
        $sections = Section::where('year_level', $request->year_level)
            ->get();
        // dd($sections);

        foreach ($sections as $section) {
            $section->from = $request->from;
            $section->to = $request->to;
            $section->save();
        }
        return back()->with('success', 'Added Successfully');
    }
    public function sectionSubject(Request $request)
    {

        // dd($request->school_year);
        if (request()->ajax()) {
            $sectionSubjects = section_subjectss::whereIn('school_year', $request->school_year)->get();


            return datatables()->of($sectionSubjects)
                ->addColumn('section', function ($query) {
                    return $query?->section?->section_code;
                })
                ->addColumn('lab_id', function ($query) {
                    return $query?->laboratory?->description;
                })
                ->addColumn('instructor', function ($query) {
                    return $query?->instructor?->full_name;
                })
                ->addColumn('action', function ($query) {
                    // Create button HTML for DataTable action column
                    $addbtn = '<button type="button" id="addSubjectButton" class="btn btn-success" onclick="addSubject2( ' . $query->subject_id . ', 
                    \'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \'' . $query->total_units . '\', 
                    \'' . $query->lecture_units . '\', \'' . $query->lab_units . '\', \'' . $query->pre_requisite . '\', 
                    \'' . $query->total_hrs_per_week . '\', \'' . $query->time . '\', \'' . $query->day . '\', \'' . $query->room . '\', \'' . $query->lab_id . '\', \'' . $query->instructor?->full_name . '\')">+</button>';

                    return $addbtn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function sectionSubjectview(Request $request)
    {
        if (request()->ajax()) {
            $sectionSubjects = section_subjectss::whereIn('school_year', $request->school_year)->get();
            // dd($sectionSubjects);

            return datatables()->of($sectionSubjects)
                ->addColumn('section', function ($query) {
                    return $query?->section?->section_code;
                })
                ->addColumn('instructor_id', function ($query) {
                    return $query?->instructor?->full_name;
                })
                ->addColumn('action', function ($query) {

                    $addbtn = '<button type="button" id="addSubjectViewButton" class="btn btn-success" onclick="addonStudentSubject2('
                        . $query->id . ',\'' . $query->code . '\', \'' . $query->descriptive_tittle . '\', \''
                        . $query->total_units . '\', \'' . $query->lecture_units . '\', \'' . $query->lab_units . '\', 
                        \'' . $query->pre_requisite . '\', \'' . $query->total_hrs_per_week . '\', \'' . $query->lab_id . '\', 
                        \'' . $query?->create_account?->curriculum_id . '\', \'' . $query?->create_account?->course_id . '\', 
                        \'' . $query?->create_account?->campus_id . '\', \'' . $query?->create_account?->id_number . '\', 
                        \'' . $query?->studentSubjects?->year_level . '\', \'' . $query?->studentSubjects?->semester . '\',
                        \'' . $query?->studentSubjects?->section_id . '\',\'' . $query?->studentSubjects?->department_id . '\',
                         \'' . $query?->studentSubjects?->school_year . '\',  \'' . $query->subject_id . '\',
                         
                         )">+</button>';

                    return $addbtn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function getSectionId(Request $request)
    {

        $instructor_id = $request->input('instructor_id');
        $semester = $request->input('semester');


        //query 
        $details = adddetails::where('instructor_id', $instructor_id)
            ->where('semester', $semester)
            ->first();

        if ($details) {
            return response()->json(['section_id' => $details->sections?->section_code]);
        } else {
            return response()->json(['section_id' => null]);
        }
    }
    public function getIWSH(Request $request)
    {

        $instructor = $request->input('instructor');
        $semester = $request->input('semester');
        $section = $request->input('section');
        $schoolYear = $request->input('schoolyear');
        $subjects = $request->input('subjects');

        if ($subjects) {
            $studentData = adddetails::where('subject_id', $subjects)
                ->with(['instructorss', 'schoolYear', 'sections', 'subjects'])
                ->get();
        } else {
            $instructorQuery = instructor::where('full_name', $instructor)->first()->id;

            $studentData = adddetails::where('instructor_id', $instructorQuery)
                ->where('semester', $semester)
                ->where('section_id', $section)
                ->where('school_year', $schoolYear)
                ->with(['instructorss', 'schoolYear', 'sections', 'subjects'])
                ->get();
        }
        foreach ($studentData as $detail) {
            $students = StudentSubject::where('semester', $detail->semester)
                ->where('section_id', $detail->section_id)
                ->where('school_year', $detail->school_year)
                ->where('subject_id', $detail->subject_id)
                ->with('create_accountss')
                ->get();

            $detail->subjects->create_accountss = $students;
        }

        return Excel::download(new InstructorReportExport($studentData, $students), 'InstructorReport.xlsx');
    }
    public function getsubsec(Request $request)
    {

        $validatedData = $request->validate([
            'section_id' => 'required|integer',
            'instructor_id' => 'required',
        ]);

        $instructor = instructor::where('full_name', $validatedData['instructor_id'])
            ->first()->id;



        $subjects = adddetails::where('section_id', $validatedData['section_id'])
            ->where('instructor_id', $instructor)
            ->with('subject')
            ->get();

        return response()->json([
            'subjects' => $subjects->map(function ($adddetail) {
                return [
                    'subject_id' => $adddetail->subject_id,
                    'subject_name' => $adddetail->subject ? $adddetail->subject->descriptive_tittle : null,
                ];
            }),
        ]);
    }
}
