<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Order::all();
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): Order
    {
        return $order->load('products');
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
//        TODO: implement update order
//        $order->fill($request->validated());
//        $order->save();
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        if (Auth::id() == $order->user_id) {
            $order->products()->detach();
            $order->delete();
        }
        return response()->json(['message' => 'Order deleted successfully.'], 200);
    }
}
