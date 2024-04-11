<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Http\Requests\StoreOrderProductRequest;
use App\Http\Requests\UpdateOrderProductRequest;
use Illuminate\Database\Eloquent\Collection;

class OrderProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return OrderProduct::all();
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
    public function store(StoreOrderProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderProduct $order): OrderProduct
    {
        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderProduct $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderProductRequest $request, OrderProduct $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderProduct $order)
    {
        //
    }
}
