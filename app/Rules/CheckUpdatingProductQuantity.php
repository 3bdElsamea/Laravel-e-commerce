<?php

namespace App\Rules;

use App\Models\Cart;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckUpdatingProductQuantity implements ValidationRule
{
    protected $cart;


    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = $this->cart->product;
        if (!$product) {
            $fail("Unexpected error: Unable to validate the selected product.");
        } elseif ($product && $product->quantity < 1) {
            $fail("The selected product is out of stock.");
        } elseif ($product && $product->quantity < $value) {
            $fail("The selected quantity exceeds the available quantity of {$product->quantity}.");
        }

    }

}
