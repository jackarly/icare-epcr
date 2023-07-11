<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResponseTeam;
use Carbon\Carbon;
use App\Models\Incident;
use App\Models\Hotline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Set default null value for response team
        $responses = null;

        // Check user type
        if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'ambulance') ){
            if (Auth::user()->user_type == 'hospital'){
                $assignedIncidents = DB::table('incidents')
                ->join('patients', 'incidents.id', '=', 'patients.incident_id')
                ->join('patient_managements', 'patients.id', '=', 'patient_managements.patient_id')
                ->where('patient_managements.user_hospital_id', '=', Auth::user()->user_hospital->id)
                ->pluck('incidents.id');
            }

            // Get all assigned incidents for ambulance
            elseif(Auth::user()->user_type == 'ambulance'){
                $assignedIncidents = DB::table('incidents')
                ->join('response_teams', 'incidents.response_team_id', '=', 'response_teams.id')
                ->where('response_teams.user_ambulance_id', '=', Auth::user()->user_ambulance->id)
                ->pluck('incidents.id');
            }
            else{
                return view('errors.404');
            }
            // Show assigned incidents
            $incidents = DB::table('incidents')
                ->leftJoin('patients', 'incidents.id', '=', 'patients.incident_id')
                ->whereIn('incidents.id', $assignedIncidents)
                ->whereNot('incidents.response_team_id', null)
                ->whereNull('patients.completed_at')
                ->whereNull('patients.patient_refused_at')
                ->whereNull('patients.hospital_refused_at')
                ->whereDate('incidents.created_at', Carbon::today())
                ->latest('incidents.created_at')
                ->select('incidents.*')
                ->paginate(12);
        }
        else {
            // Get response team
            // $responses = ResponseTeam::whereDate('created_at', Carbon::today())->latest()->with(['incidents', 'user_ambulance'])->paginate(12);
            $responses = DB::table('response_teams')
                ->join('user_ambulances', 'response_teams.user_ambulance_id', '=', 'user_ambulances.id')
                ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
                ->leftJoin('patients', 'incidents.id', '=', 'patients.incident_id')
                ->whereDate('incidents.created_at', Carbon::today())
                ->whereNull('patients.completed_at')
                ->whereNull('patients.patient_refused_at')
                ->whereNull('patients.hospital_refused_at')
                ->distinct('response_teams.id')
                ->select('response_teams.*', 'user_ambulances.plate_no')
                ->paginate(12);

            $incidents = DB::table('incidents')
                ->leftJoin('patients', 'incidents.id', '=', 'patients.incident_id')
                ->whereNot('incidents.response_team_id', null)
                ->whereNull('patients.completed_at')
                ->whereNull('patients.patient_refused_at')
                ->whereNull('patients.hospital_refused_at')
                ->whereDate('incidents.created_at', Carbon::today())
                ->latest('incidents.created_at')
                ->select('incidents.*')
                ->paginate(12);
        }
        return view('home', [
            'responses' => $responses,
            'incidents' => $incidents,
        ]);
        
    }
}
