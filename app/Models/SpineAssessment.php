<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SpineAssessment extends Model
{
    protected $fillable = [
        'history',
        'previous_treatment',
        'pain_scale',
        'pain_location'
    ];

    public function assessable(): MorphTo
    {
        return $this->morphTo();
    }
}
