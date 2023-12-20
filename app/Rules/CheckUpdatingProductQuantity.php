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
        validateProductQuantity($product, $value, $fail);

    }

}
