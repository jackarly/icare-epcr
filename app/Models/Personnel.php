<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResponseTeam;
use App\Models\ResponsePersonnel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Personnel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'personnel_first_name',
        'personnel_mid_name',
        'personnel_last_name',
        'personnel_other',
        'contact',
        'birthday',
        'sex', 
        'personnel_img',
    ];

    protected $appends = ['medicStatus', 'incidentsToday', 'incidentsCompletedToday', 'incidentsCompletedOverall'];

    // Set personnel and response personnel relationship
    public function response_personnels()
    {
        return $this->belongsTo(ResponsePersonnel::class);
    }

    // Check if medic is assigned or unassigned today
    public function getMedicStatusAttribute()
    {
        $teamsAssignedToday =  DB::table('personnels')
            ->join('response_personnels', 'response_personnels.personnel_id', '=', 'personnels.id')
            ->where('personnels.id', '=', $this->id)
            ->whereDate('response_personnels.created_at', Carbon::today())
            ->get();

        if ($teamsAssignedToday->count() > 0){
            return true;
        }else{
            return false;
        }
    }

    // Count incidents assigned to medic today
    public function getIncidentsTodayAttribute() 
    {
        return $incident_count =  DB::table('incidents')
        ->join('response_teams', 'incidents.response_team_id', '=', 'response_teams.id')
        ->join('response_personnels', 'response_teams.id', '=', 'response_personnels.response_team_id')
        ->join('personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
        ->where('personnels.id', '=', $this->id)
        ->whereDate('incidents.created_at', Carbon::today())
        ->count();
    }

    // Count incidents completed by medic today
    public function getIncidentsCompletedTodayAttribute() 
    {   
        return $incident_count =  DB::table('patients')
        ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
        ->join('response_teams', 'incidents.response_team_id', '=', 'response_teams.id')
        ->join('response_personnels', 'response_teams.id', '=', 'response_personnels.response_team_id')
        ->join('personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
        ->where('personnels.id', '=', $this->id)
        ->whereDate('patients.completed_at', Carbon::today())
        ->count();
    }

    // Count overall incidents completed by medic
    public function getIncidentsCompletedOverallAttribute() 
    {   
        return $incident_count =  DB::table('patients')
        ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
        ->join('response_teams', 'incidents.response_team_id', '=', 'response_teams.id')
        ->join('response_personnels', 'response_teams.id', '=', 'response_personnels.response_team_id')
        ->join('personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
        ->where('personnels.id', '=', $this->id)
        ->count();
    }
}
