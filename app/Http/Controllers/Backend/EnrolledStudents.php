<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EnrolledStudent;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PDO;

class EnrolledStudents extends Controller
{
    //
    public function enrolled_students(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'id_number' => ['required'],
                'course_id' => ['required'],
                'curriculum_id' => ['required'],
                'year_level' => ['required'],
                'section_code' => ['required'],
                'semester' => ['required'],
                'student_type' => ['required'],
                'status' => ['required'],
                'total_units' => ['required'],
            ]);
            (new EnrolledStudent($request->only(['id_number', 'course_id', 'curriculum_id', 'year_level', 'section_code', 'semester', 'student_type', 'student_applicant_id', 'status', 'total_units'])))->save();
            return response(['status' => 'success', 'message' => 'Enrolled Subject Successfully Added']);
        } catch (\Exception $e) {

            return response(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    public function get_Section(Request $request)
    {
        $sectionCode = $request->input('section_code');
        $section = Section::where('section_code', $sectionCode)->first();
        return response()->json(['section_name' => $section->section_code]);
    }
}