<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FeeTypeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\FeesCategory;
use App\Models\FeeType;
use App\Models\Section;
use Illuminate\Http\Request;

use function Termwind\render;

class FreeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FeeTypeDataTable $dataTable)
    {
        //
        $courses = Course::all();
        $feescategories = FeesCategory::all();
        return $dataTable->render('Roles.Super_Administrator.freetype.index', compact('courses', 'feescategories'));
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
        try {
            foreach ($request->fees as $fee) {
                $fee = json_decode($fee);
                $feetypeid = $fee[0];

                $amountWithSymbol = $fee[2];

                $amount = floatval(str_replace('₱', '', $amountWithSymbol));

                (new FeeType([
                    ...$request->only(['course_code', 'course_id', 'year_level', 'remarks']),
                    'amount_id' => $amount,
                    'fee_type_id' => $feetypeid
                ]))->save();
            }
        } catch (\Exception $e) {
            dd($e);
        }
        return response(['status' => 'success', 'message' => 'Added Successfully']);
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $feetype = FeeType::findOrFail($id);

        $feetype->delete();
        return response(['status' => 'success', 'message' => 'Deleted successfully!']);
    }
    public function get_feetype(string $course_id)
    {
        return FeesCategory::where('course_id', $course_id)->select('id', 'category', 'freetype', 'amount')->get();
    }
}