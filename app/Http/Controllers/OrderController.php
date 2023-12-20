<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //Start a database transaction
        DB::beginTransaction();

        try {
            $userId = auth()->id();
            //Create a new order
            $order = Order::create([
                'user_id' => $userId,
            ]);

            // Get the cart items for the user//            dd($userId);

            $cartItems = Cart::where('user_id', $userId)->with('product')->get();
            // Loop through the cart items and create a new order item for each
            foreach ($cartItems as $cartItem) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                ]);
            }

            //Clear the cart
            Cart::where('user_id', $userId)->delete();

            //Commit the transaction
            DB::commit();

            return responseJson(null, null, 200, 'Order created successfully.');
        } catch (Exception $e) {
            //If an exception occurs, rollback the transaction
            DB::rollBack();
            return responseJson(null, $e->getMessage(), 500);
        }

    }
}
