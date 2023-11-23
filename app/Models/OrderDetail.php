<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $primaryKey = "order_details_id";

    protected $fillable = [
        'order_details_id',
        'order_id',
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
//    public function invoiceDetail()
//    {
//        return $this->hasOne(InvoiceDetail::class, 'order_detail_id', 'order_details_id');
//    }
//     public function details()
//     {
//         return $this->hasOne(InvoiceDetail::class, 'order_detail_id', 'order_detail_id');
//     }
}
