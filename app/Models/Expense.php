<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = ['program_id', 'name', 'amount', 'description', 'expense_date', 'proof_of_expense', 'is_confirmed'];

    protected $casts = [
        'amount'        => 'decimal:2',
        'expense_date'  => 'date',
        'is_confirmed'  => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
