<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreUserRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request): JsonResponse
    {
        $service = new UserService();
        $user = $service->createUser($request->validated());
        Auth::login($user);
        return response()->json([
            'user' => $user,
        ]);
    }

    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'message' => 'User authenticated',
                'user' => $request->user(),
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->id == Auth::id()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            //TODO: fix session invalidation
            return response()->json(['message' => 'Logged out']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}

