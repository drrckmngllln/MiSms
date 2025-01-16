<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CancelReceipt;
use App\Models\CreateAccount;
use App\Models\fee_summary;
use App\Models\FeeCollectionHistory;
use App\Models\FeesCategory;
use App\Models\studentAssesment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class CancelRecieptController extends Controller
{
    //
    public function cancelRecipt(Request $request)
    {
        if ($request->ajax()) {
            $data = CreateAccount::with('cancelReceipt')->get();
            // dd($data);

            return datatables()->of($data)
                ->addColumn('action', function ($query) {
                    $btncontainer = '<div class="d-flex justify-content-center">';
                    $btncontainer .= '<button class="btn btn-danger delete-item-cancel" data-id="' . $query->id . '" data-url="' . route('superadmin.cancelReciept.destroy', $query->id) . '">
                        <i class="ri-delete-bin-fill"></i>
                    </button>';
                    $btncontainer .= '</div>';
                    return $btncontainer;
                })
                ->addColumn('cancelRecieptStatus', function ($query) {
                    return $query->cancelReceipt ? ($query->cancelReceipt->or_number . '-' . 'Cancel Receipt') : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Roles.Super_Administrator.SOA.cancelRecieptindex');
    }

    public function destroy(Request $request, $id)
    {
        try {
            // Find the account by ID
            $createAccount = CreateAccount::findOrFail($id);
            $idNumber = $createAccount->id_number;

            // Get today's fee summary for the student
            $feeSummary = fee_summary::where('id_number', $idNumber)
                ->whereDate('created_at', now()->toDateString())
                ->first();

            // Save the OR number and latest downpayment
            $orNumber = $feeSummary?->or_number;
            $latestdownpayment = $feeSummary?->downpayment;

            // Delete today's fee summary
            fee_summary::where('id_number', $idNumber)
                ->whereDate('created_at', now()->toDateString())
                ->delete();

            // Store data in session for later use
            // session([
            //     'last_deleted_id_number' => $idNumber,
            //     'last_deleted_or_number' => $orNumber,
            //     'downpayment' => $latestdownpayment,
            // ]);

            // Find the latest semester for the student
            $latestSemester = studentAssesment::where('id_number', $idNumber)->max('semester');
            $studentAssessment = studentAssesment::where('id_number', $idNumber)
                ->where('semester', $latestSemester)
                ->orderBy('semester', 'desc')
                ->first();

            // Calculate new total assessment
            $downpayment = session('downpayment');
            $totalAss = $studentAssessment->total_assessment + $downpayment;

            // Distribute the total assessment across different periods
            $perSemlab = $totalAss / 5;
            $columnsToStoreslab = ['downpayment', 'prelims', 'midterms', 'semi_finals', 'finals'];
            studentAssesment::where('id_number', $studentAssessment->id_number)
                ->where('semester', $latestSemester)
                ->orderBy('semester', 'desc')
                ->update([
                    'total_assessment' => $totalAss,
                    ...array_fill_keys($columnsToStoreslab, $perSemlab),
                ]);

            // Get today's fee collection history for the student
            $feeCollections = FeeCollectionHistory::where('id_number', $idNumber)
                ->whereDate('created_at', now()->toDateString())
                ->get();

            // Process each fee and revert the assessment
            foreach ($feeCollections as $fee) {
                $assessment = null;

                if ($fee->misc_fees_id) {
                    $assessment = studentAssesment::where('id_number', $idNumber)
                        ->where('miscfee_id', $fee->misc_fees_id)
                        ->where('semester', $latestSemester)
                        ->first();
                } elseif ($fee->lab_id) {
                    $assessment = studentAssesment::where('id_number', $idNumber)
                        ->where('lab_id', $fee->lab_id)
                        ->where('semester', $latestSemester)
                        ->first();
                } elseif ($fee->otherFees_id) {
                    $assessment = studentAssesment::where('id_number', $idNumber)
                        ->where('otherFees_id', $fee->otherFees_id)
                        ->where('semester', $latestSemester)
                        ->first();
                } elseif ($fee->category === 'Tuition Fees') {
                    $assessment = studentAssesment::where('id_number', $idNumber)
                        ->where('category', 'Tuition Fees')
                        ->where('semester', $latestSemester)
                        ->first();
                }

                if ($assessment) {
                    $assessment->computation2Tuition = $assessment->computation;
                    $assessment->save();
                }

                // Delete each fee collection item
                $fee->delete();
            }

            // Delete the fee summary
            if ($feeSummary) {
                $feeSummary->delete();
            }

            //save 
            CancelReceipt::create([
                'id_number' => $idNumber,
                'semester' => $studentAssessment->semester,
                'or_number' => $orNumber,
            ]);
            return response()->json([
                'success' => 'Record deleted successfully!',
                'or_number' => $orNumber
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }
}
