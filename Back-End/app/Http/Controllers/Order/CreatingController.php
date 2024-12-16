<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStateChangeNotification;


class CreatingController extends Controller
{
    //this controller is all about creating orders

    public function acceptOrder(Request $request , $orderId)
    {
        $user = $request->user();
        $order = Order::find($orderId);
        $order->driver_id = $user->id;
        $order->save();
        return response()->json([
            'status' => 'your order was accepted by:',
            'driverName' => $user->name,
            'order' => $order
        ]);
    }
    // getting order by id
    public function getOrder($orderId)
    {
    $order = Order::find($orderId);
    if (!$order) {
        return response()->json([
            'status' => 'error',
            'message' => 'Order not found'
        ], 404);
    }
    return response()->json([
        'status' => 'success',
        'order' => $order
    ]);
    }


    // creating the order from the user page
    public function createOrder(Request $request, $storeId)
    {
        // Assuming the user is authenticated and their ID is available in the request
        $user = $request->user();
        // Fetch the store and product from the database
        $store = Store::find($storeId);
        //$product = Product::find($productId);


        // Calculate the fee as 10% of the product's price
        $totalSum = 0;
        foreach ($user->shopping_cart as $productDetails) {
            $totalSum += $productDetails['price'] ;
        }
        $fee = $totalSum * 0.1;

        // check all the products in the shopping cart and then see if all of them belong to the same store
        // if not then we will return an error message and ask the user to re order from the start

        $storeIds = array_map(function($productDetails) {
            return $productDetails['store_id'];
        }, $user->shopping_cart);

        if (!empty($storeIds) && count(array_unique($storeIds)) !== 1) {
            $user->shopping_cart = [];
            $user->save();
            return response()->json([
                'status' => 'error',
                'message' => 'All products in the shopping cart must belong to the same store.'
            ], 400);
        }
        // Create a new order
        $order = Order::create([
            'store_id' => $storeId,
            'user_id' => $user->id,
            'product_list' => json_encode([$user->shopping_cart]), // Assuming a simple array of product IDs for demonstration
            'current_state' => 'pending', // Assuming an initial state for the order
            'order_date' => now()->toDate(),
            'fee' => $fee, // Adding the calculated fee to the order
            'total' => $totalSum, // the total sum of the order price
        ]);

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }


    // updating the order from the driver page
    public function updateOrderState($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found'
            ], 404);
        }

        $newState = $order->current_state == 'pending' ? 'driving' : 'delivered';
        $order->update([
            'current_state' => $newState
        ]);

        if ($order->current_state == 'delivered') {
            $order->update([
                'deliver_date' => now()->toDate(),
            ]);
        }
        // Assuming there's a User model and a method to send notifications
        $user = User::find($order->user_id);
        if ($user) {
            $user->notify(new OrderStateChangeNotification($order, $newState));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order state updated to ' . $newState,
            'order' => $order
        ]);
    }


    // getting all the available orders for the drivers
    public function getAllOrders(Request $request)
    {
        $orders = Order::paginate(10);
        return response()->json($orders);
    }


    // getting the ordering history of the user
    public function orderHistory(Request $request)
    {
        $userId = $request->user()->id;
        $orders = Order::where('user_id', $userId)->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ]);
    }

}
