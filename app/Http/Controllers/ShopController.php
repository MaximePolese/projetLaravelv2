<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Shop::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/shops",
     *      summary="Create a new shop",
     *      tags={"Shops"},
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *           required=true,
     *          @OA\JsonContent(
     *               required={"shop_name", "shop_theme", "biography"},
     *                  @OA\Property(property="shop_name", type="string", example="My Shop"),
     *                  @OA\Property(property="shop_theme", type="string", example="Dark"),
     *               @OA\Property(property="biography", type="string", example="This is my shop")
     *              )
     *      ),
     *      @OA\Response(response=201, description="Shop created successfully"),
     *      @OA\Response(response=401, description="Unauthenticated"),
     *      @OA\Response(response=422, description="Invalid data")
     * )
     */
    public function store(StoreShopRequest $request): JsonResponse
    {
        $response = Gate::inspect('store', Shop::class);
        if ($response->allowed()) {
            $shop = new Shop();
            $shop->fill($request->validated());
            $user = $request->user();
            if ($user->role != 'craftman') {
                $user->role = 'craftman';
            }
            $user->shops()->save($shop);
            return response()->json($shop, 201);
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop): Shop
    {
        return $shop;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopRequest $request, Shop $shop): JsonResponse
    {
        $response = Gate::inspect('update', $shop);
        if ($response->allowed()) {
            $shop->fill($request->validated());
            $shop->save();
            return response()->json($shop, 200);
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop): JsonResponse
    {
        $response = Gate::inspect('delete', $shop);
        if ($response->allowed()) {
            $user = $shop->user;
            $shop->delete();
            if ($user->shops()->count() == 0) {
                $user->role = 'user';
                $user->save();
            }
            return response()->json(['message' => 'Shop deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    }
}
