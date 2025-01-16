<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CollectionReportperCampExport;
use App\Exports\DiscountCategoryExport;
use App\Exports\discountCollectionExport;
use App\Exports\feescollectionExport;
use App\Exports\MasterListExport;
use App\Exports\MasterListExportChed;
use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\CreateAccount;
use App\Models\Department;
use App\Models\fee_summary;
use App\Models\FeeCollectionHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Termwind\Components\Dd;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterListController extends Controller
{
    //

    public function generateExcelMasterList(Request $request)
    {


        $selectAll = $request->input('id_number');
        $schoolYear = $request->input('school_year');
        $withGrade = $request->input('selectWithGrades');
        $studentData = $request->input('id_number');
        $campusID = $request->input('campus_id_masterlist');

        if ($selectAll === 'select_all') {

            $studentData = CreateAccount::leftJoin('courses', 'create_accounts.course_id', '=', 'courses.id')
                ->leftJoin('student_subjects', 'create_accounts.id_number', '=', 'student_subjects.id_number')
                ->whereIn('create_accounts.status', [
                    'OFFICIALLY ENROLLED',
                    'PENDING',
                    'FOR ENROLLMENT',
                    'ACCOUNTING',
                    'PROCEED TO CASHIER'
                ])
                ->where(function ($query) use ($schoolYear) {
                    $query->where('student_subjects.school_year', $schoolYear)
                        ->orWhereNull('student_subjects.school_year', $schoolYear);
                })
                ->where(function ($query) use ($campusID) {
                    $query->where('student_subjects.campus_id', $campusID)
                        ->orWhereNull('student_subjects.campus_id', $campusID);
                })
                ->orderBy('create_accounts.last_name', 'asc')
                ->select(
                    'create_accounts.id_number',
                    'create_accounts.first_name',
                    'create_accounts.middle_name',
                    'create_accounts.last_name',
                    'create_accounts.gender',
                    'courses.code as course',
                    DB::raw('COALESCE(student_subjects.year_level, "") as year_level'),
                    'create_accounts.home_address',
                    DB::raw('COALESCE(student_subjects.descriptive_tittle, "") as Subjects'),
                    DB::raw('COALESCE(student_subjects.total_units, 0) as Units'),
                    DB::raw('COALESCE(student_subjects.code, "") as Code'),
                    DB::raw($withGrade ? 'COALESCE(student_subjects.grade, "") as Grade' : '"" as Grade'),
                    DB::raw("CASE WHEN create_accounts.status IN ('PENDING', 'FOR ENROLLMENT', 'ACCOUNTING','PROCEED TO CASHIER') THEN 'NOT OFFICIALLY ENROLLED' ELSE create_accounts.status END as status")

                )
                ->get();

            // dd($studentData);
            $studentData->transform(function ($student) {
                $statusMap = [
                    'PENDING' => 'NOT OFFICIALLY ENROLLED',
                    'FOR ENROLLMENT' => 'NOT OFFICIALLY ENROLLED',
                    'ACCOUNTING' => 'NOT OFFICIALLY ENROLLED',
                    'PROCEED TO CASHIER' => 'NOT OFFICIALLY ENROLLED',
                ];
                if (array_key_exists($student->status, $statusMap)) {
                    $student->status = $statusMap[$student->status];
                }
                return $student;
            });
            $user = Auth::user();
            $roleName = Role::find($user->roles()->first()?->id)?->name;

            $dt = Carbon::now('Asia/Manila');
            $activityLog = [
                'username' => $user->name,
                'email' => $user->email,
                'role_name' => $roleName,
                'modify_user' => 'Generate MasterList Report Excel',
                'date_time' => $dt->format('D, M j, Y g:i A'),
            ];
            DB::table('activity_logs')->insert($activityLog);
            return Excel::download(new MasterListExport($studentData, $withGrade), 'StudentMasterList.xlsx');
        }
    }

    public function generatePDFFinancedailyreport(Request $request)
    {
        // dd($request->all());
        //add validator
        // $validator = Validator::make($request->all(), [
        //     'date_from' => 'required|date',
        //     'date_to' => 'required|date|after_or_equal:date_from',
        // ]);
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }

        $dateFrom = $request->input('date');
        $dateTo = $request->input('dateTo') ?? $request->input('date');

        $dailyCollection = fee_summary::with([
            'create_account',
            'nonassessed',
            'fee_collection_summaries',
        ])
            ->whereDate('date', ">=", $dateFrom)
            ->whereDate('date', "<=", $dateTo)
            ->get();

        // dd($dailyCollection);
        if ($dailyCollection->isEmpty()) {
            return redirect()->back()->withErrors(['date' => 'No records found for the specified date.']);
        }

        $collects = [];
        $uniqueCollects = [];
        $totalTutionFees = 0;
        $totalMiscFee = 0;
        $OtherFees = 0;
        $OtherFees2 = 0;
        foreach ($dailyCollection as $collect) {

            if ($collect->nonassessed) {
                foreach ($collect->nonassessed as $nonassessedRecord) {
                    $or_number = $nonassessedRecord->or_number;
                    // dd($collect->nonassessed);
                    if (!isset($uniqueCollects[$or_number])) {

                        $uniqueCollects[$or_number] = [
                            'date' => $nonassessedRecord->created_at->toDateString(),
                            'last_name' => $nonassessedRecord->create_account?->last_name,
                            'middle_name' => $nonassessedRecord->create_account?->middle_name,
                            'first_name' => $nonassessedRecord->create_account?->first_name,
                            'or_number' => $or_number,
                            'tutionFees' => null,
                            'otherFees' => $nonassessedRecord->amount,
                            'MiscFee' => null,
                            'OTHERFEES' =>  null,
                            'source' => 'Non-Assessed',
                        ];

                        $collects[] = $uniqueCollects[$or_number];
                        $OtherFees += $nonassessedRecord->amount;
                    }
                }
            }
        }

        // dd($dailyCollection);
        foreach ($dailyCollection as $collect) {
            if ($collect->fee_collection_summaries) {
                // dd($collect->fee_collection_summaries);
                $feeCollection = $collect->fee_collection_summaries;
                if ($feeCollection->category === "Tuition Fees") {
                    $or_number = $collect->or_number;
                    if (!isset($uniqueCollects[$or_number])) {
                        $uniqueCollects[$or_number] = [
                            'date' => $collect->date,
                            'last_name' => $collect->create_account?->last_name,
                            'middle_name' => $collect->create_account?->middle_name,
                            'first_name' => $collect->create_account?->first_name,
                            'or_number' => $or_number,
                            'tutionFees' => $collect?->downpayment,
                            'otherFees' => $feeCollection->other_fees,
                            'MiscFee' => null,
                            'OTHERFEES' =>   null,
                            'source' => 'Fee Collection Summary',
                        ];
                        $collects[] = $uniqueCollects[$or_number];
                        $totalTutionFees += $collect?->downpayment;
                    }
                }

                // dd($uniqueCollects);
            }
        }
        // dd($uniqueCollects);
        foreach ($dailyCollection as $collect) {
            if ($collect->fee_collection_summaries) {
                // dd($collect->fee_collection_summaries);
                $feeCollection = $collect->fee_collection_summaries;
                if ($feeCollection->category === 'Miscellaneous Fee') {
                    // dd($feeCollection);
                    $or_number = $collect->or_number;
                    if (!isset($uniqueCollects[$or_number])) {
                        $uniqueCollects[$or_number] = [
                            'date' => $collect->date,
                            'last_name' => $collect->create_account?->last_name,
                            'middle_name' => $collect->create_account?->middle_name,
                            'first_name' => $collect->create_account?->first_name,
                            'or_number' => $or_number,
                            'tutionFees' => null,
                            'otherFees' =>  null,
                            'MiscFee' =>  $collect->downpayment,
                            'OTHERFEES' =>   null,
                            'source' => 'MISC FEE',
                        ];
                        $collects[] = $uniqueCollects[$or_number];
                        $totalMiscFee += $collect?->downpayment;
                    }
                }
            }
        }
        foreach ($dailyCollection as $collect) {
            if ($collect->fee_collection_summaries) {
                // dd($collect->fee_collection_summaries);
                $feeCollection = $collect->fee_collection_summaries;
                if ($feeCollection->category === 'Other Fees') {
                    // dd($feeCollection);
                    $or_number = $collect->or_number;
                    if (!isset($uniqueCollects[$or_number])) {
                        $uniqueCollects[$or_number] = [
                            'date' => $collect->date,
                            'last_name' => $collect->create_account?->last_name,
                            'middle_name' => $collect->create_account?->middle_name,
                            'first_name' => $collect->create_account?->first_name,
                            'or_number' => $or_number,
                            'tutionFees' => null,
                            'otherFees' =>  null,
                            'MiscFee' =>  null,
                            'OTHERFEES' =>   $collect->downpayment,
                            'source' => 'Other Fees',
                        ];
                        $collects[] = $uniqueCollects[$or_number];
                        $OtherFees2 += $collect?->downpayment;
                    }
                }
            }
        }
        $pdf = Pdf::loadView('Roles.Super_Administrator.printStudentAssessment.financereport', compact('collects', 'totalTutionFees', 'OtherFees', 'totalMiscFee', 'OtherFees2', 'dateFrom', 'dateTo'));
        return $pdf->stream('student_assessment.pdf');
    }
    public function chedMasterList(Request $request)
    {

        $validatedData = $request->validate([
            'id_number' => 'nullable|string|max:20',
            'school_year' => 'nullable|integer',

            'campus_id' => 'nullable|integer',
        ]);

        $selectAll = $validatedData['id_number'] ?? null;
        $schoolYear = $validatedData['school_year'] ?? null;
        $withGrade = $validatedData['selectWithGrades'] ?? false;
        $studentData = $validatedData['id_number'] ?? null;
        $semester = $validatedData['semester_ched'] ?? null;
        $yearLevel = $validatedData['yearlevel_ched'] ?? null;
        $campus_id = $validatedData['campus_id'] ?? null;

        $studentData = CreateAccount::leftJoin('courses', 'create_accounts.course_id', '=', 'courses.id')
            ->leftJoin('student_subjects', 'create_accounts.id_number', '=', 'student_subjects.id_number')
            ->whereIn('create_accounts.status', [
                'OFFICIALLY ENROLLED',
                'PENDING',
                'FOR ENROLLMENT',
                'ACCOUNTING',
                'PROCEED TO CASHIER'
            ])
            ->when($schoolYear || $semester || $yearLevel || $campus_id, function ($query) use ($schoolYear, $semester, $yearLevel, $campus_id) {
                $query->where(function ($q) use ($schoolYear, $semester, $yearLevel, $campus_id) {
                    if ($schoolYear) {
                        $q->where('student_subjects.school_year', $schoolYear);
                    }
                    if ($semester) {
                        $q->where('student_subjects.semester', $semester);
                    }
                    if ($yearLevel) {
                        $q->where('student_subjects.year_level', $yearLevel);
                    }
                    if ($campus_id) {
                        $q->where('student_subjects.campus_id', $campus_id);
                    }
                });
            })
            ->orderBy('create_accounts.last_name', 'asc')
            ->select(
                'create_accounts.id_number',
                'create_accounts.first_name',
                'create_accounts.middle_name',
                'create_accounts.last_name',
                'create_accounts.gender',
                'courses.code as course',
                DB::raw('COALESCE(student_subjects.year_level, "") as year_level'),
                'create_accounts.home_address',
                DB::raw('COALESCE(student_subjects.descriptive_tittle, "") as Subjects'),
                DB::raw('COALESCE(student_subjects.total_units, 0) as Units'),
                DB::raw('COALESCE(student_subjects.code, "") as Code'),
                DB::raw('COALESCE(student_subjects.semester, "") as semester'),
                DB::raw($withGrade ? 'COALESCE(student_subjects.grade, "") as Grade' : '"" as Grade'),
                DB::raw("CASE WHEN create_accounts.status IN ('PENDING', 'FOR ENROLLMENT', 'ACCOUNTING','PROCEED TO CASHIER') THEN 'NOT OFFICIALLY ENROLLED' ELSE create_accounts.status END as status")

            )
            ->get();


        $studentData->transform(function ($student) {
            $statusMap = [
                'PENDING' => 'NOT OFFICIALLY ENROLLED',
                'FOR ENROLLMENT' => 'NOT OFFICIALLY ENROLLED',
                'ACCOUNTING' => 'NOT OFFICIALLY ENROLLED',
                'PROCEED TO CASHIER' => 'NOT OFFICIALLY ENROLLED',
            ];
            if (array_key_exists($student->status, $statusMap)) {
                $student->status = $statusMap[$student->status];
            }
            return $student;
        });
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Generate MasterList Ched Format Report Excel',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);
        return Excel::download(new MasterListExportChed($studentData, $withGrade), 'StudentMasterList.xlsx');
    }
    public function generatePDFDailyCollection(Request $request)
    {
        // Retrieve input values

        $dateFrom = $request->input('date');
        $dateTo = $request->input('dateTo') ?? $request->input('date');

        // Validate the date range
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'dateTo' => 'nullable|date|after_or_equal:date', // Ensures dateTo is later than or equal to dateFrom
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Proceed if validation passes
        $dailyCollection = fee_summary::with([
            'create_account',
            'nonassessed',
            'fee_collection_summaries',
        ])
            ->where('role_name_id', $request->role_name_id)
            ->when($request->campus, function ($query) use ($request) {
                return $query->where('campus_id', $request->campus);
            })
            ->whereDate('date', ">=", $dateFrom)
            ->whereDate('date', "<=", $dateTo)
            ->get();

        // Format the date for display
        // display campus
        $campus = $request->campus ? Campus::find($request->campus) : null;
        $campusDescription = $campus?->description ?? '';
        $formattedDate = $dateFrom == $dateTo
            ? Carbon::parse($dateFrom)->format('F d, Y')
            : Carbon::parse($dateFrom)->format('F d, Y') . ' to ' . Carbon::parse($dateTo)->format('F d, Y');

        // Map the collection for the view
        $extractedData = $dailyCollection->map(function ($item) {
            return [
                'cashier' => $item->role_name_id,
                'name' => $item->name,
                'date' => $item->date,
                'or_number' => $item->or_number,
                'id_number' => $item->create_account?->last_name . " " . $item->create_account?->first_name . " " . $item->create_account?->middle_name,
                'period' => $item->schoolYear?->code,
                'dept' => $item->department?->code,
                'bank' => $item->payment_status,
                'check_no' => $item->check_no,
                'amount' => $item->downpayment,
            ];
        });
        // dd($extractedData);

        // Pass the extracted data to the view
        $pdf = Pdf::loadView('Roles.Super_Administrator.printStudentAssessment.dailycollection', [
            'data' => $extractedData,
            'date' => $formattedDate,
            'campus' => $campusDescription,
        ]);

        return $pdf->stream('dailyCollection.pdf');
    }
    public function discountCollection(Request $request)
    {
        $deparment = $request->department_id_id;
        $discount_collection = $request->discount_collection;

        $validator = Validator::make($request->all(), [
            'department_id_id' => 'nullable',
            'discount_collection' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $tablequery = fee_summary::when($deparment, function ($query) use ($deparment) {
            return $query->where('department_id', $deparment);
        })
            ->where('type', $discount_collection)
            ->get();
        // dd($tablequery);
        $studentData = $tablequery->map(function ($item) {
            return [
                'id_number' => $item->id_number,
                'full_name' => $item->create_account?->last_name . " " . $item->create_account?->first_name . " " . $item->create_account?->middle_name,
                'course/department' => $item->department?->description,
                'discount_type' => $item->discount_type,
                'discount_code' => $item->discount_code,
                'DiscountAmount' => $item->downpayment,
                'reason/remarks' => $item->{'reason/remarks'},

            ];
        });
        return Excel::download(new discountCollectionExport($studentData), 'DailyCollection.xlsx');
    }
    public function generatePDFDailyCollectionFees(Request $request)
    {

        $dateFrom = $request->input('date');
        $dateTo = $request->input('dateTo') ?? $request->input('date');

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'dateTo' => 'nullable|date|after_or_equal:date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $dailyCollection = FeeCollectionHistory::with(['create_account', 'campus', 'course'])
            ->when($request->course_id, function ($query) use ($request) {
                return $query->where('course_id', $request->course_id);
            })
            ->whereDate('created_at', ">=", $dateFrom)
            ->whereDate('created_at', "<=", $dateTo)
            ->get();
        // dd($dailyCollection);
        foreach ($dailyCollection as $item) {

            $category = $item->category;
            $course = $item->course?->code;
            $subCategory = $item->subCategory;
            $amount = $item->amount_subtracted ?? 0;
            if (!isset($groupedData[$course][$category])) {
                $groupedData[$course][$category] = [];
            }
            if ($amount == 0) {
                continue;
            }

            if (!isset($groupedData[$course][$category][$subCategory])) {
                $groupedData[$course][$category][$subCategory] = [
                    'amount' => 0,
                    'year_level' => $item->year_level,
                    'campus' => $item->campus?->code,

                ];
            }
            $groupedData[$course][$category][$subCategory]['amount'] += $amount;
        }

        return Excel::download(new feescollectionExport($groupedData), 'StudentReport.xlsx');
    }
    public function generateReportCollectionperCampus(Request $request)
    {
        // dd($request->all());
        $dateFrom = $request->input('date');
        $dateTo = $request->input('dateTo') ?? $request->input('date');

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'dateTo' => 'nullable|date|after_or_equal:date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $dailyCollection = FeeCollectionHistory::with(['create_account', 'campus', 'course', 'department'])
            ->when($request->department_id, function ($query) use ($request) {
                return $query->where('department_id', $request->department_id);
            })
            ->where('role_name_id', $request->role_id)
            ->whereDate('created_at', ">=", $dateFrom)
            ->whereDate('created_at', "<=", $dateTo)
            ->get();
        // dd($dailyCollection);
        $data = [];
        foreach ($dailyCollection as $collection) {
            $dept = $collection->department?->code;
            $role = $collection->role_name?->name;
            if (!isset($data[$dept])) {
                $data[$dept] = [
                    'date' => Carbon::now()->format('m-d-Y'),
                    'campus' => $dailyCollection->first()?->campus?->code,
                    'department' => $dept,
                    'name' => $role,

                ];
            }
            if (!isset($data[$dept][$collection->category])) {
                $data[$dept][$collection->category] = floatval($collection->amount_subtracted);
            } else {
                if ($collection->amount_subtracted !== null)
                    $data[$dept][$collection->category] += floatval($collection->amount_subtracted);
            }
        }

        // $categoryTotals = $dailyCollection->groupBy('category')->mapWithKeys(function ($items, $category) {
        //     return [$category => $items->sum('amount_subtracted')];
        // });

        // $mergedData = array_merge($mergedData, $categoryTotals->toArray());
        // $mergedData = [$dept => $mergedData];
        // dd($data);
        return Excel::download(new CollectionReportperCampExport($data), 'CollectionPerDepartment.xlsx');
    }
    public function generateReportCollectionperCategory(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //     'date' => 'required|date',
        //     'dateTo' => 'nullable|date|after_or_equal:date',
        //     'department_id' => 'nullable',
        //     'discCategory_id' => 'nullable',
        //     'discount_collection4' => 'nullable',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        // dd($request->all());
        $dateFrom = $request->input('date');
        $dateTo = $request->input('dateTo') ?? $request->input('date');

        $dailyCollection = fee_summary::with(['discount1'])
            ->where('type', 'Discount')
            ->when($request->department_id, function ($query) use ($request) {
                return $query->where('department_id', $request->department_id);
            })
            ->where('discount_id', $request->discCategory_id)
            ->whereDate('created_at', ">=", $dateFrom)
            ->whereDate('created_at', "<=", $dateTo)
            ->get();
        // dd($dailyCollection);
        $studentData = $dailyCollection->map(function ($item) {
            return [
                'department' => $item->department?->code,
                'discount' => $item->discount1?->code,
                'amount' => $item->downpayment,
            ];
        });
        return Excel::download(new DiscountCategoryExport($studentData), 'DiscountCollectionCategory.xlsx');
    }
}
