<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CurriculumSubject;
use App\Models\Section;
use App\Models\section_subjectss;
use Illuminate\Http\Request;

class CurriculumCoursesController extends Controller
{
    public function getCoursesByCurriculum($year_level, $section_id, $semester_id, Request $request)
    {
        // dd($year_level, $semester_id, $section_id);

        // dd($request->all());
        if (request()->ajax()) {
            $subjects = section_subjectss::where('section_id', $request->section_code)
                ->where('is_active', false)
                ->get();
            // $subjects->load(['detailsofsubjects' => function ($query) use ($section_id) {
            //     $query->where('section_id', $section_id);
            // }]);
            // // Example of processing subjects
            // if ($subjects->isNotEmpty()) {
            //     foreach ($subjects as $subject) {
            //         foreach ($subject->sections as $section) {
            //             if ($section->pivot->section_id === $section_id) {
            //                 $subject->detailsofsubjects()->update([
            //                     'time' => null,
            //                     'day' => null,
            //                     'room' => null,
            //                     'instructor_id' => null,
            //                     'department' => null,
            //                 ]);
            //             }
            //         }
            //     }
            // }
            $datatables = datatables()->of($subjects)
                ->addIndexColumn()
                ->addColumn('department', function ($query) {
                    return $query->latestDetailOfSubject?->instructorss?->department_id;
                })
                ->addColumn('instructor_id', function ($query) {
                    return $query->instructor?->full_name;
                })

                ->addColumn('lab_name', function ($query) {
                    return $query?->laboratory?->description;
                })
                ->rawColumns(['action', 'time', 'day', 'room', 'instructor_id', 'department']);
            return $datatables->make(true);
        }
    }
    public function getCurriculumHs($year_level, $section_id, $semester_id)
    {
        if (request()->ajax()) {
            $subjects = section_subjectss::where('section_id', $section_id)
                ->where('year_level', $year_level)
                ->where('semester_id', $semester_id)
                ->where('is_active', false)
                ->get();

            // dd($subjects);
            // $subjects->load(['detailsofsubjects' => function ($query) use ($section) {
            //     $query->where('section_id', $section->id);
            // }]);
            // if ($subjects->isNotEmpty()) {
            //     foreach ($subjects as $subject) {
            //         foreach ($subject->sections as $section) {
            //             if ($section->pivot->section_id === $section_code) {
            //                 $subject->detailsofsubjects()->update([
            //                     'time' => null,
            //                     'day' =>  null,
            //                     'room' => null,
            //                     'instructor_id' => null,
            //                     'department' => null,
            //                 ]);
            //             }
            //         }
            //     }
            // }
            $datatables = datatables()->of($subjects)
                ->addIndexColumn()


                ->addColumn('department', function ($query) {
                    return $query->latestDetailOfSubject?->instructorss?->department_id;
                })

                ->addColumn('lab_name', function ($query) {
                    return $query->laboratory?->description;
                })
                ->rawColumns(['action', 'time', 'day', 'room', 'instructor_id', 'department']);
            return $datatables->make(true);
        }
    }
}