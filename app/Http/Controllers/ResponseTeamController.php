<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResponseTeam;
use App\Models\UserAmbulance;
use App\Models\Personnel;
use App\Models\ResponsePersonnel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ResponseTeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // Only show response teams to comcen and admin accounts
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $responses = ResponseTeam::whereDate('created_at', Carbon::today())->latest()->with(['incidents', 'user_ambulance'])->paginate(12);
            
            return view('response-team.index', [
                'responses' => $responses,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function create()
    {
        // Only allow comcen and admin to create response teams
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $medics_active = DB::table('personnels')
                ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
                ->whereDate('response_personnels.created_at', Carbon::today())
                ->pluck('personnels.id');
    
            $ambulance_active = DB::table('user_ambulances')
                ->join('response_teams', 'user_ambulances.id', '=', 'response_teams.user_ambulance_id')
                ->whereDate('response_teams.created_at', Carbon::today())
                ->pluck('user_ambulances.id');
    
            $ambulances = UserAmbulance::whereNotIn('id', $ambulance_active)->get();
            $medics = Personnel::whereNotIn('id', $medics_active)->get();
    
            return view('response-team.create', [
                'ambulances' => $ambulances,
                'medics' => $medics,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function store(Request $request)
    {
        // Only allow comcen and admin to save response teams
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            if ($request->medic1 === $request->medic2){
                return back()->with('error', 'Select medic only once');
            }
            else{
                
                $response= ResponseTeam::create([
                    'user_ambulance_id'=> $request->ambulance,
                ]);
                
                $response->response_personnels()->create([
                    'personnel_id'=> $request->medic1,
                ]);
                
                $response->response_personnels()->create([
                    'personnel_id'=> $request->medic2,
                ]);
            }
            return redirect()->route('response')->with('success', 'New response team added successfully');
        }
        else{
            return view('errors.404');
        }
        $this->validate($request, [
            'ambulance'=> 'required',
            'medic1'=> 'required',
            'medic2'=> 'required'
        ]);
    }

    public function show(ResponseTeam $responseTeam)
    {   
        // Only allow comcen and admin to view response teams
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $medics = DB::table('personnels')
                ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
                ->join('response_teams', 'response_teams.id', '=', 'response_personnels.response_team_id')
                ->where('response_teams.id','=',$responseTeam->id)
                ->get();
            
            return view('response-team.show', [
                'response' => $responseTeam,
                'medics' => $medics,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function edit(ResponseTeam $responseTeam)
    {
        // Only allow comcen and admin to edit response teams
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            // Get all active medics
            $medics_active = DB::table('personnels')
                ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
                ->whereDate('response_personnels.created_at', Carbon::today())
                ->pluck('personnels.id')->toArray();
    
            // Remove current medics
            $oldMedics = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->pluck('personnel_id')->toArray();
    
            if(($key = array_search($oldMedics[0], $medics_active)) !== false) {
                unset($medics_active[$key]);
            }
    
            if(($key = array_search($oldMedics[1], $medics_active)) !== false) {
                unset($medics_active[$key]);
            }
    
            // Get active ambulance except current ambulance
            $ambulance_active = DB::table('user_ambulances')
                ->join('response_teams', 'user_ambulances.id', '=', 'response_teams.user_ambulance_id')
                ->whereNot('response_teams.user_ambulance_id', '=' , $responseTeam->user_ambulance_id)
                ->whereDate('response_teams.created_at', Carbon::today())
                ->pluck('user_ambulances.id');
    
            // Assign medics and ambulance for input:option
            $ambulances = UserAmbulance::whereNotIn('id', $ambulance_active)->get();
            $medics = Personnel::whereNotIn('id', $medics_active)->get();
    
            return view('response-team.edit', [
                'ambulances' => $ambulances,
                'medics' => $medics,
                'response' => $responseTeam,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, ResponseTeam $responseTeam)
    {
        // Only allow comcen and admin to update response teams
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'ambulance'=> 'required',
                'medic1'=> 'required',
                'medic2'=> 'required'
            ]);
    
            if ($request->medic1 === $request->medic2){
                return back()->with('error', 'Select medic only once');
            }
            else{
                $responseTeam->user_ambulance_id = $request->ambulance;
                $responseTeam->save();
    
                $oldMedics = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->pluck('personnel_id');
                $newMedic1 = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[0])->first();
                $newMedic1->personnel_id = $request->medic1;
                $newMedic1->save();
                
                $newMedic2 = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[1])->first();
                $newMedic2->personnel_id = $request->medic2;
                $newMedic2->save();
            }
            return redirect()->route('response')->with('success', 'Response team updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

}
