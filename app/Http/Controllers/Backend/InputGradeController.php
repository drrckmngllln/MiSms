<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StudentSubject;
use Illuminate\Http\Request;

class InputGradeController extends Controller
{
    //

    public function inputGrade(Request $request)
    {
        // dd($request->all());

        $id = $request->input('id');
        $grade = $request->input('grade');

        //store natin sa database

        $student = StudentSubject::find($id);
        $student->grade = $grade;
        $student->save();

        return response()->json([]);
    }
    public function updateGrade(Request $request)
    {
        $id = $request->input('id');

        // Clear the grade in the database
        $student = StudentSubject::find($id);
        $student->grade = null;
        $student->save();

        return response()->json([]);
    }
}
