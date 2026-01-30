<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock_quantity',
        'sku',
        'image',
        'images',
        'featured',
        'best_selling',
        'popular',
        'latest',
        'category_id',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'best_selling' => 'boolean',
        'popular' => 'boolean',
        'latest' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    // Automatically generate slug from name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Calculate discounted price
    public function getDiscountedPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    // Check if product is on sale
    public function getIsOnSaleAttribute()
    {
        return $this->discount_price && $this->discount_price < $this->price;
    }

    // Get discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->is_on_sale) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }
}
