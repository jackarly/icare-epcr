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
            // Get all assigned medic today
            $medics_active = DB::table('personnels')
                ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
                ->whereDate('response_personnels.created_at', Carbon::today())
                ->pluck('personnels.id');
            
            // Get all assigned ambulance today
            $ambulance_active = DB::table('user_ambulances')
                ->join('response_teams', 'user_ambulances.id', '=', 'response_teams.user_ambulance_id')
                ->whereDate('response_teams.created_at', Carbon::today())
                ->pluck('user_ambulances.id');
            
            // Get all registered but unassigned ambulances and medics
            $ambulances = UserAmbulance::whereNotIn('id', $ambulance_active)->get();
            $medics = Personnel::whereNotIn('id', $medics_active)->where('personnel_type', '=', 'medic')->get();
            $drivers = Personnel::whereNotIn('id', $medics_active)->where('personnel_type', '=', 'driver')->get();
    
            return view('response-team.create', [
                'ambulances' => $ambulances,
                'medics' => $medics,
                'drivers' => $drivers,
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
            
            $this->validate($request, [
                'ambulance'=> 'required',
                'driver'=> 'required',
                'medic1'=> 'required',
                'medic2'=> 'nullable',
                'medic3'=> 'nullable',
            ]);

            // Check if medic is selected twice
            if ($request->medic1 === $request->medic2){
                return back()->with('error', 'Select medic only once');
            }
            if ($request->medic1 === $request->medic3){
                return back()->with('error', 'Select medic only once');
            }
            if ($request->medic2 === $request->medic3){
                if ($request->medic2 != 0){
                    return back()->with('error', 'Select medic only once');
                }
            }
            
            // Create Response Team
            $response= ResponseTeam::create([
                'user_ambulance_id'=> $request->ambulance,
            ]);
            $response->response_personnels()->create([
                'personnel_id'=> $request->driver,
            ]);
            $response->response_personnels()->create([
                'personnel_id'=> $request->medic1,
            ]);

            if ($request->medic2 != 0){
                $response->response_personnels()->create([
                    'personnel_id'=> $request->medic2,
                ]);
            }
            if ($request->medic3 != 0){
                $response->response_personnels()->create([
                    'personnel_id'=> $request->medic3,
                ]);
            }
            return redirect()->route('response')->with('success', 'New response team added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function show(ResponseTeam $responseTeam)
    {   
        // Only allow comcen and admin to view response teams
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            // Get response team details
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
    
            // Remove current medics assigned
            $oldMedics = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->pluck('personnel_id')->toArray();
            if(($key = array_search($oldMedics[0], $medics_active)) !== false) {
                unset($medics_active[$key]);
            }
            if(($key = array_search($oldMedics[1], $medics_active)) !== false) {
                unset($medics_active[$key]);
            }
            if(isset($oldMedics[2])){
                if(($key = array_search($oldMedics[2], $medics_active)) !== false) {
                    unset($medics_active[$key]);
                }
            }
            if(isset($oldMedics[3])){
                if(($key = array_search($oldMedics[3], $medics_active)) !== false) {
                    unset($medics_active[$key]);
                }
            }
    
            // Get active ambulance except current ambulance
            $ambulance_active = DB::table('user_ambulances')
                ->join('response_teams', 'user_ambulances.id', '=', 'response_teams.user_ambulance_id')
                ->whereNot('response_teams.user_ambulance_id', '=' , $responseTeam->user_ambulance_id)
                ->whereDate('response_teams.created_at', Carbon::today())
                ->pluck('user_ambulances.id');
    
            // Assign medics and ambulance for input:option
            $ambulances = UserAmbulance::whereNotIn('id', $ambulance_active)->get();
            $medics = Personnel::whereNotIn('id', $medics_active)->where('personnel_type', '=', 'medic')->get();
            $drivers = Personnel::whereNotIn('id', $medics_active)->where('personnel_type', '=', 'driver')->get();
    
            return view('response-team.edit', [
                'ambulances' => $ambulances,
                'medics' => $medics,
                'drivers' => $drivers,
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
                'driver'=> 'required',
                'medic1'=> 'required',
                'medic2'=> 'nullable',
                'medic3'=> 'nullable',
            ]);

            // Check if medic is selected twice
            if ($request->medic1 === $request->medic2){
                return back()->with('error', 'Select medic only once');
            }
            if ($request->medic1 === $request->medic3){
                return back()->with('error', 'Select medic only once');
            }
            if ($request->medic2 === $request->medic3){
                if ($request->medic2 != 0){
                    return back()->with('error', 'Select medic only once');
                }
            }

            // Update Response Team
            $responseTeam->user_ambulance_id = $request->ambulance;
            $responseTeam->save();

            $oldMedics = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->orderBy('id', 'asc')->pluck('personnel_id');

            // Update Driver
            $driver = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[0])->first();
            $driver->personnel_id = $request->driver;
            $driver->save();

            // Update Medic1
            $newMedic1 = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[1])->first();
            $newMedic1->personnel_id = $request->medic1;
            $newMedic1->save();
            
            // Update Medic2
            if(isset($oldMedics[2])){
                if ($request->medic2 == 0){
                    $newMedic2 = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[2])->delete();
                }else{
                    $newMedic2 = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[2])->first();
                    $newMedic2->personnel_id = $request->medic2;
                    $newMedic2->save();
                }
            }
            else{
                if ($request->medic2 != 0){
                    $responseTeam->response_personnels()->create([
                        'personnel_id'=> $request->medic2,
                    ]);
                }
            }

            // Update Medic3
            if(isset($oldMedics[3])){
                if ($request->medic3 == 0){
                    $newMedic3 = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[3])->delete();
                }else{
                    $newMedic3 = ResponsePersonnel::where('response_team_id', '=', $responseTeam->id)->where('personnel_id', '=', $oldMedics[3])->first();
                    $newMedic3->personnel_id = $request->medic3;
                    $newMedic3->save();
                }
            }
            else{
                if ($request->medic3 != 0){
                    $responseTeam->response_personnels()->create([
                        'personnel_id'=> $request->medic3,
                    ]);
                }
            }

            return redirect()->route('response')->with('success', 'Response team updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

}
