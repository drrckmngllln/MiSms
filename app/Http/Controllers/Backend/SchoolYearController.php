<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SchoolYearDataTable;
use App\Exports\IndividualStudentExport;
use App\Http\Controllers\Controller;
use App\Models\adddetails;
use App\Models\CreateAccount;
use App\Models\instructor;
use App\Models\SchoolYear;
use App\Models\Section;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SchoolYearDataTable $dataTable)
    {
        //
        return $dataTable->render('Roles.Super_Administrator.school_year.index');
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

        $request->validate(SchoolYear::$rules);


        if ($request->apply_all) {

            $activeSchoolYear = DB::table('school_years')->where('status', 1)->exists();

            if ($activeSchoolYear) {

                return back()->with('alert', 'Deactivate all School Year Status before proceeding.');
            }
            DB::beginTransaction();
            try {
                $nextSchoolYearId = DB::table('school_years')->max('id') + 1;
                $sections = Section::where('semester', $request->semester)->get();
                foreach ($sections as $section) {
                    DB::table('sections')->insert([
                        'section_code' => $section->section_code,
                        'semester' => $section->semester,
                        'course_id' => $section->course_id,
                        'year_level' => $section->year_level,
                        'number_of_students' => $section->number_of_students,
                        'max_number_of_students' => $section->max_number_of_students,
                        'status' => $section->status,
                        'department_id' => $section->department_id,
                        'remarks' => $section->remarks,
                        'from' => $request->from,
                        'to' => $request->to,
                        'school_year' => $nextSchoolYearId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'An error occurred: ' . $e->getMessage());
            }



            // Update cutoff date logic
            $cutoffDate = now()->subDay();

            Section::where('semester', $request->semester)
                ->where('created_at', '<', $cutoffDate)
                ->update([
                    'from' => $request->from,
                    'to' => $request->to
                ]);
        }

        $schoolyear = new SchoolYear([
            ...$request->only([
                'code',
                'description',
                'from',
                'to',
                'semester',
                'status'
            ])
        ]);


        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Creating School Year Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);
        $schoolyear->save();


        $request->session()->flash('success', 'School Year Added Successfully');


        return redirect()->back();
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
        // dd($request->all());
        $request->validate(SchoolYear::$rules);
        $schoolyear = SchoolYear::findOrFail($id);
        $schoolyear->update(
            $request->only(['code', 'description', 'from', 'to', 'semester', 'status'])
        );


        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update School Year Entry '  . $request->code . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);


        $schoolyear->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $schoolyear = SchoolYear::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete School Year Entry '  . $schoolyear->code . ' ' . $schoolyear->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);


        $schoolyear->delete();

        return response(['status' => 'success', 'message', 'School Year Deleted Successfully']);
    }
    public function getSemester(String $id)
    {
        $schoolYear = SchoolYear::find($id);

        if ($schoolYear) {
            return response()->json(['semester' => $schoolYear->semester]);
        } else {
            return response()->json(['error' => 'School year not found'], 404);
        }
    }
    public function getActiveYear()
    {
        $activeYears = SchoolYear::where('status', 1)->get();
        return response()->json(['activeYears' => $activeYears]);
    }
    public function getActiveYearins(Request $request)
    {
        $activeYear = SchoolYear::where('status', 1)->first();
        $instructors = adddetails::where('school_year', $activeYear->id)
            ->with('instructorss')
            ->get();

        $instructorNames = $instructors->pluck('instructorss.full_name')->unique();

        return response()->json([
            'activeYears' => [$activeYear],
            'instructors' => $instructorNames
        ]);
    }
    public function getSectionBySchoolYearInstructor(Request $request)
    {
        $validatedData = $request->validate([
            'school_year_id' => 'required|integer',
            'instructor_id' => 'required|string',
            'semester' => 'required|string',
        ]);

        $instructor = instructor::where('full_name', $validatedData['instructor_id'])->first();

        if (!$instructor) {
            return response()->json(['error' => 'Instructor not found'], 404);
        }

        $sections = adddetails::where('school_year', $validatedData['school_year_id'])
            ->where('instructor_id', $instructor->id)
            ->where('semester', $validatedData['semester'])
            ->with('sections')
            ->select('section_id', DB::raw('COUNT(subject_id) as subject_count'))
            ->groupBy('section_id')
            ->get();

        return response()->json([
            'sections' => $sections->map(function ($adddetail) {
                return [
                    'section_id' => $adddetail->section_id,
                    'section_code' => $adddetail->sections->section_code,
                    'subject_count' => $adddetail->subject_count,
                ];
            }),
        ]);
    }
    public function individualStudents(Request $request)
    {
        $validatedData = $request->validate([
            'studentName' => 'required|integer',
            'semester' => 'nullable|integer',
            'checkbox' => 'nullable|boolean'
        ]);

        $studentDataQuery = CreateAccount::with(['studentSub' => function ($query) use ($validatedData) {
            if (!empty($validatedData['schoolYear'])) {
                $query->where('school_year', $validatedData['schoolYear']);
            }
            if (!empty($validatedData['semester'])) {
                $query->where('semester', $validatedData['semester']);
            }
        }])->where('id', $validatedData['studentName']);
        $studentData = $studentDataQuery->first();
        return Excel::download(new IndividualStudentExport($studentData, $validatedData['checkbox']), 'StudentReport.xlsx');
    }
    public function activedeactiveschoolyear(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);
        SchoolYear::query()->update(['status' => $request->status]);
        return redirect()->back()->with('success', ' Updated successfully!');
    }
}
