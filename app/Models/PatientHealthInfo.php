<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PatientHealthInfo extends Model
{
    protected $fillable = [
        'patient_id',
        'disease_type',
        'hpt_dm',
        'pc',
        'pain_scale',
        'pain_location'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function assessment(): MorphOne
    {
        return $this->morphOne($this->getAssessmentClass(), 'assessable');
    }

    private function getAssessmentClass()
    {
        return match($this->disease_type) {
            'spine' => SpineAssessment::class,
            'stroke' => StrokeAssessment::class,
            'hip' => HipAssessment::class,
            'shoulder' => ShoulderAssessment::class,
            default => null
        };
    }
}
