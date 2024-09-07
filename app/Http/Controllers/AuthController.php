<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required ',
            'email' => 'required | email | unique:users',
            'password' => 'required | min:5',
        ]);

        $user = User::create($validated);
        $token = $user->createToken($request->name);

        return response()->json(
            [
                'status' => true,
                'user' => $user,
                'token' => $token->plainTextToken,
            ],
            200,
        );
    }
    public function login(Request $request)
    {
         $request->validate([
            'email' => 'required | email | exists:users',
            'password' => 'required | min:5',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'status' => false,
                    'errors'=> [
                        'email'=>['The provided credentials are incorrect']
                    ]
                ],
                401,
            );
        }

        $token = $user->createToken($user->name);

         return response()->json(
            [
                'status' => true,
                'user' => $user,
                'token' => $token->plainTextToken,
            ],
            200,
        );
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'User logged out',
            'data'=>[],
        ], 200);
    }
}
