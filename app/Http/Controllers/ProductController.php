<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        $data = [
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'products' => ProductResource::collection($products),
        ];
        return responseJson($data);
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return responseJson(new ProductResource($product));
    }


}
