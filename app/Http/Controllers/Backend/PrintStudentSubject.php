<?php

namespace App\Http\Controllers\Backend;

use App\Exports\StudentWithSubject;
use App\Http\Controllers\Controller;
use App\Models\CreateAccount;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PrintStudentSubject extends Controller
{
    //
    public function printStudentSubject($id)
    {
        // dd($id);

        try {
            $createAccountTable = CreateAccount::with('course', 'studentSubjects.adddetails.instructorss')->findOrFail($id);
            // dd($createAccountTable);
            return Excel::download(new StudentWithSubject($createAccountTable), 'students.xlsx');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
