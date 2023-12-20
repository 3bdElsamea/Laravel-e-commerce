<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

//    return the products of the order via the order items
    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItems::class, 'order_id', 'id', 'id', 'product_id');
    }

}
