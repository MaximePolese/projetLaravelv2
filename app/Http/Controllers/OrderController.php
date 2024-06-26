<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Order::class);
        if ($response->allowed()) {
            return response()->json(Order::all()->load('products'), 200);
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $response = Gate::inspect('store', Order::class);
        if ($response->allowed()) {
            $order = new Order();
            $user = $request->user();

            $lastOrder = Order::orderBy('order_number', 'desc')->first();
            $order->order_number = $lastOrder ? $lastOrder->order_number + 1 : 1;
            $order->status = "pending";

            $user->orders()->save($order);

            foreach ($request->input('data') as $product) {
                $p = Product::find($product['id']);
                if ($p) {
                    if ($product['quantity'] > $p->stock_quantity) {
                        throw new \Exception('Not enough stock for product ' . $p->name);
                    }
                    $p->stock_quantity -= $product['quantity'];
                    $p->save();
                    $order->products()->attach($product['id'], ['quantity' => $product['quantity'], 'price' => $product['price'], 'created_at' => now(),
                        'updated_at' => now()]);
                }
            }
            $order->save();
            return response()->json($order->load('products'), 201);
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        $response = Gate::inspect('view', $order);
        if ($response->allowed()) {
            return response()->json($order->load('products'), 201);
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order): Order
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        $response = Gate::inspect('delete', $order);
        if ($response->allowed()) {
            $order->products()->detach();
            $order->delete();
            return response()->json(['message' => 'Order deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }
    }
}
