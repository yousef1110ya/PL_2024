<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStateChangeNotification;

class DashController extends Controller
{
    /**
     * CREATING ALL THE PRODUCT DASH BOARD FUNCTIONALITIES
     */
    public function createProduct(Request $request, $StoreId)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'name_AR' => 'required|string|max:255',
            'description' => 'nullable|string',
            'description_AR' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData['store_id'] = $StoreId; // Save the store_id column with the $storeId variable from the URL

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

    public function editProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'name_AR' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'description_AR' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric',
            'quantity' => 'sometimes|required|integer',
            'product_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        if ($request->hasFile('product_image')) {
            $fileName = $validatedData['name'] . '.' . $request->file('product_image')->getClientOriginalExtension();
            $imagePath = $request->file('product_image')->storeAs('Products', $fileName, 'public');
            $validatedData['product_image'] = $imagePath;
        }

        $product->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);
    }

    public function deleteProduct(Request $request)
    {
        $productId = $request->input('productId');
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 200);
    }



    /**
     * CREATING ALL THE STORE FUNCTIONALTIES
     */
    public function createStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'name_AR' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'store-image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'required|string|max:20',

        ]);

        $fileName = $validatedData['name'] . '.' . $request->file('store-image')->getClientOriginalExtension();
        $imagePath = $request->file('store-image')->storeAs('Stores', $fileName, 'public');
        $validatedData['store-image'] = $imagePath;


        $store = Store::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Store created successfully',
            'store' => $store
        ], 201);
    }

    public function editStore(Request $request, $storeId)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'name_AR' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'store-image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'sometimes|required|string|max:20',
        ]);

        $store = Store::find($storeId);
        if (!$store) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found'
            ], 404);
        }

        if ($request->hasFile('store-image')) {
            $fileName = $request->input('name') . '.' . $request->file('store-image')->getClientOriginalExtension();
            $imagePath = $request->file('store-image')->storeAs('Stores', $fileName, 'public');
            $validatedData['store-image'] = $imagePath;
        }

        $store->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Store updated successfully',
            'store' => $store
        ], 200);
    }

    public function deleteStore(Request $request, $storeId)
    {
        $store = Store::find($storeId);
        if (!$store) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found'
            ], 404);
        }

        $store->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Store deleted successfully'
        ], 200);
    }
}
