<?php

namespace App\Http\Controllers\Admin;

use View;
use Auth;
use App\Models\Designer;
use Illuminate\Http\Request;
use App\Exports\DashboardExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AdminController;

class DashboardExportController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function dashboardExport(Request $request)
    {
        $type = $request->type;
        return Excel::download(new DashboardExport($request), $type . '-Sale.xlsx');
    }
}