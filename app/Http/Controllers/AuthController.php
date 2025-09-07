<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string', //мб надо email, а не string
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response(['message' => 'Wrong email'], 401);
        }

        if (!Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Wrong password'], 401);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged out']);
    }
}
