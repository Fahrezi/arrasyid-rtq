<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'type', 'status', 'notes'];

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }
}
