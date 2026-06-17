<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donation extends Model
{
    protected $fillable = [
        'donor_id', 'program_id', 'amount', 'donated_at',
        'proof_of_donation', 'notes', 'status', 'payment_method',
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'donated_at' => 'datetime',
    ];

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function pakasirPayment(): HasOne
    {
        return $this->hasOne(PakasirPayment::class);
    }
}
