<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class UserController extends Controller
{
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
