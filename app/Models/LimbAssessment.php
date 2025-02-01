<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LimbAssessment extends Model
{
    public function joints(): HasMany
    {
        return $this->hasMany(JointAssessment::class);
    }
}
