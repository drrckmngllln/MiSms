<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\nonassesed;
use App\Models\nonassessed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonAssessedController extends Controller
{
    //
    public function nonAssessed()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;
        $name = $user->name;
        return view('Roles.Super_Administrator.nonassessed.index', compact('role', 'name'));
    }
    public function saveNonAssessed(Request $request)
    {
        // dd($request->all());
        $studentFeeSummariess = new nonassessed([
            ...$request->only([
                'or_number', 'particulars', 'id_number', 'amount', 'cahier_in_charge', 'name', 'date', 'excess', 'payable'
            ])
        ]);
        $studentFeeSummariess->save();
        return response(['status' => 'success', 'message' => 'Confirm']);
    }
    public function get_non_assessed()
    {
        if (request()->ajax()) {
            return datatables()->of(nonassessed::get())
                ->addColumn('created_at', function ($row) {

                    return $row->created_at->format('Y-m-d');
                })
                // ->addColumn('department', function ($row) {
                //     return $row->create_account?->department?->code;
                // })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
