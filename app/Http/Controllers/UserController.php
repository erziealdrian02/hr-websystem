<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users()
    {
        $tile = 'Users - HRIS';
        return view('page-user.users', compact('tile'));
    }
}
