<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
//    protected $table = 'invoice_details';
    protected $primaryKey = "invoice_detail_id";

    protected $fillable = [
      'invoice_detail_id',
//        'order_detail_id', // Eklenen sütun
        'invoice_id',
        'product_id',
        'quantity',
        'unit_price',
        'total',
    ];
//    public function product()
//    {
//        return $this->belongsTo(Product::class, 'product_id', 'product_id');
//    }
//    public function details()
//    {
//        return $this->belongsTo(OrderDetail::class, 'order_detail_id', 'order_details_id');
//    }

//    public function invoice()
//    {
//        return $this->belongsTo(Invoice::class, 'invoice_id', 'invoice_id');
//    }

//    public function invoice()
//    {
//        return $this->belongsTo(Invoice::class);
//    }
}
