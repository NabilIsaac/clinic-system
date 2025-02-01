<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JointAssessment extends Model
{
    public function limbAssessment()
    {
        return $this->belongsTo(LimbAssessment::class);
    }
}
