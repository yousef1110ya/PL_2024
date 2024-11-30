<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;


class CreatingController extends Controller
{
    //this controller is all about creating orders

    public function createOrder(Request $request, $storeId, $productId)
    {
        // Assuming the user is authenticated and their ID is available in the request
        $userId = $request->user()->id;

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

        // Assuming the product is associated with the store
        if ($product->store_id !== $storeId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product does not belong to this store'
            ], 403);
        }

        // Create a new order
        $order = Order::create([
            'store_id' => $storeId,
            'user_id' => $userId,
            'product_list' => json_encode([$productId]), // Assuming a simple array of product IDs for demonstration
            'current_state' => 'pending', // Assuming an initial state for the order
            'order_date' => now()->toDate(),
        ]);

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }

    public function getAllOrders(Request $request)
    {
        $orders = Order::paginate(10);
        return response()->json($orders);
    }

}
