<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = "cart_id";
    protected $fillable = [
        'user_id',
        'code',
        'cart_id',
        'is_active'
    ];

    public function details()
    {
        return $this->hasMany(CartDetail::class,'cart_id','cart_id');
    }
}
