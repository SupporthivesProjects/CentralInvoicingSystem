<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        return view('profiles.profile', compact('user', 'profile'));
    }
    public function edit()
    {
        $profile = Auth::user()->profile ?? new Profile(['user_id' => Auth::id()]);
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'bio' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'slack' => 'nullable|string|max:255',
            'portfolio' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if (!$profile) {
            $profile = new Profile(['user_id' => $user->id]);
            $profile->save(); // 🔐 Important to get the ID
        }
        $profile->fill($validated);
        // === Profile Image ===
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            // Delete old image if exists
            if ($profile->profile_image && File::exists(public_path($profile->profile_image))) {
                File::delete(public_path($profile->profile_image));
            }

            $filename = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            $folder = "uploads/profiles/profilephoto/{$user->id}";

            // Create directory if not exists
            if (!File::exists(public_path($folder))) {
                File::makeDirectory(public_path($folder), 0775, true);
            }

            $request->file('profile_image')->move(public_path($folder), $filename);
            $profile->profile_image = '/' . $folder . '/' . $filename;
            $profile->save();
        }

        // === Cover Image ===
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($profile->cover_image && File::exists(public_path($profile->cover_image))) {
                File::delete(public_path($profile->cover_image));
            }

            $filename = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $folder = "uploads/profiles/coverphoto/{$user->id}";

            // Create directory if not exists
            if (!File::exists(public_path($folder))) {
                File::makeDirectory(public_path($folder), 0775, true);
            }

            $request->file('cover_image')->move(public_path($folder), $filename);
            $profile->cover_image = $folder . '/' . $filename;
        }

        // $profile->fill($validated);
        $profile->save();

        return redirect()->route('myprofile')->with('success', 'Profile updated successfully!');
    }

}
