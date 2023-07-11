<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\ResponseTeam;
use App\Models\UserAmbulance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    
    // Set incident and patients relationship
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    
    // Set response team and patients relationship
    public function response_team()
    {
        return $this->belongsTo(ResponseTeam::class);
    }

    // Count assigned incidents today
    public static function getActiveToday() 
    {
        return Incident::whereNull('response_team_id')->whereDate('created_at', Carbon::today())->count();
    }

    // Count assigned but incomplete incidents today
    public static function getOngoingToday() 
    {
        return $incidents =  DB::table('incidents')
            ->leftJoin('patients', 'incidents.id', '=', 'patients.incident_id')
            ->whereNotNull('incidents.response_team_id')
            ->whereNull('patients.completed_at')
            ->whereDate('incidents.created_at', Carbon::today())
            ->count();
    }

    // Count reponse teams that are deployed today
    public static function getDeployedToday() 
    {
        // return Incident::whereNotNull('response_team_id')->whereDate('created_at', Carbon::today())->distinct()->count('response_team_id');
        
        // $responses = DB::table('response_teams')
        //         ->join('user_ambulances', 'response_teams.user_ambulance_id', '=', 'user_ambulances.id')
        //         ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
        //         ->leftJoin('patients', 'incidents.id', '=', 'patients.incident_id')
        //         ->whereDate('incidents.created_at', Carbon::today())
        //         ->whereNull('patients.completed_at')
        //         ->whereNull('patients.patient_refused_at')
        //         ->whereNull('patients.hospital_refused_at')
        //         ->distinct('incidents.response_team_id')
        //         ->count('incidents.response_team_id');

        
        return DB::table('incidents')
            ->leftJoin('patients', 'incidents.id', '=', 'patients.incident_id')
            ->whereDate('incidents.created_at', Carbon::today())
            ->whereNull('patients.completed_at')
            ->whereNull('patients.patient_refused_at')
            ->whereNull('patients.hospital_refused_at')
            ->distinct('incidents.response_team_id')
            ->count('incidents.response_team_id');
    }

    // Count available response team today
    public static function getAvailableToday() 
    {
        // $teamsDeployed = Incident::whereNotNull('response_team_id')->whereDate('created_at', Carbon::today())-
        $teamsDeployed = DB::table('incidents')
            ->leftJoin('patients', 'incidents.id', '=', 'patients.incident_id')
            ->whereDate('incidents.created_at', Carbon::today())
            ->whereNotNull('incidents.response_team_id')
            ->whereNull('patients.completed_at')
            ->whereNull('patients.patient_refused_at')
            ->whereNull('patients.hospital_refused_at')
            ->distinct('incidents.response_team_id')
            ->pluck('response_team_id');

        return ResponseTeam::whereNotIn('id', $teamsDeployed)->whereDate('created_at', Carbon::today())->count();
    }
}
