<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Section;
use App\Models\StudentSubject;
use Illuminate\Http\Request;

class ClasslistController extends Controller
{
    //
    public function classList(Request $request)
    {

        try {

            if (request()->ajax()) {
                $departmentId = request()->input('department_id');

                $sections = Section::where('department_id', $departmentId)->get();
                // dd($sections);
                $data = [];
                foreach ($sections as $section) {
                    $subjects = StudentSubject::where('section_id', $section->id)->get();

                    foreach ($subjects as $subject) {
                        $data[] = [
                            'section' => $section->section_code,
                            'code' => $subject->code,
                            'descriptive_tittle' => $subject->descriptive_tittle,
                            // 'instructor' => $subject?->adddetails?->instructor_id,
                        ];
                        // dd($data);
                    }
                }
                return datatables()->of($data)
                    ->addColumn('section', function ($data) {
                        return $data['section'];
                    })
                    ->addColumn('code', function ($data) {
                        return $data['code'];
                    })
                    ->addColumn('descriptive_tittle', function ($data) {
                        return $data['descriptive_tittle'];
                    })
                    ->rawColumns(['section', 'descriptive_tittle'])
                    ->addIndexColumn()
                    ->make(true);
            }
            // if (request()->ajax()) {
            //     $departmentId = request()->input('department_id');
            //     // dd($departmentId);
            //     return datatables()->of(
            //         Department::with('section', 'studentSubject', 'instructor')
            //             ->whereHas('section', function ($query) use ($departmentId) {
            //                 return $query->where('department_id', $departmentId);
            //             })
            //             ->get()
            //     )->addColumn('action', function ($data) {
            //     })
            //         ->addColumn('sections', function ($sections) {
            //             return $sections->section->pluck('section_code');
            //         })
            //         // ->addColumn('subjects', function ($sections) {
            //         //     return $sections?->studentSubject?->code;
            //         // })
            //         // ->addColumn('description', function ($sections) {
            //         //     return $sections?->studentSubject?->descriptive_tittle;
            //         // })
            //         // ->addColumn('units', function ($sections) {
            //         //     return $sections?->studentSubject?->total_units;
            //         // })
            //         // ->addColumn('instructor', function ($sections) {
            //         //     return $sections?->instructor?->full_name;
            //         // })
            //         ->rawColumns(['action', 'sections'])
            //         ->addIndexColumn()
            //         ->make(true);
            // }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}