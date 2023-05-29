<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'observations',
        'age_group',
        'wound',
        'burn',
        'burn_calculation',
        'dislocation',
        'fracture',
        'numbness',
        'rash',
        'swelling',
        'burn_classification',
        'patient_id',
    ];
}
