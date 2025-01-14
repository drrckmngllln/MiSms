<?php

namespace App\Http\Controllers\Backend;

use App\Exports\StudentDataClass;
use App\Exports\StudentBarangayDataClass;
use App\Exports\StudentGenderDataClass;
use App\Exports\StudentOccupationDataClass;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use App\Models\CreateAccount;
use App\Models\Department;
use App\Models\instructor;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\StudentSubject;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //
    public function studentrepots()
    {
        $course = Course::all();
        $schoolYear = SchoolYear::all();
        $department = Department::all();
        $section = Section::all();
        $Students = CreateAccount::all();
        $campus = Campus::all();
        $instructor = instructor::all();
        return view('Roles.Super_Administrator.studentReports.index', compact('course', 'schoolYear', 'department', 'section', 'Students', 'campus', 'instructor'));
    }
    public function generateExcel(Request $request)
    {

        $course = $request->input('course');
        $yearLevel = $request->input('year_level');
        $status = 'OFFICIALLY ENROLLED';
        $gender = $request->input('gender');
        $section = $request->input('section');

        $studentData = CreateAccount::select('first_name', 'middle_name', 'last_name', 'gender', 'courses.code as course', 'student_subjects.year_level', 'sections.section_code as section_name')
            ->join('courses', 'create_accounts.course_id', '=', 'courses.id')
            ->leftJoin('student_subjects', 'create_accounts.id_number', '=', 'student_subjects.id_number')
            ->leftJoin('sections', 'student_subjects.section_id', '=', 'sections.id')
            ->when($course !== 'all' && !is_null($course), function ($query) use ($course) {
                return $query->where('create_accounts.course_id', $course);
            })
            ->when($status === 'OFFICIALLY ENROLLED', function ($query) {
                return $query->where('create_accounts.status', 'OFFICIALLY ENROLLED');
            })
            ->when($section !== 'all' && !is_null($section), function ($query) use ($section) {
                return $query->where('student_subjects.section_id', $section);
            })
            ->when($yearLevel !== 'all' && !is_null($yearLevel), function ($query) use ($yearLevel) {
                return $query->where('student_subjects.year_level', $yearLevel);
            })
            ->when($gender !== 'all' && !is_null($gender), function ($query) use ($gender) {
                return $query->where('create_accounts.gender', $gender);
            })
            ->distinct()
            ->get();

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;
        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Generate MasterList Section',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);

        return Excel::download(new StudentDataClass($studentData), 'StudentInformation.xlsx');
    }
    public function previewExcel() {}
    public function financerepots()
    {
        return view('Roles.Super_Administrator.studentReports.financeindex');
    }
    public function generateCertofGrade(Request $request)
    {
        $studentsId = $request->query('studentss_id');
        $student = CreateAccount::where('id', $studentsId)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        // Get filter parameters
        $semester = $request->input('semester_id');
        $sy = $request->input('schoolYearID');
        $yearLevel = $request->input('year_level_id');
        $campus = $request->input('campusID');
        $withgradeCOG = $request->input('selectWithGradesCOE');

        // Load student with relationships
        $studentWithRelations = CreateAccount::with(['COE' => function ($query) use ($semester, $sy, $yearLevel, $campus) {
            if ($semester && $sy && $yearLevel && $campus) {
                $query->where('semester', $semester)
                    ->where('school_year', $sy)
                    ->where('year_level', $yearLevel)
                    ->where('campus_id', $campus);
            }
        }])->where('id', $studentsId)->first();
        // dd($studentWithRelations);

        if (!$studentWithRelations || $studentWithRelations->COE->isEmpty()) {
            return redirect()->back()->with('error', 'Error: The student might not be enrolled in the current semester or other conditions are not met.');
        }


        $subjectsBySemesterAndYear = [];
        $unitsBySemesterAndYear = [];
        $totalUnitsBySemesterAndYear = [];



        $yearLevelMap = [];

        $schoolYearCodeMap = [];
        foreach ($studentWithRelations->COE as $record) {
            // dd($record);
            $key = $record->semester . '_' . $record->school_year;
            $yearLevelMap[$key] = $record->year_level;
            if ($record->schoolYear) {
                $schoolYearCodeMap[$record->school_year] = $record->schoolYear->code;
            }
        }

        foreach ($studentWithRelations->COE as $subject) {
            $semesterYearKey = $subject->semester . '_' . $subject->school_year;

            if (!isset($subjectsBySemesterAndYear[$semesterYearKey])) {
                $subjectsBySemesterAndYear[$semesterYearKey] = [];
                $unitsBySemesterAndYear[$semesterYearKey] = [];
                $totalUnitsBySemesterAndYear[$semesterYearKey] = 0;
            }

            $subjectsBySemesterAndYear[$semesterYearKey][] = [
                'code' => $subject->code,
                'title' => $subject->descriptive_tittle,
                'units' => $subject->lecture_units,
                'grade' => $withgradeCOG == 1 ? ($subject->grade ?? '') : ''
            ];

            $unitsBySemesterAndYear[$semesterYearKey][] = $subject->lecture_units;
            $totalUnitsBySemesterAndYear[$semesterYearKey] += $subject->lecture_units;
        }

        // Year level mapping
        $yearLevels = [
            1 => '1st year',
            2 => '2nd year',
            3 => '3rd year',
            4 => '4th year',
        ];

        $studentData = [];
        foreach ($subjectsBySemesterAndYear as $semesterYear => $subjects) {
            [$semester, $schoolYear] = explode('_', $semesterYear);
            $yearLevel = $yearLevelMap[$semesterYear] ?? 1;

            $schoolYearCode = $schoolYearCodeMap[$schoolYear] ?? 'Unknown Code';

            $schoolYearCode = $schoolYearCodeMap[$schoolYear] ?? null;

            $studentData[$semesterYear] = [
                'first_name' => $studentWithRelations->first_name,
                'middle_name' => $studentWithRelations->middle_name,
                'last_name' => $studentWithRelations->last_name,
                'yearlevel' => $yearLevels[$yearLevel] ?? '1st year',
                'course' => $studentWithRelations->COE->first()?->course?->description,
                'department_id' => $studentWithRelations->COE->first()?->course?->department->description,
                'subjects' => $subjects,
                'units' => $unitsBySemesterAndYear[$semesterYear],
                'total' => $totalUnitsBySemesterAndYear[$semesterYear],
                'schoolyear' => $schoolYearCode,
                'campus' => $studentWithRelations->COE->first()->campus_id,
                'semester' => $semester
            ];
        }
        // dd($studentData);
        // Log activity
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        DB::table('activity_logs')->insert([
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Certificate of Enrollment Or COE',
            'date_time' => Carbon::now('Asia/Manila')->format('D, M j, Y g:i A'),
        ]);

        // Generate PDF
        $campus = $studentWithRelations->COE->first()->campus_id;
        $pdf = Pdf::loadView(
            'Roles.Super_Administrator.printStudentAssessment.COEMCNPISAPMAIN',
            compact('studentData', 'campus')
        );

        return $pdf->stream('Certificate of Grade.pdf');
    }
    public function generateExcelBarangay(Request $request)
    {
        // dd($request->all());
        $municipality = $request->input('city');
        $barangay = $request->input('barangay');

        $studentData = CreateAccount::select('first_name', 'middle_name', 'last_name', 'barangay_code', 'municipality_code', 'id_number', 'barangay', 'municipality')
            ->where('municipality_code', $municipality)
            ->where('barangay_code', $barangay)
            ->get();

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Generate Excel Barangay ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);
        return Excel::download(new StudentBarangayDataClass($studentData), 'StudentbyBarangay.xlsx');
    }
    public function generateExcelOccupation(Request $request)
    {
        $occupation = $request->input('occupation');

        $studentData = CreateAccount::select(
            'id_number',
            'first_name',
            'middle_name',
            'last_name',
            'occupation_mother',
            'occupation_father',
            'barangay',
            'municipality'
        )
            ->where(function ($query) use ($occupation) {
                $query->where('occupation_mother', $occupation)
                    ->orWhere('occupation_father', $occupation);
            })
            ->get();

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Generate Excel Parents Occupation ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);


        return Excel::download(new StudentOccupationDataClass($studentData, $occupation), 'StudentParentOccupation.xlsx');
    }
    public function generateExcelGender(Request $request)
    {
        $gender = $request->input('gender');

        $studentData = CreateAccount::select('id_number', 'first_name', 'middle_name', 'last_name', 'gender', 'barangay', 'municipality')
            ->where('gender', $gender)
            ->get();
        // dd($gender);
        return Excel::download(new StudentGenderDataClass($studentData, $gender), 'StudentGender.xlsx');
    }
}