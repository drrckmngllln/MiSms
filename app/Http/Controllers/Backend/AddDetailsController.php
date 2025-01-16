<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\AddDetails as MailAddDetails;
use App\Mail\StudentApproved;
use App\Models\adddetails;
use App\Models\CurriculumSubject;
use App\Models\Section;
use App\Models\section_subjectss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AddDetailsController extends Controller
{
    //
    public function add_details_on_sucjects(Request $request, $id)
    {

        // dd($request->all());


        $existingAddDetail = adddetails::where('sectionSub_id', $request->sectionSub_id)->first();
        if ($existingAddDetail) {
            $existingAddDetail->update([
                'time' => $request->time,
                'day' => $request->day,
                'room' => $request->room,
                'instructor_id' => $request->instructor_id,
                'email' => $request->email,
                'semester' => $request->semester,
                'school_year' => $request->school_year,
                'subject_id' => $request->subject_id,
                'section_id' => $request->section_id,
            ]);
        } else {
            $request->validate([
                'time' => 'required',
                'day' => 'required',
                'room' => 'required',
                'instructor_id' => 'required',
                'semester' => 'required',
                'school_year' => 'required',
                'sectionSub_id' => 'required',
            ]);
            $request->validate(adddetails::$rules);

            $adddetailss = new adddetails([
                ...$request->only([
                    'time',
                    'day',
                    'room',
                    'instructor_id',
                    'email',
                    'semester',
                    'school_year',

                ]),
                'subject_id' => $request->subject_id,
                'section_id' => $request->section_id,
                'sectionSub_id' => $request->sectionSub_id,
            ]);

            $adddetailss->save();


            $adddetails = section_subjectss::findOrFail($id);
            // dd($adddetails);

            $adddetails->update([
                'time' => $request->time,
                'day' => $request->day,
                'room' => $request->room,
                'instructor_id' => $request->instructor_id,
                'school_year' => $request->school_year,
                'semester' => $request->semester,
                'email' => $request->email,


            ]);
        }



        // $curriculumSubject = CurriculumSubject::find($request->input('subject_id'));
        // $newSectionIDs = (array)$request->input('section_id');


        // if ($curriculumSubject->sections()->exists()) {
        //     $currentSectionIDs = $curriculumSubject->sections->pluck('id')->toArray();

        //     $updatedSectionIDs = $currentSectionIDs;

        //     foreach ($newSectionIDs as $newID) {
        //         if (!in_array($newID, $currentSectionIDs)) {
        //             $updatedSectionIDs[] = $newID;
        //         }
        //     }
        //     $curriculumSubject->sections()->sync($updatedSectionIDs);
        // } else {
        //     $curriculumSubject->sections()->attach($newSectionIDs);
        // }

        return response(['status' => 'success', 'message' => 'Added Successfully']);
    }
}
