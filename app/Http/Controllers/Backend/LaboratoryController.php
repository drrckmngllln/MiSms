<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\laboratoryModelDataTable;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CurriculumSubject;
use App\Models\laboratoryModel;
use App\Models\section_subjectss;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(laboratoryModelDataTable $dataTable)
    {

        $campus = Campus::all();
        $course = Course::all();
        return $dataTable->render('Roles.Super_Administrator.laboratory.index', compact('campus', 'course'));
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
        $request->validate(laboratoryModel::$rules);
        $laboratory = new laboratoryModel([
            ...$request->only([
                'category',
                'description',
                'semester',
                'campus_id',
                'first_year',
                'second_year',
                'third_year',
                'fourth_year',
                'course_id'
            ])
        ]);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Creating Laboratory Fees Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);

        $laboratory->save();
        $request->session()->flash('success', 'Laboratory Added Successfully');
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
        //
        $request->validate(laboratoryModel::$rules);
        $laboratory = laboratoryModel::findOrFail($id);
        $laboratory->update(
            $request->only(['category', 'description', 'semester', 'campus_id', 'first_year', 'second_year', 'third_year', 'fourth_year', 'course_id'])
        );
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update Laboratory Fees Entry '  . $request->category . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $laboratory->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $laboratory = laboratoryModel::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Laboratory Fees Entry '  . $laboratory->category . ' ' . $laboratory->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $laboratory->delete();

        return response(['status' => 'success', 'message', 'Laboratory Deleted Successfully']);
    }
    public function likedSubject(Request $request)
    {
        $query = section_subjectss::select('section_subjectsses.id', 'section_subjectsses.year_level', 'section_subjectsses.code', 'section_subjectsses.descriptive_tittle', 'section_subjectsses.semester_id', 'section_subjectsses.section_id', 'section_subjectsses.lab_units')
            ->join('school_years', 'section_subjectsses.school_year', '=', 'school_years.id')
            ->where('school_years.status', 1)
            ->where('section_subjectsses.lab_units', '>', 0)
            ->get();
        // dd($query);
        if (request()->ajax()) {
            return datatables()->of($query)
                ->addColumn('action', function ($query) {
                    $addbtn = '<button type="button" class="btn btn-success" onclick="saveLaboratory(' . $query->id . ', \'' . $query->code . '\',\'' . $query->descriptive_tittle . '\')">+</button>';
                    return $addbtn;
                })
                ->addColumn('section', function ($query) {
                    return $query?->section?->section_code;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function saveLinkedSubject(request $request)
    {
        try {
            $curr_sub = section_subjectss::where('id', $request->id)->first();
            // dd($curr_sub);
            $curr_sub->update([
                ...$request->only(['lab_id'])
            ]);
            $curr_sub->save();
            return response(['status' => 'success', 'message' => 'Assessment Saved!']);
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function likedSubjectview($labId)
    {

        if (request()->ajax()) {
            $labId = request('labId');
            $queryTable = section_subjectss::where('lab_id', $labId)->get();
            // $queryTable = section_subjectss::whereNotNull('lab_id')
            return datatables()->of($queryTable)
                ->addColumn('action', function ($query) {
                    $deleteBtn = '<button type="button" class="btn btn-danger" onclick="removeLabId(' . $query->id . ')"><i class="ri-delete-bin-fill"></i></button>';
                    return $deleteBtn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        // $linkedSubjects = CurriculumSubject::where('lab_id', $labId)->get();
        // // dd($linkedSubjects);
        // return response()->json($linkedSubjects);
    }
    public function removeLabId(string $id)
    {
        $subject = section_subjectss::find($id);
        if ($subject) {
            $subject->lab_id = null;
            $subject->save();

            return response()->json(['status' => 'success', 'message' => '']);
        }
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete Laboratory for subject '  . $subject->descriptive_tittle,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        return response()->json(['status' => 'error', 'message' => 'Subject not found.']);
    }
}