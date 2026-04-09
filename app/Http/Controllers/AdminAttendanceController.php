<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function attendanceAdmin()
    {
        $title = 'All Attendance - HRIS';
        return view('page-admin.admin-attendance', compact('title'));
    }
}
