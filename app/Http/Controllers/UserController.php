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
     * @OA\Get(
     *     path="/users",
     *     summary="Get a list of users",
     *     tags={"Users"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
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
        //TODO: implement the delete method when the user has orders (foreign key constraint)
        if ($request->user()->id == Auth::id()) {
            Auth::guard('web')->logout();
            $request->user()->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            //TODO: fix session invalidation
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}

