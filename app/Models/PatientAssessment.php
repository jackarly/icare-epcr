<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'chief_complaint',
        'history',
        'primary1',
        'airway',
        'breathing',
        'pulse',
        'skin_appearance',
        'gcs_eye',
        'gcs_verbal',
        'gcs_motor',
        'gcs_total',
        'signs_symptoms',
        'allergies',
        'medications',
        'past_history',
        'last_intake',
        'event_prior',
        'vital_time1',
        'vital_time2',
        'vital_time3',
        'vital_bp1',
        'vital_bp2',
        'vital_bp3',
        'vital_hr1',
        'vital_hr2',
        'vital_hr3',
        'vital_rr1',
        'vital_rr2',
        'vital_rr3',
        'vital_o2sat1',
        'vital_o2sat2',
        'vital_o2sat3',
        'vital_glucose1',
        'vital_glucose2',
        'vital_glucose3',
    ];
}
