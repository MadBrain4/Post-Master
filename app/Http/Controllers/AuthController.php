<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(LoginRequest $request) : JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or password is incorrect'
            ], 401);  
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'data' => new UserResource($user),
            'success' => true,
            'message' => __('messages.login'),
            'access_token' => $user->createToken('API TOKEN')->plainTextToken
        ]);
    }

    public function register(RegisterRequest $request) : JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, 
        ]);

        return response()->json([
            'data' => new UserResource($user),
            'success' => true,
            'message' => __('messages.register')
        ], 201);
    }
}
