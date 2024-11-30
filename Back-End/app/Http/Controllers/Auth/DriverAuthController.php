<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
class DriverAuthController extends Controller
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

        if ($user->role != 'driver') {
            return response([
                'message' => 'sorry , this application is for drivers only and you are not a dtiver'
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
