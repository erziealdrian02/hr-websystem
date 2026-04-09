<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users()
    {
        $title = 'Users - HRIS';
        return view('page-user.users', compact('title'));
    }
}
