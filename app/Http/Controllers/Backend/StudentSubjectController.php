<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\laboratoryModel;
use App\Models\section_subjectss;
use App\Models\studentAssesment;
use App\Models\studentDiscount;
use App\Models\StudentSubject;
use App\Models\TuitionFee;
use Illuminate\Http\Request;
use Termwind\Components\Dd;

class StudentSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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


        $request->validate(StudentSubject::$rules);

        // Create new StudentSubject record
        $studentSubject = new StudentSubject([
            ...$request->only([
                'subject_id',
                'code',
                'descriptive_tittle',
                'total_units',
                'lecture_units',
                'lab_units',
                'pre_requisite',
                'total_hrs_per_week',
                'lab_id',
                'curriculum_id',
                'course_id',
                'year_level',
                'semester',
                'section_id',
                'id_number',
                'campus_id',
                'school_year',
                'department_id'
            ])
        ]);
        $studentSubject->save();

        // Query section_subjectss table by subject_id
        $curriculumSub = section_subjectss::where('subject_id', $studentSubject->subject_id)
            ->first();



        if ($curriculumSub) {
            // Query StudentSubject
            $subject = StudentSubject::where('subject_id', $curriculumSub->subject_id)
                ->where('id_number', $request->id_number)
                ->first();
            if ($subject) {
                $studentId = $subject->id_number;
                $courseId = $subject->course_id;
                $campusId = $subject->campus_id;
                $yearLevel = $subject->year_level;
                $semester = $subject->semester;
                $schoolYear = $subject->school_year;
                $units = $subject->lecture_units;
                $section = $subject->section_id;
                $labUnits = $subject->lab_units;
                $labId = $subject->lab_id;
            }

            // Get tuition rate based on campus and semester
            $tuitionRate = TuitionFee::where('campus_id', $campusId)
                ->where('semester', $semester)
                ->first();

            $tuitionRateAmount = 0;
            switch ($yearLevel) {
                case 1:
                    $tuitionRateAmount = $tuitionRate->first_year;
                    break;
                case 2:
                    $tuitionRateAmount = $tuitionRate->second_year;
                    break;
                case 3:
                    $tuitionRateAmount = $tuitionRate->third_year;
                    break;
                case 4:
                    $tuitionRateAmount = $tuitionRate->fourth_year;
                    break;
            }

            // Get student assessment
            $latestSemester = studentAssesment::where('id_number', $studentId)->max('semester');
            $student_assessment = studentAssesment::where('id_number', $studentId)
                ->where('school_year', $schoolYear)
                ->where('semester', $latestSemester)
                ->orderBy('semester', 'desc')
                ->first();
            if ($labUnits > 0) {
                $labrate = laboratoryModel::where('id', $labId)
                    ->first();

                $labRateAmount = 0;
                switch ($yearLevel) {
                    case 1:
                        $labRateAmount = $labrate->first_year;
                        break;
                    case 2:
                        $labRateAmount = $labrate->second_year;
                        break;
                    case 3:
                        $labRateAmount = $labrate->third_year;
                        break;
                    case 4:
                        $labRateAmount = $labrate->fourth_year;
                        break;
                }
                $amountPerUnit = $units * $tuitionRateAmount;
                $labwithUnits = $labUnits * $labRateAmount;

                $LabandLec = $amountPerUnit + $labwithUnits;
                // dd($labId);

                // Update computations
                $totalTuition = $student_assessment->computation;
                $total2Tuition = $student_assessment->computation2Tuition;
                $addSubjectAmount = $amountPerUnit + $totalTuition;
                $addSubjectAmount2 = $amountPerUnit + $total2Tuition;

                $student_assessment->update([
                    'computation' => $addSubjectAmount,
                    'computation2Tuition' => $addSubjectAmount2,
                    'tutionFeesDeleteSub' => $addSubjectAmount,


                ]);

                // Update total assessment and other columns

                $newtotal = $student_assessment->total_assessment + $LabandLec;
                $perSem = $newtotal / 5;

                $newtotalAss = $student_assessment->totalAss + $LabandLec;

                $columnsToStore = [
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals',
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'stotal_assessment',
                    'totalAss'

                ];
                // dd();

                studentAssesment::create([
                    'id_number' => $student_assessment->id_number,
                    'school_year' => $student_assessment->school_year,
                    'or_number' => $student_assessment->or_number,
                    'semester' => $student_assessment->semester,
                    'fee_type' => $curriculumSub?->laboratory?->description,
                    'category' => 'Laboratory Fees',
                    'lab_id' => $subject->lab_id,
                    'amount' => $labwithUnits,
                    'lecture_units' => 1.0,
                    'computation' => $labwithUnits,
                    'computation2Tuition' => $labwithUnits,
                    'sdownpayment' => $student_assessment->sdownpayment,
                    'downpayment' => $student_assessment->downpayment,
                    'prelims' => $student_assessment->prelims,
                    'midterms' => $student_assessment->midterms,
                    'semi_finals' => $student_assessment->semi_finals,
                    'finals' => $student_assessment->finals,
                    'total_assessment' => $student_assessment->total_assessment,
                    'stotal_assessment' => $student_assessment->stotal_assessment,
                    'course_id' => $student_assessment->course_id,
                    'year_level' => $student_assessment->year_level,
                    'campus_id' => $student_assessment->campus_id,
                    'tutionFees' => $amountPerUnit,
                    'tutionFeesDeleteSub' => $amountPerUnit,
                    'totalAss' => $student_assessment->totalAss,
                ]);

                studentAssesment::where('id_number', $studentId)
                    ->where('semester', $semester)
                    ->update([
                        'total_assessment' => $newtotal,
                        ...array_fill_keys($columnsToStore, $perSem),
                        'stotal_assessment' => $newtotal,
                        ...array_fill_keys($columnsToStore, $perSem),
                        'totalAss' => $newtotalAss,


                    ]);
            } else {
                $amountPerUnit = $units * $tuitionRateAmount;

                // Update computations
                $totalTuition = $student_assessment->computation;
                $total2Tuition = $student_assessment->computation2Tuition;
                $addSubjectAmount = $amountPerUnit + $totalTuition;
                $addSubjectAmount2 = $amountPerUnit + $total2Tuition;

                $student_assessment->update([
                    'computation' => $addSubjectAmount,
                    'computation2Tuition' => $addSubjectAmount2,
                    'tutionFeesDeleteSub' => $addSubjectAmount,

                ]);
                // Update total assessment and other columns
                $newtotal = $student_assessment->total_assessment + $amountPerUnit;
                $perSem = $newtotal / 5;

                $newtotalAss = $student_assessment->totalAss + $amountPerUnit;
                // dd($newtotalAss);

                $columnsToStore = [
                    'downpayment',
                    'prelims',
                    'midterms',
                    'semi_finals',
                    'finals',
                    'sdownpayment',
                    'sprelims',
                    'smidterms',
                    'ssemi_finals',
                    'sfinals',
                    'totalAss'
                ];

                studentAssesment::where('id_number', $studentId)
                    ->where('semester', $semester)
                    ->update([
                        'total_assessment' => $newtotal,
                        ...array_fill_keys($columnsToStore, $perSem),
                        'stotal_assessment' => $newtotal,
                        ...array_fill_keys($columnsToStore, $perSem),
                        'totalAss' => $newtotalAss,
                    ]);
            }
        }

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

    }
    public function deleteSubject(string $id)
    {
        $subject = StudentSubject::findOrFail($id);
        $studentId = $subject->id_number;
        $courseId = $subject->course_id;
        $campusId = $subject->campus_id;
        $yearLevel = $subject->year_level;
        $semester = $subject->semester;
        $schoolYear = $subject->school_year;
        $units = $subject->lecture_units;
        $labUnits = $subject->lab_units;
        $subjectLabId = $subject->lab_id;
        $labId = $subject->lab_id;


        // Fetch Tuition Rate
        $tuitionRate = TuitionFee::where('campus_id', $campusId)
            ->where('semester', $semester)
            ->first();

        $tuitionRateAmount = match ($yearLevel) {
            1 => $tuitionRate->first_year ?? 0,
            2 => $tuitionRate->second_year ?? 0,
            3 => $tuitionRate->third_year ?? 0,
            4 => $tuitionRate->fourth_year ?? 0,
            default => 0,
        };

        // Fetch Lab Rate


        // Find latest assessment
        $latestSemester = studentAssesment::where('id_number', $studentId)->max('semester');
        $student_assessment = studentAssesment::where('id_number', $studentId)
            ->where('school_year', $schoolYear)
            ->where('semester', $latestSemester)
            ->orderBy('semester', 'desc')
            ->first();

        if ($subjectLabId) {
            // Laboratory Fee Deduction Logic
            $tuitionRate = TuitionFee::where('campus_id', $campusId)
                ->where('semester', $semester)
                ->first();

            $tuitionRateAmountlab = match ($yearLevel) {
                1 => $tuitionRate->first_year ?? 0,
                2 => $tuitionRate->second_year ?? 0,
                3 => $tuitionRate->third_year ?? 0,
                4 => $tuitionRate->fourth_year ?? 0,
                default => 0,
            };

            $lab = laboratoryModel::where('id', $labId)
                ->first();
            // dd($lab);

            $labRateAmount = match ($yearLevel) {
                1 => $lab->first_year ?? 0,
                2 => $lab->second_year ?? 0,
                3 => $lab->third_year ?? 0,
                4 => $lab->fourth_year ?? 0,
                default => 0,
            };

            studentAssesment::where('lab_id', $subjectLabId)->delete();
            // $labRate = $labUnits * $labRateAmount;
            $labRate = $labUnits * $labRateAmount;
            $unitsLec = $units * $tuitionRateAmountlab;

            $LabandLec = $labRate + $unitsLec;
            // dd($LabandLec);

            $labAmountToSubtract = $student_assessment->computation - $unitsLec;
            $labAmountToSubtractcom2 = $student_assessment->computation2Tuition - $unitsLec;
            // dd($labAmountToSubtractcom2);

            $student_assessment->update([
                'computation' => $labAmountToSubtract,
                'computation2Tuition' => $labAmountToSubtractcom2,
                'tutionFeesDeleteSub' => $labAmountToSubtract,
            ]);

            $newAmountlab = $student_assessment->total_assessment - $LabandLec;
            $newTotalAss = $student_assessment->totalAss - $LabandLec;
            // dd($newAmountlab);
            $perSemlab = $newAmountlab / 5;

            $columnsToStorelab = ['downpayment', 'prelims', 'midterms', 'semi_finals', 'finals'];
            $columnsToStoreslab = ['sdownpayment', 'sprelims', 'smidterms', 'ssemi_finals', 'sfinals'];

            studentAssesment::where('id_number', $studentId)
                ->where('semester', $latestSemester)
                ->where('school_year', $schoolYear)
                ->orderBy('semester', 'desc')
                ->update([
                    'total_assessment' => $newAmountlab,
                    ...array_fill_keys($columnsToStorelab, $perSemlab),
                    'subractComputation' => $labRate,
                    'stotal_assessment' => $newAmountlab,
                    ...array_fill_keys($columnsToStoreslab, $perSemlab),
                    // 'totalAss' => $newAmountlab,
                    'totalAss' => $newTotalAss,
                ]);
        } else if ($student_assessment) {

            $amountPerUnit = $units * $tuitionRateAmount;
            $tuitionAmountToSubtract = $student_assessment->computation - $amountPerUnit;
            $tuitionAmountToSubtractcom2 = $student_assessment->computation2Tuition - $amountPerUnit;

            $student_assessment->update([
                'computation' => $tuitionAmountToSubtract,
                'computation2Tuition' => $tuitionAmountToSubtractcom2,
                'tutionFeesDeleteSub' => $tuitionAmountToSubtract,
            ]);

            $newAmount = $student_assessment->total_assessment - $amountPerUnit;
            $perSem = $newAmount / 5;
            $newTotalAss1 = $student_assessment->totalAss - $amountPerUnit;

            $columnsToStore = ['downpayment', 'prelims', 'midterms', 'semi_finals', 'finals'];
            $columnsToStores = ['sdownpayment', 'sprelims', 'smidterms', 'ssemi_finals', 'sfinals'];

            studentAssesment::where('id_number', $studentId)
                ->where('semester', $latestSemester)
                ->where('school_year', $schoolYear)
                ->orderBy('semester', 'desc')
                ->update([
                    'total_assessment' => $newAmount,
                    ...array_fill_keys($columnsToStore, $perSem),
                    'subractComputation' => $amountPerUnit,
                    'stotal_assessment' => $newAmount,
                    ...array_fill_keys($columnsToStores, $perSem),
                    'totalAss' => $newTotalAss1,
                ]);
        }

        // Delete the subject and respond
        $subject->delete();
        return response(['status' => 'success', 'message' => 'Student Subject Deleted Successfully']);
    }

    public function addSubjectWithComputation(Request $request, $id)
    {

        // $curriculumSub = section_subjectss::findOrFail($id);
        // $subject = StudentSubject::where('subject_id', $curriculumSub->subject_id)->first();



        // $studentId = $subject->id_number;
        // $campusId = $subject->campus_id;
        // $yearLevel = $subject->year_level;
        // $semester = $subject->semester;
        // $units = $subject->lecture_units;
        // $labUnits = $subject->lab_units;


        // $student_assessment = studentAssesment::where('id_number', $studentId)
        //     ->where('semester', $semester)
        //     ->first();
        // $labrate = laboratoryModel::where('campus_id', $campusId)
        //     ->where('semester', $semester)
        //     ->first();

        // $labAmount = match ($yearLevel) {
        //     1 => $labrate->first_year,
        //     2 => $labrate->second_year,
        //     3 => $labrate->third_year,
        //     4 => $labrate->fourth_year,
        //     default => 0,
        // };
        // if ($labUnits < 0) {
        //     $tuitionRate = TuitionFee::where('campus_id', $campusId)
        //         ->where('semester', $semester)
        //         ->first();

        //     $tuitionRateAmount = match ($yearLevel) {
        //         1 => $tuitionRate->first_year,
        //         2 => $tuitionRate->second_year,
        //         3 => $tuitionRate->third_year,
        //         4 => $tuitionRate->fourth_year,
        //         default => 0,
        //     };

        //     $amountPerUnit = $units * $tuitionRateAmount;
        //     $newComputation = $student_assessment->computation < $amountPerUnit
        //         ? $student_assessment->computation + $amountPerUnit
        //         : $student_assessment->computation;

        //     $newComputation2 = $student_assessment->computation2Tuition < $amountPerUnit
        //         ? $student_assessment->computation2Tuition + $amountPerUnit
        //         : $student_assessment->computation2Tuition;

        //     $student_assessment->update([
        //         'computation' => $newComputation,
        //         'computation2Tuition' => $newComputation2,
        //         'tutionFeesDeleteSub' => $units * $tuitionRateAmount +  $student_assessment->computation,
        //     ]);

        //     $totalAssessment = studentAssesment::where('id_number', $studentId)
        //         ->where('semester', $semester)
        //         ->sum('computation');

        //     $perSem = $totalAssessment / 5;
        //     $columnsToStore = [
        //         'downpayment',
        //         'prelims',
        //         'midterms',
        //         'semi_finals',
        //         'finals',
        //         'sdownpayment',
        //         'sprelims',
        //         'smidterms',
        //         'ssemi_finals',
        //         'sfinals'
        //     ];

        //     $student_assessment->update([
        //         'total_assessment' => $totalAssessment,
        //         ...array_fill_keys($columnsToStore, $perSem),
        //         'stotal_assessment' => $totalAssessment,
        //         // 'tutionFeesDeleteSub' => $tuitiondeletecolumn,
        //     ]);
        //     return response(['status' => 'success', 'message', 'Student Subject Deleted Successfully']);
        // } else {
        //     dd("testing");
        //     $labrate = laboratoryModel::where('campus_id', $campusId)
        //         ->where('semester', $semester)
        //         ->first();

        //     $labAmount = match ($yearLevel) {
        //         1 => $labrate->first_year,
        //         2 => $labrate->second_year,
        //         3 => $labrate->third_year,
        //         4 => $labrate->fourth_year,
        //         default => 0,
        //     };
        // }
    }
}