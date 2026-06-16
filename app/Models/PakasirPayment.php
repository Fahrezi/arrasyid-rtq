<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PakasirPayment extends Model
{
    protected $fillable = [
        'order_id',
        'donation_id',
        'amount',
        'project',
        'status',
        'payment_method',
        'payment_url',
        'qr_string',
        'va_number',
        'webhook_payload',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'webhook_payload' => 'array',
        'completed_at' => 'datetime',
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
