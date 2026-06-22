<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuitkuPayment extends Model
{
    protected $fillable = [
        'merchant_order_id',
        'donation_id',
        'amount',
        'reference',
        'status',
        'payment_method',
        'payment_url',
        'va_number',
        'qr_string',
        'callback_payload',
        'completed_at',
    ];

    protected $casts = [
        'amount'           => 'decimal:2',
        'callback_payload' => 'array',
        'completed_at'     => 'datetime',
    ];

    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    public static function generateOrderId(): string
    {
        return 'RTQ-' . strtoupper(uniqid());
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
