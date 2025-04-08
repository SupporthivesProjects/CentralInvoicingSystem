<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // Show create form
    public function create()
    {
        $roles = Role::all(); // Fetch all roles
        return view('users.create', compact('roles'));
    }

    // Store user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            //'roles' => 'required|array',
            'role'     => 'required|exists:roles,id',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Attach roles to the user via pivot table
        $user->roles()->attach($request->role);

        //return redirect()->route('users.index')->with('success', 'User created successfully with assigned roles.');
        return back()->with('success', 'New user added');
    }
}
