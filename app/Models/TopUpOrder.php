<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUpOrder extends Model
{
    use HasFactory;

    protected $table = 'topup_orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'topup_id',
        'game_id',
        'game_server',
        'game_nickname',
        'total_price',
        'status',
        'payment_proof',
        'admin_notes',
        'completed_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /**
     * Boot function for model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_number = 'TU-' . date('Ymd') . '-' . strtoupper(uniqid());
        });
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the top-up package.
     */
    public function topup()
    {
        return $this->belongsTo(TopUp::class, 'topup_id');
    }

    /**
     * Get formatted total price.
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format((float) $this->total_price, 0, ',', '.');
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary',
        };
    }
}
