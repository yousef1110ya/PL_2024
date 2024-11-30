<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreTag;
use App\Models\ProductTags;
use App\Models\Product;

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
}
