<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phoneNumber' => ['required', 'string'],
            'location' => ['required', 'string'],
            'profile-image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);
        //for saving the image of the user 

        $fileName = $validated['name'] . '.' . $request->file('profile-image')->getClientOriginalExtension();
        $imagePath = $request->file('profile-image')->storeAs('Users', $fileName, 'public');
        $validated['profile-image'] = $imagePath;

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phoneNumber' => $validated['phoneNumber'],
            'location' => $validated['location'],
            'profile-image' => $validated['profile-image']
        ]);

        return $user;
    }
}
