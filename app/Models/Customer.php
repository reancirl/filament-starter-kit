<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $guarded = [];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }
}