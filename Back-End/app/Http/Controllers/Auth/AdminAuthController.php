<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AdminAuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required'],
            'phoneNumber' => ['required', 'string', 'exists:users,phoneNumber']
        ]);

        $user = User::where('phoneNumber', $request->phoneNumber)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message' => 'the email or the password are incorrect'
            ];
        }

        if ($user->role != 'admin') {
            return response([
                'message' => 'you are not an admin'
            ], 403);
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'you are logged out',
        ];
    }
}
