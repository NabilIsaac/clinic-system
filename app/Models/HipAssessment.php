<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class HipAssessment extends Model
{
    protected $fillable = [
        'condition_type',
        'rom',
        'weight_bearing'
    ];

    public function assessable(): MorphTo
    {
        return $this->morphTo();
    }
}
