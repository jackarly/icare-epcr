<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Patient;
use App\Models\ResponseTeam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($status = null)
    {
        switch($status) {
            case('unassigned today'):
                $incidents = Incident::where('response_team_id', null)->whereDate('created_at', Carbon::today())->latest()->paginate(12);
                break;

            case('assigned today'):
                $incidents = Incident::whereNot('response_team_id', null)->whereDate('created_at', Carbon::today())->latest()->paginate(12);
                break;

            case('all incidents'):
                $incidents = Incident::latest()->paginate(12);
                break;

            default:
                $incidents = Incident::whereDate('created_at', Carbon::today())->latest()->paginate(12);
                $status = 'incidents today';
        }

        return view('incident.index', [
            'incidents' => $incidents,
            'status' => $status,
        ]);
    }

    public function create()
    {
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            return view('incident.create');
        }
        else{
            return view('errors.404');
        }
    }

    
    public function store(Request $request)
    {
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            $this->validate($request, [
                'nature_of_call'=> 'required|string',
                'incident_type'=> 'required|string',
                'incident_location'=> 'required|string',
                'area_type'=> 'required|string',
                'caller_first_name'=> 'required|string',
                'caller_mid_name'=> 'nullable|string',
                'caller_last_name'=> 'required|string',
                'caller_number'=> 'required|numeric',
                'no_of_persons_involved'=> 'required|numeric',
                'incident_details'=> 'required|string',
                'injuries_details'=> 'required|string',
            ]);
    
            Incident::create([
                'nature_of_call'=> $request->nature_of_call,
                'incident_type'=> $request->incident_type,
                'incident_location'=> $request->incident_location,
                'area_type'=> $request->area_type,
                'caller_first_name'=> $request->caller_first_name,
                'caller_mid_name'=> $request->caller_mid_name,
                'caller_last_name'=> $request->caller_last_name,
                'caller_number'=> $request->caller_number,
                'no_of_persons_involved'=> $request->no_of_persons_involved,
                'incident_details'=> $request->incident_details,
                'injuries_details'=> $request->injuries_details,
            ]);
            return redirect()->route('incident')->with('success', 'New incident added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    
    public function show(Incident $incident)
    {
        $responses = ResponseTeam::whereDate('created_at', Carbon::today())->get();
        $patients = $incident->patients()->get();
        $medics= null;

        if  ($incident->response_team_id){
            $medics = DB::table('personnels')
                ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
                ->join('response_teams', 'response_teams.id', '=', 'response_personnels.response_team_id')
                ->where('response_teams.id','=',$incident->response_team_id)
                ->get();
        }
        return view('incident.show', [
            'incident' => $incident,
            'patients' => $patients,
            'responses' => $responses,
            'medics' => $medics,
        ]);
    }

    
    public function edit(Incident $incident)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('incident.edit', [
                'incident' => $incident,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, Incident $incident)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'nature_of_call'=> 'required|string',
                'incident_type'=> 'required|string',
                'incident_location'=> 'required|string',
                'area_type'=> 'required|string',
                'caller_first_name'=> 'required|string',
                'caller_mid_name'=> 'nullable|string',
                'caller_last_name'=> 'required|string',
                'caller_number'=> 'required|numeric',
                'no_of_persons_involved'=> 'required|numeric',
                'incident_details'=> 'required|string',
                'injuries_details'=> 'required|string',
            ]);
    
            $incident->update([
                'nature_of_call'=> $request->nature_of_call,
                'incident_type'=> $request->incident_type,
                'incident_location'=> $request->incident_location,
                'area_type'=> $request->area_type,
                'caller_first_name'=> $request->caller_first_name,
                'caller_mid_name'=> $request->caller_mid_name,
                'caller_last_name'=> $request->caller_last_name,
                'caller_number'=> $request->caller_number,
                'no_of_persons_involved'=> $request->no_of_persons_involved,
                'incident_details'=> $request->incident_details,
                'injuries_details'=> $request->injuries_details,
            ]);
            return redirect()->route('incident.show', $incident->id)->with('success', 'Incident updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function assign(Request $request,Incident $incident)
    {
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'response_team'=> 'required',
            ]);
    
            $incident->response_team_id = $request->response_team;
            $incident->save();
            return redirect()->route('incident.show', $incident->id )->with('success', 'Response team added successfully');
        }
        else{
            return view('errors.404');
        }
        
    }
    
    public function updateTimings(Request $request, Patient $patient)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'timing_dispatch'=> 'nullable|string',
                'timing_enroute'=> 'nullable|string',
                'timing_arrival'=> 'nullable|string',
                'timing_depart'=> 'nullable|string',
            ]);
    
            $incident = Incident::find($patient->incident_id);
            $incident->timing_dispatch = $request->timing_dispatch;
            $incident->timing_enroute = $request->timing_enroute;
            $incident->timing_arrival = $request->timing_arrival;
            $incident->timing_depart = $request->timing_depart;
            $incident->save();
    
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient incident updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

}
