<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Incident;
use App\Models\PatientAssessment;
use App\Models\PatientManagement;
use App\Models\PatientObservation;

class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ppcr_color',
        'patient_first_name',
        'patient_mid_name',
        'patient_last_name',
        'age',
        'birthday',
        'sex',
        'contact_no',
        'address',
        'incident_id',
    ];

    public function patient_assessment()
    {
        return $this->hasOne(PatientAssessment::class);
    }

    public function patient_management()
    {
        return $this->hasOne(PatientManagement::class);
    }

    public function patient_observation()
    {
        return $this->hasOne(PatientObservation::class);
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }
}
