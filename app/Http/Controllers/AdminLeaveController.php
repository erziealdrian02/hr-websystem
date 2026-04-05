<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLeaveController extends Controller
{
    public function leaveAdmin()
    {
        $tile = 'Leave Request - HRIS';
        return view('page-admin.admin-leave', compact('tile'));
    }
}
