<?php

namespace App\Rules;

use App\Models\Cart;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckAddProductQuantity implements ValidationRule
{
    protected $productId;


    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($this->productId);
        validateProductQuantity($product, $value, $fail);

    }

}
