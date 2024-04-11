<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return User::all();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateUserRequest $request): User
    {
        $user = $request->user();
        $user->fill($request->validated());
        $user->save();
        return $user;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();
        if ($user->id == Auth::id()) {
            $user->currentAccessToken()->delete();
            $user->delete();
        }
        return response()->json(['message' => 'User deleted successfully.'], 200);
    }
}

