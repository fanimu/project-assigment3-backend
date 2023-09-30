<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        $credentials = request(['email', 'password']);
        $token = auth() -> attempt($credentials);
        if (!$token){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60]);
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh(){
        return response()->json([
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function data(){
        return response()->json(auth()->user());
    }
}
