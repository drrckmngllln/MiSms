<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Course;
use Illuminate\Http\Request;
use App\DataTables\FullPackagefeesDataTable;
use App\Models\fee_summary;
use App\Models\FullPackagefees;
use App\Models\OtherFee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class FullPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FullPackagefeesDataTable $dataTable)
    {
        //
        $campus = Campus::all();
        $course = Course::all();
        return $dataTable->render('Roles.Super_Administrator.fullpackage.index', compact('campus', 'course'));
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
        $request->validate(FullPackagefees::$rules);

        $miscfee = new FullPackagefees([
            ...$request->only([
                'category',
                'description',
                'semester',
                'campus_id',
                'fourth_year',
                'fifth_year',
                'course_id',
            ])
        ]);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Creating full package Fees Entry ',
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];
        DB::table('activity_logs')->insert($activityLog);

        $miscfee->save();
        $request->session()->flash('success', 'Miscellaneous Added Successfully');
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
    public function edit(Request $request, string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate(FullPackagefees::$rules);
        $miscfee = FullPackagefees::findOrFail($id);
        $miscfee->update(
            $request->only(['category', 'description', 'semester', 'campus_id', 'fourth_year', 'fifth_year', 'course_id'])
        );

        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Update full package Fees Entry '  . $request->category . ' ' . $request->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $miscfee->save();
        return redirect()->back()->with('success', ' Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //


        $fullpack = FullPackagefees::findOrFail($id);
        $user = Auth::user();
        $roleName = Role::find($user->roles()->first()?->id)?->name;

        $dt = Carbon::now('Asia/Manila');
        $activityLog = [
            'username' => $user->name,
            'email' => $user->email,
            'role_name' => $roleName,
            'modify_user' => 'Delete full package Fees Entry '  . $fullpack->category . ' ' . $fullpack->description,
            'date_time' => $dt->format('D, M j, Y g:i A'),
        ];

        DB::table('activity_logs')->insert($activityLog);
        $fullpack->delete();

        return response(['status' => 'success', 'message', 'Full Package Deleted Successfully']);
    }
    public function getLatestOrNumber(Request $request)
    {
        $latestFeeSummary = fee_summary::whereNotNull('or_number')
            ->where('or_number', '!=', '')
            ->latest()
            ->first();

        // Check if a record exists
        if ($latestFeeSummary) {
            // Get the latest or_number
            $orNumber = $latestFeeSummary->or_number;

            // Check if the OR number is 5 or 6 digits long
            if (strlen($orNumber) == 5 || strlen($orNumber) == 6) {
                // Increment the OR number by 1
                $newOrNumber = (int)$orNumber + 1;
                return response()->json(['or_number' => str_pad($newOrNumber, strlen($orNumber), '0', STR_PAD_LEFT)]);
            }

            // If OR number is not 5 or 6 digits, return the original number
            return response()->json(['or_number' => $orNumber]);
        }

        // If no valid OR number found, return an error message
        return response()->json(['error' => 'No valid OR Number found'], 404);
    }
    public function addOtherFees(Request $request)
    {

        $campus_id = $request->input('campus_id');
        $semester = $request->input('semester');
        $year_level = intval($request->input('year_level'));
        $id = $request->input('fee_id');

        $year_column = match ($year_level) {
            1 => 'first_year',
            2 => 'second_year',
            3 => 'third_year',
            4 => 'fourth_year',
            default => null,
        };
        $fees = OtherFee::where('campus_id', $campus_id)
            ->where('semester', $semester)
            ->where('id', $id)
            ->select('id', 'description', $year_column . ' as fee_amount')
            ->get();

        return response()->json($fees);
    }
}