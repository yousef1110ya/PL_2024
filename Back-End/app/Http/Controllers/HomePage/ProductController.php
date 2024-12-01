<?php

namespace App\Http\Controllers\HomePage;

use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addToCart(Request $request , $productId)
    {
    $user = $request->user();
    $product = Product::find($productId);
    $cart = $user->shopping_cart;
    if (!$cart) {
        $cart = [];
    }
    $cart[$productId] = [
        'product_id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'quantity' => 1,
    ];
    $user->shopping_cart = $cart;
    $user->save();

    return $cart;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request , $storeId)
    {

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'name_AR' => 'required|string|max:255',
        'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'phone' => 'required|string|max:20',
    ]);

    $validatedData['store_id'] = $storeId; // Save the store_id column with the $storeId variable from the URL

    $fileName = $validatedData['name'] . '.' . $request->file('product_image')->getClientOriginalExtension();
    $imagePath = $request->file('product_image')->storeAs('Products', $fileName, 'public');
    $validatedData['product_image'] = $imagePath;

    $product = Product::create($validatedData);

    return response()->json([
        'status' => 'success',
        'message' => 'Product created successfully',
        'product' => $product
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}