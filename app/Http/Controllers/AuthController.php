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

        $token = $user->createToken('auth_token', ['*'], now()->addDays(1))->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function authenticate(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', ['*'], now()->addDays(1))->plainTextToken;
//        TODO: create middleware to check if the user's token is expired
//        $token = $user->createToken('auth_token', [], now()->addMinutes(10))->plainTextToken;

//        TODO: check good practice to return the user
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->id == Auth::id()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

//    public function authenticate(Request $request): JsonResponse
//    {
//        $credentials = $request->validate([
//            'email' => ['required', 'email'],
//            'password' => ['required'],
//        ]);
//
//        if (Auth::attempt($credentials)) {
//            $request->session()->regenerate();
//            $request->user()->tokens()->delete();
//            $request->user()->createToken('auth_token', ['*'], now()->addDays(1))->plainTextToken;
//            return response()->json([
//                'message' => 'User authenticated',
//                'user' => $request->user(),
//            ]);
//        } else {
//            return response()->json([
//                'message' => 'Invalid credentials',
//            ], 401);
//        }
//    }
}

