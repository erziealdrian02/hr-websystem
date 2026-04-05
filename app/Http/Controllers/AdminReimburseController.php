<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminReimburseController extends Controller
{
    public function reimburseAdmin()
    {
        $tile = 'All Reimburse - HRIS';
        return view('page-admin.admin-reimburse', compact('tile'));
    }
}
