<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users()
    {
        $title = 'Users - HRIS';
        $dataUsers = User::all();

        return view('page-user.users', compact('title', 'dataUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        User::create($request->all());

        return redirect()->route('users');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = User::find($id);

        $user->update($request->all());

        return redirect()->route('users');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->is_active = '0';
        $user->save();

        return redirect()->route('users');
    }
}
