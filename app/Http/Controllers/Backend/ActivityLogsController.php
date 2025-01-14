<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\activity_logsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    //
    public function index(activity_logsDataTable $dataTable)
    {
        return $dataTable->render('Roles.Super_Administrator.activityLogs.index');
    }
}
