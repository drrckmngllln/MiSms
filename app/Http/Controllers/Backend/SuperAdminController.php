<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CreateAccount;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    //
    public function superAdminDashboard()

    {
        $enrolledStudent = CreateAccount::where('status', 'OFFICIALLY ENROLLED')->count();
        $Accounting = CreateAccount::where('status', 'ACCOUNTING')->count();
        $PendingStudents = CreateAccount::where('status', 'PENDING')->count();
        $totalStudents = CreateAccount::count();

        return view('Roles.Super_Administrator.dashboard', compact('enrolledStudent', 'Accounting', 'PendingStudents', 'totalStudents'));
    }
}
