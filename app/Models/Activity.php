<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $table = 'activites';

    protected $fillable = ['program_id', 'name', 'description', 'activity_date', 'proof_of_activity'];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
