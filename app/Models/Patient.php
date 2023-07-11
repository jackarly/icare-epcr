<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Incident;
use App\Models\PatientAssessment;
use App\Models\PatientManagement;
use App\Models\PatientObservation;
use Carbon\Carbon;
use App\Models\PatientRefusal;

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
        'completed_at',
        'incident_id',
        'patient_refusal_witness',
        'patient_refused_at',
        'hospital_refused_at',
    ];

    // protected $dates = [
    //     'created_at',
    //     'updated_at',
    //     'completed_at',
    //     'patient_refused_at',
    //     'hospital_refused_at',
    // ];

    // Set patient and patient assessment relationship
    public function patient_assessment()
    {
        return $this->hasOne(PatientAssessment::class);
    }

    // Set patient and patient management relationship
    public function patient_management()
    {
        return $this->hasOne(PatientManagement::class);
    }

    // Set patient and patient observation relationship
    public function patient_observation()
    {
        return $this->hasOne(PatientObservation::class);
    }

    // Set patient and incident relationship
    public function incident()
    {
        return $this->belongsTo(Incident::class);
    }

    // Count all patients that are cleared by provider today
    public static function getCompletedToday() 
    {
        return Patient::whereDate('completed_at', Carbon::today())->count();
    }

    // Count overall patients that are cleared by provider
    public static function getCompletedPatients() 
    {
        return Patient::whereNotNull('completed_at')->count();
    }

    // Set patient and patient refusal relationship
    public function patient_refusals()
    {
        return $this->hasMany(PatientRefusal::class);
    }
}
