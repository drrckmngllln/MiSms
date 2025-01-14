<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradesInternalDataController extends Controller
{
    //
    public function getStudentSubjects()
    {
        return view('Roles.Super_Administrator.gradesInternalData.index');
    }
}
