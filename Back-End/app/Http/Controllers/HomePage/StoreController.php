<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreTag;
use App\Models\ProductTags;
use App\Models\Product;
use App\Models\User;

class StoreController extends Controller
{
    //this controller is for all the used methodes inside the Home Page
    public function getStores()
    {
        // to get all the stores as pages
        $stores = Store::paginate(10);
        return response()->json([
            'status' => 'success',
            'stores' => $stores
        ]);
    }

    public function getProductDetails($storeId, $productId)
    {
        // Fetch the store and product from the database
        $store = Store::find($storeId);
        $product = Product::find($productId);

        // Check if the store and product exist
        if (!$store || !$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store or product not found'
            ], 404);
        }

        // Check if the product belongs to the store
        if ($product->store_id !== $storeId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product does not belong to this store'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);
    }
    public function getStoreTags()
    {
        // in this function we will call the store tags to put at the top of the HomePage

        $storeTags = StoreTag::paginate(10);
        return response()->json([
            'status' => 'success',
            'storeTags' => $storeTags
        ]);
    }

    public function search(Request $request)
    {
        // this function is for the search engine inside the homepage

        $searchTerm = $request->find;
        $storeTags = StoreTag::where('name', 'like', '%' . $searchTerm . '%')->pluck('id');
        $productTags = ProductTags::where('name', 'like', '%' . $searchTerm . '%')->pluck('id');
        $stores = Store::whereHas('tags', function ($query) use ($storeTags) {
            $query->whereIn('store_tag_id', $storeTags);
        })->get();
        $products = Product::whereHas('tags', function ($query) use ($productTags) {
            $query->whereIn('product_tag_id', $productTags);
        })->get();

        return response()->json([
            'status' => 'success',
            'storeTags' => $storeTags,
            'productTags' => $productTags
        ]);
    }

    public function getStore($id)
    {
        $store = Store::find($id);
        if (!$store) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'store' => $store,
            'products' => $store->products
        ]);
    }

    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
    }


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
}