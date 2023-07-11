<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ResponsePersonnel;
use App\Models\UserAmbulance;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResponseTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_ambulance_id',    
        'status', 
    ];

    protected $appends = ['incidentsToday', 'incidentsTotal', 'incidentsCompletedToday'];

    // Set response team and incident relationship
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    // Set response team and response personnel relationship
    public function response_personnels()
    {
        return $this->hasMany(ResponsePersonnel::class);
    }

    // Set response team and ambulance relationship
    public function user_ambulance()
    {
        return $this->belongsTo(UserAmbulance::class);
    }

    // Count all incidents today
    public function getIncidentsTodayAttribute() 
    {
        return $this->incidents()->whereDate('created_at', Carbon::today())->count();
    }

    // Count all incidents
    public function getIncidentsTotalAttribute() 
    {
        return $this->incidents()->count();
    }

    // Count incidents assigned to response team today
    public function getIncidentsCompletedTodayAttribute() 
    {   
        return $incident_count =  DB::table('response_teams')
        ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
        ->join('patients', 'incidents.id', '=', 'patients.incident_id')
        ->where('response_teams.id', '=', $this->id)
        ->whereDate('patients.completed_at', Carbon::today())
        ->count();
    }

    public static function getPersonnelList($id) 
    {   
        return $personnelList =  DB::table('response_personnels')
        ->join('response_teams', 'response_personnels.response_team_id', '=', 'response_teams.id')
        ->join('personnels', 'response_personnels.personnel_id', '=', 'personnels.id')
        ->where('response_teams.id', '=', $id)
        ->whereDate('response_teams.created_at', Carbon::today())
        ->orderBy('response_personnels.id', 'asc')
        ->get();
    }
}
