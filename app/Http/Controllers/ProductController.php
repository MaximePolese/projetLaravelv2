<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Get a list of all products.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Product::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // not implemented
    }

    /**
     * Store a newly created product in the database.
     *
     * @param StoreProductRequest $request
     * @return Product
     */
    public function store(StoreProductRequest $request): Product
    {
        $product = new Product();
        $user = $request->user();
        $shop = $user->shops()->find($request->shop_id);
        $product->fill($request->validated());
        $shop->products()->save($product);
        return $product;
    }

    /**
     * Display the specified product.
     *
     * @param Product $product
     * @return Product
     */
    public function show(Product $product): Product
    {
        return $product;
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     */
    public function edit(Product $product)
    {
        // not implemented
    }

    /**
     * Update the specified product in the database.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return Product
     */
    public function update(UpdateProductRequest $request, Product $product): Product
    {
        $product->fill($request->validated());
        $product->save();
        return $product;
    }

    /**
     * Remove the specified product from the database.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        if (Auth::id() == $product->shop->user_id) {
            $product->delete();
        }
        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }

    /**
     * Filter products based on the provided parameters.
     *
     * @param Request $request
     * @return Collection
     */
    public function filterBy(Request $request): Collection
    {
        $params = $request->input();
        $query = Product::query();
        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }
        return $query->get();
    }

    /**
     * Sort products based on the provided field and order.
     *
     * @param Request $request
     * @return Collection
     */
    public function sortBy(Request $request): Collection
    {
        $field = $request->input('field', null);
        $order = $request->input('order', null);

        // Validate the field and order
        $allowedFields = ['price', 'updated_at', 'stock_quantity'];
        $allowedOrders = ['asc', 'desc'];

        if (!in_array($field, $allowedFields) || !in_array($order, $allowedOrders)) {
            // You can choose to handle this error however you like
            throw new \InvalidArgumentException('Invalid field or order');
        }

        return Product::orderBy($field, $order)->get();
    }

    /**
     * Search for products based on the provided search term.
     *
     * @param Request $request
     * @return Collection
     */
    public function searchBy(Request $request): Collection
    {
        $searchTerm = $request->input('search_term', null);

        $query = Product::query();

        if ($searchTerm) {
            $fields = [
                'product_name',
                'description',
                'story',
                'material',
                'color',
                'size',
                'category',
            ];

            foreach ($fields as $field) {
                $query->orWhere($field, 'like', '%' . $searchTerm . '%');
            }
        }

        return $query->get();
    }

//TODO: Implement the addProductToOrder method
    public function addProductToOrder(Request $request, Product $product): Product
    {
//        $order = Auth::user()->orders()->where('status', 'pending')->first();
//        $order->products()->attach($product->id, ['quantity' => $request->quantity]);
        return $product;
    }
}
