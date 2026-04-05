<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOvertimeController extends Controller
{
    public function overtimeAdmin()
    {
        $tile = 'Overtime Request - HRIS';
        return view('page-admin.admin-overtime', compact('tile'));
    }
}
