<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get Cart Items for the current user
        $userId = auth()->id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();

        //Return the cart items
        return responseJson(CartResource::Collection($cartItems));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AddToCartRequest $request)
    {
        $userId = auth()->id();
        //Get the validated $productId and $quantity from the request
        $productId = $request->validated()['product_id'];
        $quantity = $request->validated()['quantity'];

        //Check if the product is already in the cart
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        //If the product is already in the cart, update the quantity
        if ($cartItem) {
            //Load the product relationship
            $cartItem->load('product');
            // Validate if the incresed quantity wouldn't exceed the available quantity
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $cartItem->product->quantity) {
                return responseJson(null, null, 422, "The selected quantity exceeds the available quantity of {$cartItem->product->quantity}.");
            }
            $cartItem->increment('quantity', $quantity);

            return responseJson(null, null, 200, "Item quantity updated successfully.");
        }
        //If the product is not in the cart, create a new cart item
        Cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        return responseJson(null, null, 200, "Item added to cart successfully.");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //Get the validated $quantity from the request
        $quantity = $request->validated()['quantity'];

        //Load the product relationship
//        $cart->load('product');

        // Validate if the incresed quantity wouldn't exceed the available quantity
//        $newQuantity = $quantity;
//        if ($newQuantity > $cart->product->quantity) {
//            return responseJson(null, "The selected quantity exceeds the available quantity of {$cart->product->quantity}.", 422);
//        }

        //Update the cart item
        $cart->update([
            'quantity' => $quantity,
        ]);

        return responseJson(null, null, 200, "Item quantity updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        // Delete the cart item
        $cart->delete();

        return responseJson(null, null, 200, "Item removed from cart successfully.");
    }
}
