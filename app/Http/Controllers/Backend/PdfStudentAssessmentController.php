<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\adddetails;
use App\Models\CreateAccount;
use App\Models\CreateAccountHighSchool;
use App\Models\fee_summary;
use App\Models\MiscFee;
use App\Models\student_Subject_highSchool;
use App\Models\studentAssesment;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use FFI;
use Symfony\Component\Console\Input\Input;
use Termwind\Components\Dd;

class PdfStudentAssessmentController extends Controller
{
    //
    public function generateStudentAssessment(request $request, $id_number)
    {

        try {

            $latestSemester = StudentSubject::where('id_number', $id_number)
                ->max('semester');
            // $students = CreateAccount::with('studentSubjects.schoolYear', 'student_assestment', 'fee_summary')->where('id_number', $request->id_number)
            // ->get();

            $students = CreateAccount::with([
                'studentSubjects' => function ($query) use ($latestSemester) {
                    $query->where('semester', $latestSemester);
                },
                'studentSubjects.schoolYear',
                'student_assestment',
                'fee_summary'
            ])->where('id_number', $request->id_number)
                ->get();
            $studentData = [];

            $campuses = [
                1 => [
                    'name' => 'International School of Asia and the Pacific',
                    'logo' => asset('frontend/assets/images/ISAP_LOGO_NO_BG.png'),
                ],
                2 => [
                    'name' => 'Medical Colleges of Northern Philippines',
                    'logo' => asset('frontend/assets/images/Medical_Colleges_of_Northern_Philippines_(MCNP)_Logo.jpg'),
                ]
            ];
            foreach ($students as $student) {
                $Student = $student->studentSubjects->first();
                $campusName = 'International School of Asia and the Pacific';
                $campusLogo = asset('frontend/assets/images/ISAP_LOGO_NO_BG.png');

                $campusData = $campuses[$student->campus_id] ?? [
                    'name' => 'International School of Asia and the Pacific',
                    'logo' => asset('frontend/assets/images/ISAP_LOGO_NO_BG.png')
                ];
                // dd($campusData);
                $subjects = [];
                $units = [];
                $lab_units = [];
                $addDetails = [];

                $instructors = [];
                $laboratory_amount = [];

                foreach ($student->studentSubjects as $subject) {
                    // dd($subject);

                    $subjects[] = $subject->descriptive_tittle;
                    $subjectCode[] = $subject->code;
                    $units[] = $subject->lecture_units;
                    $lab_units[] = $subject->lab_units;

                    // $sectionID = $subject->sectionSubject ? $subject->sectionSubject->section_id : null;
                    // $sectionIds[] = $sectionID;
                    // dd($sectionIds);

                    $sectionID = $subject->sectionSubject ? $subject->sectionSubject->section?->section_code : null;
                    $sectionIds[] = $sectionID;

                    if ($subject->adddetails->isNotEmpty()) {
                        $instructors[] = $subject->adddetails->sortByDesc('created_at')->first()->instructorss->full_name;
                        $time[] = $subject?->adddetails?->sortByDesc('created_at')->first()?->time;
                        $room[] = $subject?->adddetails?->sortByDesc('created_at')->first()?->room;
                    }
                    $StudentDiscount[] = $student->student_assestment?->discount?->discount_target;
                    $StudentDiscountAmount = $student->student_assestment?->discountCompute;
                    $StudentDiscountAmountMiscFee = $student->student_assestment?->discountComputeMiscFee;

                    $laboratory[] = $subject->laboratory?->description;

                    $miscFeeTable = $subject->miscfee2;
                    $miscFeeDescriptions = $miscFeeTable ? $miscFeeTable->pluck('description')->unique()->toArray() : [];
                    $miscFeeAmount = [];

                    switch ($subject->year_level) {
                        case 1:
                            $campusId = $subject->campus_id;

                            foreach ($miscFeeDescriptions as $description) {
                                // dd($miscFeeDescriptions);
                                $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->first()
                                    ->first_year ?? 0;
                            }
                            break;
                        case 2:
                            $campusId = $subject->campus_id;

                            foreach ($miscFeeDescriptions as $description) {
                                // dd($miscFeeDescriptions);
                                $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->first()
                                    ->second_year ?? 0;
                            }
                            break;
                        case 3:
                            $campusId = $subject->campus_id;
                            foreach ($miscFeeDescriptions as $description) {
                                // dd($miscFeeDescriptions);
                                $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->first()
                                    ->third_year ?? 0;
                            }
                            break;
                        case 4:
                            $campusId = $subject->campus_id;

                            foreach ($miscFeeDescriptions as $description) {
                                // dd($miscFeeDescriptions);
                                $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->first()
                                    ->fourth_year ?? 0;
                            }
                            break;
                        default:
                            $miscFeeAmount[] = 0;
                    }
                    $otherFeeTable = $subject->otherFees2;
                    $otherFeeDescriptions = $otherFeeTable ? $otherFeeTable->pluck('description')->unique()->toArray()  : [];
                    // dd($otherFeeDescriptions);
                    $otherFeeAmount = [];
                    switch ($subject->year_level) {
                        case 1:
                            $campusId = $subject->campus_id;
                            foreach ($otherFeeDescriptions as $description) {
                                $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->first()->first_year ?? 0;
                            }
                            break;
                        case 2:
                            $campusId = $subject->campus_id;

                            foreach ($otherFeeDescriptions as $description) {
                                // dd($otherFeeDescriptions);
                                $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->first()->second_year ?? 0;
                            }
                            break;
                        case 3:
                            $campusId = $subject->campus_id;

                            foreach ($otherFeeDescriptions as $description) {
                                // dd($miscFeeDescriptions);
                                $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->first()
                                    ->third_year ?? 0;
                            }
                            break;
                        case 4:
                            $campusId = $subject->campus_id;
                            $courseId = $subject->course_id;

                            foreach ($otherFeeDescriptions as $description) {
                                $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                    ->where('campus_id', $campusId)
                                    ->where('course_id', $courseId)
                                    ->first()
                                    ->fourth_year ?? 0;
                            }
                            break;
                        default:
                            $otherFeeAmount[] = 0;
                    }

                    $tutionFeeTable = $subject->tuitionfee;
                    switch ($subject->year_level) {
                        case 1:
                            $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->first_year : 0;
                            break;
                        case 2:
                            $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->second_year : 0;
                            break;
                        case 3:
                            $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->third_year : 0;
                            break;
                        case 4:
                            $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->fourth_year : 0;
                            break;
                        default:
                            $tutionFeeAmount[] = 0;
                            break;
                    }
                    $otherFeeFullPack = $subject->fullpackage;
                    $otherFeefullpackDescriptions = $otherFeeFullPack ? $otherFeeFullPack->pluck('description')->unique()->toArray()  : [];
                    // dd($otherFeefullpackDescriptions);
                    $otherFeefullpackAmount = [];
                    // dd($subject->year_level);
                    switch ($subject->year_level) {
                        case 4:
                            // dd($subject->semester == 2);
                            $campusId = $subject->campus_id;
                            foreach ($otherFeefullpackDescriptions as $descriptionFullPack) {
                                // dd($descriptionFullPack);
                                $otherFeefullpackAmount[] = $otherFeeFullPack->where('description', $descriptionFullPack)
                                    ->where('campus_id', $campusId)
                                    ->where('course_id', $courseId)
                                    ->where('semester', $subject->semester)
                                    ->first()
                                    ->fourth_year ?? 0;
                                // dd($otherFeefullpackAmount);
                            }
                            break;
                        case 5:
                            $campusId = $subject->campus_id;
                            foreach ($otherFeefullpackDescriptions as $descriptionFullPack) {
                                // dd($descriptionFullPack);56w9
                                $otherFeefullpackAmount[] = $otherFeeFullPack->where('description', $descriptionFullPack)
                                    ->where('campus_id', $campusId)
                                    ->where('course_id', $courseId)
                                    ->where('semester', $subject->semester)
                                    ->first()
                                    ->fifth_year ?? 0;
                                // dd($otherFeefullpackAmount);
                            }
                            break;
                        default:
                            $otherFeefullpackAmount[] = 0;
                    }

                    //for laboratory according to year
                    $laboratoryTable = $subject->laboratory;
                    if ($laboratoryTable && $subject->year_level == 1) {
                        $laboratory_amount[] = $laboratoryTable->first_year;
                    } elseif ($laboratoryTable && $subject->year_level == 2) {
                        $laboratory_amount[] = $laboratoryTable->second_year;
                    } elseif ($laboratoryTable && $subject->year_level == 3) {
                        $laboratory_amount[] = $laboratoryTable->third_year;
                    } elseif ($laboratoryTable && $subject->year_level == 4) {
                        $laboratory_amount[] = $laboratoryTable->third_year;
                    }
                    $latestSemester = StudentSubject::where('id_number', $id_number)
                        ->max('semester');
                    //Retrieve all details according to id_number and semester
                    $tuitionFees = $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('tutionFeesDeleteSub')
                        ->filter()
                        ->first();
                    // dd($tuitionFees);
                    $downpayment = $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('sdownpayment')
                        ->filter()
                        ->first();
                    // dd($downpayment);
                    $prelims = $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('sprelims')
                        ->filter()
                        ->first();
                    $midterms = $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('smidterms')
                        ->filter()
                        ->first();
                    $semi_finals = $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('ssemi_finals')
                        ->filter()
                        ->first();
                    $finals = $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('sfinals')
                        ->filter()
                        ->first();
                    $total_assessment =  $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('totalAss')
                        ->filter()
                        ->first();
                    $total_miscfee_first_year =  $student->student_assestment->where('id_number', $student->id_number)
                        ->pluck('total_miscfee_first_year')
                        ->filter()
                        ->first();
                    $assessment  = $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->first();
                    $totalDiscount = floatval($assessment->discountCompute ?? 0) + floatval($assessment->discountComputeMiscFee ?? 0);

                    $discountCode = $assessment->discount?->code;
                    // dd($discountCode);


                    $latestDownpaymentId = fee_summary::where('id_number', $student->id_number)->max('id');
                    if ($student && $student->fee_summary) {
                        $testing = $feeSummary = $student->fee_summary->where('id_number', $student->id_number)
                            ->where('id', $latestDownpaymentId)
                            ->orderBy('id', 'desc')
                            ->get();
                        $downpayments = $feeSummary->pluck('downpayment');
                        $filteredDownpayments = $downpayments->filter();
                        $feeCollection = $filteredDownpayments->first();
                    } else {
                        $feeCollection = null;
                    }
                    $total_assessment2 =  $student->student_assestment->where('id_number', $student->id_number)
                        ->where('semester', $latestSemester)
                        ->orderBy('semester', 'desc')
                        ->pluck('totalAss')
                        ->filter()
                        ->first();
                }

                foreach ($students as $student) {
                    foreach ($student->studentSubjects as $subject) {
                        $schoolYearCode = $subject->schoolYear->code ?? 'N/A';
                    }
                }

                $subjects = $subjects ?? [];
                $units = $units ?? [];
                $lab_units = $lab_units ?? [];
                $time = $time ?? [];
                $room = $room ?? [];
                $day = $day ?? [];
                $tutionFeeAmount = [$tutionFeeAmount[0]]; //slicing method kunin natin yung una item sa array
                $StudentDiscount = [$StudentDiscount[0]];
                $combinedArray = array_map(null, $subjects, $units, $lab_units, $time, $room, $day);
                // dd($combinedArray);
                $totalUnits = array_sum($units);
                $totallabUnits = array_sum($lab_units);
                $totalMiscFee = array_sum($miscFeeAmount);


                $combinedFees = array_map(null, $otherFeeDescriptions, $otherFeeAmount);
                $filteredFees = array_filter($combinedFees, function ($fee) {
                    return floatval($fee[1]) > 0;
                });
                $filteredDescriptions = array_column($filteredFees, 0);
                $filteredAmounts = array_column($filteredFees, 1);


                $studentData[] = [
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'id_number' => $student->id_number,
                    'course_id' => $student->studentSubjects->first()->course->code,
                    'semester' => $student->studentSubjects->first()->semester,
                    'yearlevel' => $student->studentSubjects->first()->year_level,
                    'date' => date('m/d/Y'),
                    'subjects' => implode('#$% ', $subjects),
                    'units' => implode('#$% ', $units),
                    'totalUnits' => $totalUnits,
                    'tuitionFees' => $tuitionFees,
                    'labunits' => implode(', ', $lab_units),
                    'totallabUnits' => $totallabUnits,
                    'subjectCode' => implode('#$% ', $subjectCode),
                    'instructors' => implode('#$% ', $instructors),
                    'time' => implode('#$% ', $time),
                    'room' => implode('#$% ', $room),
                    'day' => implode('#$% ', $day),
                    'section_id' => $sectionIds,
                    'laboratory' => implode(', ', $laboratory),
                    'laboratory_amount' => implode(', ', $laboratory_amount),
                    'tutionFeeAmount' => implode(', ', $tutionFeeAmount),
                    'miscDescription' => implode(', ', $miscFeeDescriptions),
                    'miscAmount' => $total_miscfee_first_year,
                    'totalMiscFeeAmount' => implode(', ', $miscFeeAmount),
                    'otherFees' => implode(', ', $filteredDescriptions),
                    'otherFeesAmount' => implode(', ', $filteredAmounts),
                    'otherFeesFullPack' => implode(', ', $otherFeefullpackDescriptions),
                    'otherFeesFullPackAmount' => implode(', ', $otherFeefullpackAmount),
                    'downpayment' => $downpayment,
                    'prelims' => $prelims,
                    'midterms' => $midterms,
                    'semi_finals' => $semi_finals,
                    'finals' => $finals,
                    'total_assessment' => $total_assessment,
                    'discount' => implode(', ', $StudentDiscount),
                    'discountAmount' => $StudentDiscountAmount,
                    'discountComputeMiscFee' => $StudentDiscountAmountMiscFee,
                    'feeCollection' => $feeCollection,
                    'campus' => $campusName,
                    'campusLogo' => $campusLogo,
                    'schoolYear' => $schoolYearCode,
                    'totalAss2' => $total_assessment2,
                    'campus' => $campusData['name'],
                    'campusLogo' => $campusData['logo'],
                    'totalDiscount' => $totalDiscount,
                    'discountCode' => $discountCode,
                ];
            }
            // dd($studentData);
            // return view('Roles.Super_Administrator.printStudentAssessment.generate-student-assessment', compact('studentData'));
            $pdf = Pdf::loadView('Roles.Super_Administrator.printStudentAssessment.generate-student-assessment', compact('studentData'));
            return $pdf->stream('student_assessment.pdf');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function generateStudentAssessmentHS(request $request, $id_number)
    {
        $latestSemester = student_Subject_highSchool::where('id_number', $id_number)
            ->max('semester');
        // dd($latestSemester);

        // $students = CreateAccount::with('studentSubjects.schoolYear', 'student_assestment', 'fee_summary')->where('id_number', $request->id_number)
        // ->get();

        $students = CreateAccountHighSchool::with([
            'studentSubjects' => function ($query) use ($latestSemester) {
                $query->where('semester', $latestSemester);
            },
            'studentSubjects.schoolYear',
            'student_assestment',
            'fee_summary'
        ])->where('id_number', $request->id_number)
            ->get();
        // dd($students);

        $studentData = [];

        foreach ($students as $student) {
            $Student = $student->studentSubjectshs->first();
            $campusName = 'International School of Asia and the Pacific';
            $campusLogo = asset('frontend/assets/images/ISAP_LOGO_NO_BG.png');

            // dd($campusLogo);

            $subjects = [];
            $units = [];
            $lab_units = [];
            $addDetails = [];

            $instructors = [];
            $laboratory_amount = [];
            $tutionFeeAmount = [];
            // dd($student->studentSubjectshs);
            foreach ($student->studentSubjectshs as $subject) {

                $subjects[] = $subject->descriptive_tittle;
                $subjectCode[] = $subject->code;
                $units[] = $subject->lecture_units;
                $lab_units[] = $subject->lab_units;


                if ($subject->adddetails->isNotEmpty()) {
                    // dd($subject->adddetails->first()->instructorss);
                    $instructors[] = $subject->adddetails->first()->instructorss->full_name;
                    $time[] = $subject?->adddetails?->sortByDesc('created_at')->first()?->time;
                    $room[] = $subject?->adddetails?->sortByDesc('created_at')->first()?->room;
                    $day[] = $subject?->adddetails?->sortByDesc('created_at')->first()?->day;
                }

                $StudentDiscount[] = $student->student_assestment?->discount?->discount_target;
                $StudentDiscountAmount = $student->student_assestment?->discountCompute;
                $StudentDiscountAmountMiscFee = $student->student_assestment?->discountComputeMiscFee;



                $laboratory[] = $subject->laboratory?->description;

                //Other Fees Stuff

                // MiscFee Stuff
                $miscFeeTable = $subject->miscfee2;
                $miscFeeDescriptions = $miscFeeTable ? $miscFeeTable->pluck('description')->unique()->toArray() : [];
                $miscFeeAmount = [];

                switch ($subject->year_level) {
                    case 1:
                        $campusId = $subject->campus_id;

                        foreach ($miscFeeDescriptions as $description) {
                            // dd($miscFeeDescriptions);
                            $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()
                                ->first_year ?? 0;
                        }
                        break;
                    case 2:
                        $campusId = $subject->campus_id;

                        foreach ($miscFeeDescriptions as $description) {
                            // dd($miscFeeDescriptions);
                            $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()
                                ->second_year ?? 0;
                        }
                        break;
                    case 3:
                        $campusId = $subject->campus_id;
                        foreach ($miscFeeDescriptions as $description) {
                            // dd($miscFeeDescriptions);
                            $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()
                                ->third_year ?? 0;
                        }
                        break;
                    case 4:
                        $campusId = $subject->campus_id;

                        foreach ($miscFeeDescriptions as $description) {
                            // dd($miscFeeDescriptions);
                            $miscFeeAmount[] = $miscFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()
                                ->fourth_year ?? 0;
                        }
                        break;
                    default:
                        $miscFeeAmount[] = 0;
                }
                //for tuition according to year
                // dd($miscFeeTable);
                $otherFeeTable = $subject->otherFees2;
                // dd($subject->otherFees2);
                // dd($otherFeeTable->pluck('description'));
                $otherFeeDescriptions = $otherFeeTable ? $otherFeeTable->pluck('description')->unique()->toArray()  : [];
                // dd($otherFeeDescriptions);
                $otherFeeAmount = [];
                switch ($subject->year_level) {
                    case 1:
                        $campusId = $subject->campus_id;
                        foreach ($otherFeeDescriptions as $description) {
                            $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()->first_year ?? 0;
                        }
                        break;
                    case 2:
                        $campusId = $subject->campus_id;

                        foreach ($otherFeeDescriptions as $description) {
                            // dd($otherFeeDescriptions);
                            $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()->second_year ?? 0;
                        }
                        break;
                    case 3:
                        $campusId = $subject->campus_id;

                        foreach ($otherFeeDescriptions as $description) {
                            // dd($miscFeeDescriptions);
                            $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()
                                ->third_year ?? 0;
                        }
                        break;
                    case 4:
                        $campusId = $subject->campus_id;
                        $courseId = $subject->course_id;

                        foreach ($otherFeeDescriptions as $description) {
                            // dd($miscFeeDescriptions);
                            $otherFeeAmount[] = $otherFeeTable->where('description', $description)
                                ->where('campus_id', $campusId)
                                ->first()
                                ->fourth_year ?? 0;
                        }
                        break;
                    default:
                        $otherFeeAmount[] = 0;
                }

                $tutionFeeTable = $subject->tuitionfee;
                // dd($subject->tuitionfee);
                switch ($subject->year_level) {
                    case 1:
                        $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->first_year : 0;

                        break;
                    case 2:
                        $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->second_year : 0;
                        break;
                    case 3:
                        $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->third_year : 0;
                        break;
                    case 4:
                        $tutionFeeAmount[] = $tutionFeeTable ? $tutionFeeTable->fourth_year : 0;
                        break;
                    default:
                        $tutionFeeAmount[] = 0;
                        break;
                }
                //for laboratory according to year
                $laboratoryTable = $subject->laboratory;
                if ($laboratoryTable && $subject->year_level == 1) {
                    $laboratory_amount[] = $laboratoryTable->first_year;
                } elseif ($laboratoryTable && $subject->year_level == 2) {
                    $laboratory_amount[] = $laboratoryTable->second_year;
                } elseif ($laboratoryTable && $subject->year_level == 3) {
                    $laboratory_amount[] = $laboratoryTable->third_year;
                } elseif ($laboratoryTable && $subject->year_level == 4) {
                    $laboratory_amount[] = $laboratoryTable->third_year;
                }
                $latestSemester = student_Subject_highSchool::where('id_number', $id_number)
                    ->max('semester');
                //Retrieve all details according to id_number and semester
                $tuitionFees = $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('computation')
                    ->filter()
                    ->first();
                $downpayment = $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('downpayment')
                    ->filter()
                    ->first();
                // dd($downpayment);
                $prelims = $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('prelims')
                    ->filter()
                    ->first();
                $midterms = $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('midterms')
                    ->filter()
                    ->first();
                $semi_finals = $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('semi_finals')
                    ->filter()
                    ->first();
                $finals = $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('finals')
                    ->filter()
                    ->first();
                $total_assessment =  $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('total_assessment')
                    ->filter()
                    ->first();
                if ($total_assessment !== null) {
                    $divided_assessment = $total_assessment / 2;
                    // dd($divided_assessment);
                } else {
                    echo "No total assessment found for the student.";
                }

                $total_miscfee_first_year =  $student->student_assestment->where('id_number', $student->id_number)
                    ->pluck('total_miscfee_first_year')
                    ->filter()
                    ->first();
                $latestDownpaymentId = fee_summary::where('id_number', $student->id_number)->max('id');
                if ($student && $student->fee_summary) {
                    $testing = $feeSummary = $student->fee_summary->where('id_number', $student->id_number)
                        ->where('id', $latestDownpaymentId)
                        ->orderBy('id', 'desc')
                        ->get();
                    $downpayments = $feeSummary->pluck('downpayment');
                    $filteredDownpayments = $downpayments->filter();
                    $feeCollection = $filteredDownpayments->first();
                } else {
                    $feeCollection = null;
                }
                $total_assessment2 =  $student->student_assestment->where('id_number', $student->id_number)
                    ->where('semester', $latestSemester)
                    ->orderBy('semester', 'desc')
                    ->pluck('stotal_assessment')
                    ->filter()
                    ->first();
            }

            foreach ($students as $student) {
                foreach ($student->studentSubjectshs as $subject) {
                    $schoolYearCode = $subject->schoolYear->code ?? 'N/A';
                }
            }

            $subjects = $subjects ?? [];
            $units = $units ?? [];
            $lab_units = $lab_units ?? [];
            $time = $time ?? [];
            $room = $room ?? [];
            $day = $day ?? [];

            $tutionFeeAmount = [$tutionFeeAmount[0]]; //slicing method kunin natin yung una item sa array
            $StudentDiscount = [$StudentDiscount[0]];
            $combinedArray = array_map(null, $subjects, $units, $lab_units, $time, $room, $day);
            // dd($combinedArray);
            $totalUnits = array_sum($units);
            $totallabUnits = array_sum($lab_units);
            $totalMiscFee = array_sum($miscFeeAmount);
            $studentData[] = [
                'first_name' => $student->first_name,
                'last_name' => $student->last_name,
                'id_number' => $student->id_number,
                'course_id' => $student->studentSubjectshs->first()->course->code,
                'semester' => $student->studentSubjectshs->first()->semester,
                'yearlevel' => $student->studentSubjectshs->first()->year_level,
                'date' => date('m/d/Y'),
                'subjects' => implode('#$% ', $subjects),
                'units' => implode('#$% ', $units),
                'totalUnits' => $totalUnits,
                'tuitionFees' => $tuitionFees,
                'labunits' => implode(', ', $lab_units),
                'totallabUnits' => $totallabUnits,
                'subjectCode' => implode('#$% ', $subjectCode),
                'instructors' => implode('#$% ', $instructors),
                'time' => implode('#$% ', $time),
                'room' => implode('#$% ', $room),
                'day' => implode('#$% ', $day),
                'section_id' => $student->studentSubjectshs->first()->section->section_code ?? 'N/A',
                // 'addDetailsInstructor' => $student->studentSubjects->first()->adddetails->instructor->full_name ?? 'N/A',
                // 'laboratory_amount' => $student->studentSubjects->first()->laboratory->first_year ?? 'N/A',
                'laboratory' => implode(', ', $laboratory),
                'laboratory_amount' => implode(', ', $laboratory_amount),
                'tutionFeeAmount' => implode(', ', $tutionFeeAmount),
                'miscDescription' => implode(', ', $miscFeeDescriptions),
                'miscAmount' => $total_miscfee_first_year,
                'totalMiscFeeAmount' => implode(', ', $miscFeeAmount),

                'otherFees' => implode(', ', $otherFeeDescriptions),
                'otherFeesAmount' => implode(', ', $otherFeeAmount),
                //payments
                'downpayment' => $downpayment,
                'prelims' => $prelims,
                'midterms' => $midterms,
                'semi_finals' => $semi_finals,
                'finals' => $finals,
                'total_assessment' => $divided_assessment,
                // 'discount' => $student->student_assestment?->discount->pluck('discount_target')->filter()->first(),
                'discount' => implode(', ', $StudentDiscount),
                'discountAmount' => $StudentDiscountAmount,
                'discountComputeMiscFee' => $StudentDiscountAmountMiscFee,
                'feeCollection' => $feeCollection,
                'campus' => $campusName,
                'campusLogo' => $campusLogo,
                'schoolYear' => $schoolYearCode,
                'totalAss2' => $total_assessment2,

                // 'semester' => $semester,

            ];
        }
        // return view('Roles.Super_Administrator.printStudentAssessment.generate-student-assessment', compact('studentData'));
        $pdf = Pdf::loadView('Roles.Super_Administrator.printStudentAssessment.highSchool', compact('studentData'));
        return $pdf->stream('student_assessment.pdf');
    }
}