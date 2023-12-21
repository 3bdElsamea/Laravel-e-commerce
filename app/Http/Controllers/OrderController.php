<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\Event;
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
            // Get the cart items for the user
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();
//            If the cart is empty, return an error
            if ($cartItems->isEmpty()) {
                return responseJson(null, null, 400, 'Cart is empty.');
            }

//            calculate total price
            $totalPrice = 0;
            foreach ($cartItems as $cartItem) {
                $totalPrice += $cartItem->product->price * $cartItem->quantity;
            }

            //Create a new order
            $order = Order::create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
            ]);

            // Loop through the cart items and create a new order item for each
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
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

//            Another way to send notification to all admins

//            Create a new notification
            Notification::create([
                'type' => 'App\Notifications\OrderCreatedNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => 3,
                'data' =>  auth()->user()->name.' made a New Order',
            ]);

//            Send notification to all admins using event
            Event::dispatch(new OrderCreatedEvent(auth()->user()->name.' made a New Order'));


            return responseJson(null, null, 200, 'Order created successfully.');
        } catch (Exception $e) {
            //If an exception occurs, rollback the transaction
            DB::rollBack();
            return responseJson(null, null,500,$e->getMessage());
        }

    }
}
