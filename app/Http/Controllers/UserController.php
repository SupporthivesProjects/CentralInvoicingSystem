<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all roles
        return view('users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            //'roles' => 'required|array',
            'role'     => 'required|exists:roles,id',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->has('status') ? 1 : 0,
        ]);

        $user->roles()->attach($request->role);
        return back()->with('success', 'New user added');
    }
    public function edit(User $user)
    {
        $roles = Role::all(); // To show available roles in the edit form
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|exists:roles,id',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Sync role (only one role allowed)
        $user->roles()->sync([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
