<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'products';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name',
        'slug',
        "product_id",
        "category_id",
        'sku',
        'image',
        'is_visible',
        'is_featured',
        'description',
        'price',
        'quantity',
        'published_at',
        'type',
    ];

    // Correcting the many-to-many relationship with Category
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function details()
    {
        return $this->hasMany(CartDetail::class, 'product_id', 'id');
    }
    public function invoiceDetail()
    {
        return $this->hasMany(InvoiceDetail::class, 'product_id', 'product_id');
    }
}
