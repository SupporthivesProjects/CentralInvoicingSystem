<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;


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

        Profile::create([
            'user_id' => $user->id,
            'bio' => null,
            'experience' => null,
            'location' => null,
            'mobile' => null,
            'slack' => null,
            'portfolio' => null,
            'github' => null,
            'twitter' => null,
            'linkedin' => null,
            'profile_image' => 'images/defaults/profile/profilephoto/default.png', // Default profile image
            'cover_image' => 'images/defaults/profile/coverphoto/default.webp',
        ]);
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
     public function showForgotForm()
    {
        return view('pages.forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $status = Password::sendResetLink($request->only('email'));

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('success', __($status));
            } else {
                return back()->with('error', __($status));
            }

        } catch (Exception $e) {
            // Log the full error for debugging
            Log::error('Mail Sending Failed: '.$e->getMessage());

            // Show toast with short version
            return back()->with('error', 'Mail sending failed. Please check SMTP credentials.');
        }
    }


    public function showResetForm(Request $request, $token)
    {
        return view('pages.reset_password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

        public function resetPassword(Request $request)
        {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->route('login')->with('success', __($status));
            } else {
                return back()->with('error', __($status));
            }
        }

}

