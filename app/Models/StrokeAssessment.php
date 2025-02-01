<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StrokeAssessment extends Model
{
    protected $fillable = [
        'type',
        'time_since',
        'affected_side',
        'mobility_status'
    ];

    public function assessable(): MorphTo
    {
        return $this->morphTo();
    }
}
