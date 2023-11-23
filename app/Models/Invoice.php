<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
    use HasFactory, SoftDeletes;
//    protected $primaryKey = "invoice_id";

    protected $fillable = [
        'order_id',
//        'invoice_id',
        'code',
    ];

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, "invoice_id", "id");
    }


}
