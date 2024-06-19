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
        //TODO: modifier les rules pour créer un user
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
        ]);

        $token = $user->createToken('auth_token', ['*'], now()->addDays(1))->plainTextToken;
//        $token = $user->createToken('auth_token', [], now()->addMinutes(10))->plainTextToken;
//TODO: vérifier les bonne pratique sur le return du user
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        if ($user->tokens()->first()) {
            $token = $user->tokens()->first()->plainTextToken;
        } else {
            $token = $user->createToken('auth_token', ['*'], now()->addDays(1))->plainTextToken;
        }
//TODO: vérifier les bonne pratique sur le return du user
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->id == Auth::id()) {
            $user->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Logged out']);
    }
}

