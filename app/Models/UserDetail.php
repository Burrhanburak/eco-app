<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'user_id' => 'integer',
    ];

    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'm_phone',
        'city',
        'country',
        'zipcode',
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }


}
