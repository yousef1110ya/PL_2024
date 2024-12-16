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

    public function acceptOrder(Request $request, $orderId)
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
    public function createOrder(Request $request)
    {
        $user = User::find($request->user()->id);

        // Calculate the fee as 10% of the product's price
        $totalSum = 0;
        if ($user->shopping_cart) {
            if (is_array($user->shopping_cart)) {
                $shoppingCart = $user->shopping_cart; // Directly use the array
            } else {
                $shoppingCart = json_decode($user->shopping_cart, true);
            }
            $totalSum = array_reduce($shoppingCart, function ($carry, $item) {
                return $carry + $item['price'] * $item['quantity'];
            }, 0);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'please add items to the shopping cart first'
            ]);
        }
        $fee = $totalSum * 0.1;

        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'product_list' => json_encode([$user->shopping_cart]), // Assuming a simple array of product IDs for demonstration
            'current_state' => 'pending', // Assuming an initial state for the order
            'order_date' => now()->toDate(),
            'fee' => $fee, // Adding the calculated fee to the order
            'total' => $totalSum, // the total sum of the order price
            'driver_id' => null, // Adding the driver id and setting it to null
        ]);
        $user->shopping_cart = [];
        $user->save();
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
        $orders = Order::where('current_state', 'pending')->paginate(10);
        return response()->json($orders);
    }


    // getting the ordering history of the user
    public function orderHistory(Request $request)
    {
        echo 'this is test';
        $userId = $request->user()->id;
        return response()->json([
            'status' => $userId,
        ]);
        // echo $userId;
        // $orders = Order::where('user_id', $userId)->get();
        // echo $orders;
        // return response()->json([
        //     'test' => 'thsdjkfdj',
        //     'status' => 'success',
        //     'orders' => $orders
        // ]);
    }
    public function getAllMyOrders(Request $request)
    {
        $userId = $request->user()->id;
        $orders = \App\Models\order::where('user_id', $userId)->get();
        if (!$orders) {
            return response()->json([
                'status' => 'WTF'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'orders' => $orders,
        ]);
    }

}