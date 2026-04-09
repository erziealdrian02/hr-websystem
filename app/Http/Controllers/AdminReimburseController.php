<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminReimburseController extends Controller
{
    public function reimburseAdmin()
    {
        $title = 'All Reimburse - HRIS';
        return view('page-admin.admin-reimburse', compact('title'));
    }
}
