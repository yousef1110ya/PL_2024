<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    public function create(Request $request)
    {
        if (!$request->name) {
            return 'this is delete';
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phoneNumber' => ['required', 'string', 'unique:users'],
            'location' => ['required', 'string'],
            'role' => ['string'],
            'profile-image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);
        //for saving the image of the user 

        $fileName = $validated['name'] . '.' . $request->file('profile-image')->getClientOriginalExtension();
        $imagePath = $request->file('profile-image')->storeAs('Users', $fileName, 'public');
        $validated['profile-image'] = $imagePath;

        echo "trying to create the user";
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phoneNumber' => $validated['phoneNumber'],
            'location' => $validated['location'],
            'role' => $validated['role'],
            'profile-image' => $validated['profile-image']
        ]);
        echo "created the user";

        $token = $user->createToken($request->name);
        echo "generated the user token";
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

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

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phoneNumber' => ['required', 'string', 'unique:users', 'min:10', 'max:15'],
            'location' => ['required', 'string', 'max:255'],
            'role' => ['sometimes', 'string', 'in:user,admin'],
            'profile-image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        //for saving the image of the user 

        $fileName = $validated['name'] . '.' . $request->file('profile-image')->getClientOriginalExtension();
        $imagePath = $request->file('profile-image')->storeAs('Users', $fileName, 'public');
        $validated['profile-image'] = $imagePath;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phoneNumber' => $validated['phoneNumber'],
            'location' => $validated['location'],
            'role' => $validated['role'],
            'profile-image' => $validated['profile-image']
        ]);


        $token = $user->createToken($request->name);
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
