<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'image',
        'gallery',
        'game_server',
        'game_level',
        'account_details',
        'status',
        'is_featured',
        'stock',
        'view_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'gallery' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Boot function for model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }

    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the orders for this product
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope for available products
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    /**
     * Get formatted original price
     */
    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? 'Rp ' . number_format((float) $this->original_price, 0, ',', '.') : null;
    }

    /**
     * Check if product has discount
     */
    public function hasDiscount()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    /**
     * Increment view count
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    /**
     * Check if product is in stock
     */
    public function inStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Decrease stock
     */
    public function decreaseStock(int $amount = 1): void
    {
        $this->decrement('stock', $amount);
        
        // Auto update status if out of stock
        if ($this->stock <= 0) {
            $this->update(['status' => 'sold']);
        }
    }

    /**
     * Scope for in stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
