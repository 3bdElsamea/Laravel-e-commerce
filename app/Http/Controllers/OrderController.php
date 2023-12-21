<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Exception;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
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
//            If the cart is empty, return an error
            if ($cartItems->isEmpty()) {
                return responseJson(null, null, 400, 'Cart is empty.');
            }

            // Loop through the cart items and create a new order item for each
            foreach ($cartItems as $cartItem) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                ]);

                //Update the product quantity
                $cartItem->product->quantity = $cartItem->product->quantity - $cartItem->quantity;
                $cartItem->product->save();
            }

            //Clear the cart
            Cart::where('user_id', $userId)->delete();

            //Commit the transaction
            DB::commit();

//            Send notification to all admins
//            $admins = User::where('is_admin', 1)->get();
//            Notification::send($admins, new OrderCreatedNotification());

//            Send notification to all admins using event
            Event::dispatch(new OrderCreatedEvent(auth()->user()->name.' New Order Created'));


            return responseJson(null, null, 200, 'Order created successfully.');
        } catch (Exception $e) {
            //If an exception occurs, rollback the transaction
            DB::rollBack();
            return responseJson(null, null,500,$e->getMessage());
        }

    }
}
