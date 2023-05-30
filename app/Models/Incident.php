<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\ResponseTeam;
use Carbon\Carbon;

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

    public static function getActiveToday() 
    {
        // $incidentCount = Incident::whereNull('reponse_team_id')->whereDate('created_at', Carbon::today())->count();
        // return $incidentCount;

        return Incident::whereNull('response_team_id')->whereDate('created_at', Carbon::today())->count();
    }

    public static function getOngoingToday() 
    {
        return Incident::whereNotNull('response_team_id')->whereDate('created_at', Carbon::today())->count();
    }

    public static function getDeployedToday() 
    {
        return Incident::whereNotNull('response_team_id')->whereDate('created_at', Carbon::today())->distinct()->count('response_team_id');
    }

    public static function getAvailableToday() 
    {
        $teamsDeployed = Incident::whereNotNull('response_team_id')->whereDate('created_at', Carbon::today())->pluck('response_team_id');

        return ResponseTeam::whereNotIn('id', $teamsDeployed)->whereDate('created_at', Carbon::today())->count();
    }
}
