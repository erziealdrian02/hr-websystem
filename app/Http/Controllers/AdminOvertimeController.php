<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminOvertimeController extends Controller
{
    public function overtimeAdmin()
    {
        $title = 'Overtime Request - HRIS';
        return view('page-admin.admin-overtime', compact('title'));
    }
}
