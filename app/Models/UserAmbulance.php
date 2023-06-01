<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResponseTeam;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserAmbulance extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_no',
        'user_id',  
    ];

    protected $appends = ['dashboardMedics'];
    
    public function response_team()
    {
        return $this->hasOne(ResponseTeam::class);
    }
    

    public static function dashboardMedics() 
    {   
        $ambulance = Auth::user()->user_ambulance;

        return $medics =  DB::table('response_personnels')
        ->join('personnels', 'response_personnels.personnel_id', '=', 'personnels.id')
        ->join('response_teams', 'response_personnels.response_team_id', '=', 'response_teams.id')
        ->join('user_ambulances', 'response_teams.user_ambulance_id', '=', 'user_ambulances.id')
        ->where('response_teams.user_ambulance_id', '=', $ambulance->id)
        ->whereDate('response_teams.created_at', Carbon::today())
        ->select('personnels.*')
        ->get();
    }

    public static function dashboardCompletedOverall() 
    {   
        $ambulance = Auth::user()->user_ambulance;
        return $incidents =  DB::table('response_teams')
        ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
        ->join('user_ambulances', 'response_teams.user_ambulance_id', '=', 'user_ambulances.id')
        ->join('patients', 'incidents.id', '=', 'patients.incident_id')
        ->where('user_ambulances.id', '=', $ambulance->id)
        ->whereNotNull('patients.completed_at')
        // ->whereDate('incidents.created_at', Carbon::today())
        ->count();
    }

    public static function dashboardCompletedToday() 
    {   
        $ambulance = Auth::user()->user_ambulance;
        return $incidents =  DB::table('response_teams')
        ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
        ->join('user_ambulances', 'response_teams.user_ambulance_id', '=', 'user_ambulances.id')
        ->join('patients', 'incidents.id', '=', 'patients.incident_id')
        ->where('user_ambulances.id', '=', $ambulance->id)
        // ->whereNotNull('patients.completed_at')
        ->whereDate('patients.completed_at', Carbon::today())
        ->count();
    }
    
    public static function dashboardNewToday() 
    {   
        $ambulance = Auth::user()->user_ambulance;
        return $incidents =  DB::table('response_teams')
        ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
        ->join('user_ambulances', 'response_teams.user_ambulance_id', '=', 'user_ambulances.id')
        ->join('patients', 'incidents.id', '=', 'patients.incident_id')
        ->where('user_ambulances.id', '=', $ambulance->id)
        ->whereDate('incidents.created_at', Carbon::today())
        ->whereNull('patients.completed_at')
        ->count();
    }
}
