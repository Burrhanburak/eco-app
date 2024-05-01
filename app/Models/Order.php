<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = "order_id";

    protected $fillable = [
        'order_id',
        'total_price',
        'shipping_price',
        'cart_id',
        'code',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, "order_id", "order_id");
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'order_id', 'order_id');
    }


}
