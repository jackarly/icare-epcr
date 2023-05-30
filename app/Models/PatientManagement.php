<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserHospital;

class PatientManagement extends Model
{
    use HasFactory;

    protected $table = 'patient_managements';

    protected $fillable = [
        'airway_breathing',
        'circulation',
        'wound_burn_care',
        'immobilization',
        'others1',
        'others2',
        'receiving_facility',
        'narrative',
        'receiving_provider',
        'provider_position',
        'timings_arrival',
        'timings_handover',
        'timings_clear',
        'user_hospital_id',
        'patient_id',
    ];

    public function user_hospital()
    {
        return $this->belongsTo(UserHospital::class);
    }
}
