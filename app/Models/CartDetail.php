<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
    protected $table = 'cart_details';
    protected $primaryKey = 'cart_detail_id'; // Add this line
    protected $fillable = [
        'cart_detail_id',
        'cart_id',
        'product_id',
        'quantity',
    ];


    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }



    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Add this method to define the relationship with OrderDetail
    public function details()
    {
        return $this->hasOne(OrderDetail::class, 'cart_detail_id', 'cart_detail_id');
    }
}
