<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'pseudo' => ['nullable', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:5000'],
            'delivery_address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'pseudo' => $request->pseudo,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'image' => $request->image,
            'delivery_address' => $request->delivery_address,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

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

