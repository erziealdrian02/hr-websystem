<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPayrollController extends Controller
{
    public function payrollAdmin()
    {
        $title = 'All Payroll - HRIS';
        return view('page-admin.admin-payroll', compact('title'));
    }
}
