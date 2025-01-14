<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CreateAccount;
use App\Models\fee_summary;
use App\Models\StudentSubject;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator as ValidationValidator;


class CancelEnrollementController extends Controller
{
    //
    public function cancelEnrollment(Request $request)
    {
        // dd($id_number);

        $checkedData = $request->input('checkedData');
        $validatedData = Validator::make($checkedData, [
            '*.id_number' => 'required|string|exists:create_accounts,id_number',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()], 422);
        }

        DB::transaction(function () use ($checkedData) {
            foreach ($checkedData as $data) {
                $idNumber = $data['id_number'];


                StudentSubject::where('id_number', $idNumber)
                    ->delete();
                // fee_summary::where('id_number', $idNumber)
                //     ->delete();
                CreateAccount::where('id_number', $idNumber)

                    ->where('status', '!=', 'CANCEL ACCOUNT')
                    ->update(['status' => 'CANCEL ACCOUNT']);
            }
        });
        // Ibalik ang response
        return response()->json(['message' => 'Delete!']);
    }
}
