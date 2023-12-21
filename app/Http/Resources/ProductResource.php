<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'image' => $this->image,
            'price' => $this->price,
        ];
    }
}
