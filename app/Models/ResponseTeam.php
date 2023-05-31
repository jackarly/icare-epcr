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

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function response_personnels()
    {
        return $this->hasMany(ResponsePersonnel::class);
    }

    public function user_ambulance()
    {
        return $this->belongsTo(UserAmbulance::class);
    }

    // public function incidentsToday()
    // {
    //     return $this->incidents()->whereDate('created_at', Carbon::today())->count();
    // }

    public function getIncidentsTodayAttribute() 
    {
        return $this->incidents()->whereDate('created_at', Carbon::today())->count();
    }

    public function getIncidentsTotalAttribute() 
    {
        return $this->incidents()->count();
    }

    public function getIncidentsCompletedTodayAttribute() 
    {   
        // $response = $this;

        return $incident_count =  DB::table('response_teams')
        ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
        ->join('patients', 'incidents.id', '=', 'patients.incident_id')
        ->where('response_teams.id', '=', $this->id)
        ->whereDate('patients.completed_at', Carbon::today())
        ->count();
    }
}
