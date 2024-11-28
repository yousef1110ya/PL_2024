<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //
    public function uploadProfileImage(Request $request)
    {
        $request->validate(['profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',]);
        $user = Auth::user();
        $imageName = $user->name->extension();
        $request->profile_image->move(public_path('profile_images'), $imageName);
        // If the user already has a profile image, delete the old one
        if ($user->profile_image) {
            Storage::delete('profile_images/' . $user->profile_image);
        }
        $user->profile_image = $imageName;
        $user->save();
        return back()->with('success', 'Profile image updated successfully.')->with('profile_image', $imageName);
    }
}
