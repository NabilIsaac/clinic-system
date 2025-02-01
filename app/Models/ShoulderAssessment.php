<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ShoulderAssessment extends Model
{
    protected $fillable = [
        'condition_type',
        'movements',
        'pain_characteristics'
    ];

    protected $casts = [
        'movements' => 'array'
    ];

    public function assessable(): MorphTo
    {
        return $this->morphTo();
    }
}
