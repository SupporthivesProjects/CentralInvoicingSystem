<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function loginform()
    {
        return view('pages.login');
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Fetch user by email
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Invalid credentials');
        }

        // Check if user is active
        if ($user->status != 1) {
            return back()->with('error', 'Account is inactive. Please contact support.');
        }

        // Attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid credentials');
    }


    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}

