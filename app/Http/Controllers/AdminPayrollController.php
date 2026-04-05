<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPayrollController extends Controller
{
    public function payrollAdmin()
    {
        $tile = 'All Payroll - HRIS';
        return view('page-admin.admin-payroll', compact('tile'));
    }
}
