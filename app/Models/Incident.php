<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\ResponseTeam;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'nature_of_call',
        'incident_type',
        'incident_location',
        'area_type',
        'caller_first_name',
        'caller_mid_name',
        'caller_last_name',
        'caller_number',
        'no_of_persons_involved',
        'incident_details',
        'injuries_details',
        'patient_id', 
        'response_team_id',
        'timing_dispatch',
        'timing_enroute',
        'timing_arrival',
        'timing_depart',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    
    public function response_team()
    {
        return $this->belongsTo(ResponseTeam::class);
    }
}
