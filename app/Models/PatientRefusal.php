<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRefusal extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_reasons',
        'hospital_nurse_doctor',
        'user_hospital_id',
        'patient_id',
    ];
}
