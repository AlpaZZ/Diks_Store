<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    protected $table = 'topups';

    protected $fillable = [
        'category_id',
        'name',
        'currency_name',
        'currency_icon',
        'amount',
        'bonus_amount',
        'price',
        'original_price',
        'description',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the top-up.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the orders for this top-up.
     */
    public function orders()
    {
        return $this->hasMany(TopUpOrder::class, 'topup_id');
    }

    /**
     * Scope for active top-ups.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for popular top-ups.
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    /**
     * Get formatted original price.
     */
    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? 'Rp ' . number_format((float) $this->original_price, 0, ',', '.') : null;
    }

    /**
     * Get total amount (amount + bonus).
     */
    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->bonus_amount;
    }

    /**
     * Check if has discount.
     */
    public function getHasDiscountAttribute()
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Get discount percentage.
     */
    public function getDiscountPercentAttribute()
    {
        if (!$this->has_discount) return 0;
        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }
}
