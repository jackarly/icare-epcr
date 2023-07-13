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

    public function index(Request $request, $status = null)
    {
        // Set search variables to null
        $searchKeyword = null;
        $searchDate = null;

        // Check if from search query
        if ($request->searchedQuery) {
            
            // Set search keywords & status
            $searchKeyword = $request->search_name;
            $status = $request->status;
            $searchDate = $request->search_date;

            // Only show hospital and ambulance their assigned incidents 
            if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'ambulance') ){
                // Get all assigned incidents for hospital
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

                // Show assigned incidents by status
                switch($status) {
                    case('unassigned today'):
                        $incidents = Incident::where('response_team_id', null)->whereIn('id', $assignedIncidents)->whereDate('created_at', Carbon::today())
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                        break;

                    case('assigned today'):
                        $incidents = Incident::whereNot('response_team_id', null)->whereIn('id', $assignedIncidents)->whereDate('created_at', Carbon::today())
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                        break;

                    case('all incidents'):
                        
                        // Set date and default if null
                        if ($request->search_date){
                            $tempDate = $request->search_date;
                        }
                        else{
                            $tempDate = Carbon::today();
                        }

                        $incidents = Incident::whereIn('id', $assignedIncidents)
                            ->whereDate('created_at', $tempDate)
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);

                            if (!$request->search_date){
                                $status = 'incidents today';
                            }
                        break;

                    default:
                        $incidents = Incident::whereIn('id', $assignedIncidents)->whereDate('created_at', Carbon::today())
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                        $status = 'incidents today';
                }
            }
            // Show all incident for comcen and admin accounts
            else{
                // Show assigned incidents by status
                switch($status) {
                    case('unassigned today'):
                        $incidents = Incident::where('response_team_id', null)->whereDate('created_at', Carbon::today())
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                        break;

                    case('assigned today'):
                        $incidents = Incident::whereNot('response_team_id', null)->whereDate('created_at', Carbon::today())
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                            break;

                    case('all incidents'):

                        // Set date and default if null
                        if ($request->search_date){
                            $tempDate = $request->search_date;
                        }
                        else{
                            $tempDate = Carbon::today();
                        }

                        $incidents = Incident::whereDate('created_at', $tempDate)
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);

                            if (!$request->search_date){
                                $status = 'incidents today';
                            }
                        break;

                    default:
                        $incidents = Incident::whereDate('created_at', Carbon::today())
                            ->where('caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                        $status = 'incidents today';
                }
            }
        }
        else{
            // Only show hospital and ambulance their assigned incidents 
            if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'ambulance') ){
                // Get all assigned incidents for hospital
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
                // Show assigned incidents by status
                switch($status) {
                    case('unassigned today'):
                        $incidents = Incident::where('response_team_id', null)->whereIn('id', $assignedIncidents)->whereDate('created_at', Carbon::today())->latest()->paginate(12);
                        break;

                    case('assigned today'):
                        $incidents = Incident::whereNot('response_team_id', null)->whereIn('id', $assignedIncidents)->whereDate('created_at', Carbon::today())->latest()->paginate(12);
                        break;

                    case('all incidents'):
                        $incidents = Incident::whereIn('id', $assignedIncidents)->latest()->paginate(12);
                        break;

                    default:
                        $incidents = Incident::whereIn('id', $assignedIncidents)->whereDate('created_at', Carbon::today())->latest()->paginate(12);
                        $status = 'incidents today';
                }
            }
            // Show all incident for comcen and admin accounts
            else{
                // Show assigned incidents by status
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
            }
        }
        

        return view('incident.index', [
            'incidents' => $incidents,
            'status' => $status,
            'searchKeyword' => $searchKeyword,
            'searchDate' => $searchDate,
        ]);
    }

    public function create()
    {
        // Only allow comcen and admin accounts to create incidents
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            return view('incident.create');
        }
        else{
            return view('errors.404');
        }
    }

    public function store(Request $request)
    {
        // Only allow comcen and admin accounts to save incidents
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

            // Set other incident
            if ($request->incident_details == 'others') {
                $incident_details = $request->other_incident_details;
            } else {
                $incident_details = $request->incident_details;
            }

            // Set other injuries
            if ($request->incident_details == 'others') {
                $injuries_details = $request->other_injuries_details;
            } else {
                $injuries_details = $request->injuries_details;
            }

            // Store incident to db
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
                'incident_details'=> $incident_details,
                'injuries_details'=> $injuries_details,
            ]);
            return redirect()->route('incident')->with('success', 'New incident added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function show(Incident $incident)
    {
        // Only show hospital and ambulance accounts their assigned incidents
        if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'ambulance') ){
            $grantAccess = false;
            // Get all assigned incidents for current hospital logged in
            if (Auth::user()->user_type == 'hospital'){
                $assignedIncidents = DB::table('incidents')
                ->join('patients', 'incidents.id', '=', 'patients.incident_id')
                ->join('patient_managements', 'patients.id', '=', 'patient_managements.patient_id')
                ->where('patient_managements.user_hospital_id', '=', Auth::user()->user_hospital->id)
                ->pluck('incidents.id');
                foreach ($assignedIncidents as $item) {
                    if($incident->id == $item){
                        $grantAccess = true;
                        break;
                    }
                }
            }
            // Get all assigned incidents for current ambulance logged in
            elseif(Auth::user()->user_type == 'ambulance'){
                $assignedIncidents = DB::table('incidents')
                ->join('response_teams', 'incidents.response_team_id', '=', 'response_teams.id')
                ->where('response_teams.user_ambulance_id', '=', Auth::user()->user_ambulance->id)
                ->pluck('incidents.id');
                foreach ($assignedIncidents as $item) {
                    if($incident->id == $item){
                        $grantAccess = true;
                        break;
                    }
                }
            }
            else{
                return view('errors.404');
            }

            // If selected incident is assigned, grant access, else redirect to error page
            if ($grantAccess){
                // Get incident details
                $responses = ResponseTeam::whereDate('created_at', Carbon::today())->get();
                $patients = $incident->patients()->get();
                $medics= null;
                
                // If reponse team is assigned, get medics info
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
            }else{
                return view('errors.404');
            }
            
        // Show all incident for comcen and admin accounts
        }else{
            // Get incident details
            $responses = ResponseTeam::whereDate('created_at', Carbon::today())->get();
            $patients = $incident->patients()->get();
            $medics= null;

            // If reponse team is assigned, get medics info
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

    }

    public function edit(Incident $incident)
    {
        // Allow accounts except hospital to edit incident
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            // Get all assigned incidents for ambualnce
            if (Auth::user()->user_type == 'ambulance'){
                $grantAccess = false;
                $assignedIncidents = DB::table('incidents')
                    ->join('response_teams', 'incidents.response_team_id', '=', 'response_teams.id')
                    ->where('response_teams.user_ambulance_id', '=', Auth::user()->user_ambulance->id)
                    ->pluck('incidents.id');

                foreach ($assignedIncidents as $item) {
                    if($incident->id == $item){
                        $grantAccess = true;
                        break;
                    }
                }
                
                // If selected incident is assigned, grant access, else redirect to error page
                if ($grantAccess){
                    return view('incident.edit', [
                        'incident' => $incident,
                    ]);
                }else{
                    return view('errors.404');
                }
            }else{
                return view('incident.edit', [
                    'incident' => $incident,
                ]);
            }
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, Incident $incident)
    {
        // Allow accounts except hospital to update incident
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

            // Set other incident
            if ($request->incident_details == 'others') {
                $incident_details = $request->other_incident_details;
            } else {
                $incident_details = $request->incident_details;
            }

            // Set other injuries
            if ($request->incident_details == 'others') {
                $injuries_details = $request->other_injuries_details;
            } else {
                $injuries_details = $request->injuries_details;
            }

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
                'incident_details'=> $incident_details,
                'injuries_details'=> $injuries_details,
            ]);
            return redirect()->route('incident.show', $incident->id)->with('success', 'Incident updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function assign(Request $request,Incident $incident)
    {
        // Allow only comcen and admin account to assign response team
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'response_team'=> 'required',
            ]);
            
            // Assign response team and set dispatch to current time
            $incident->response_team_id = $request->response_team;
            $incident->timing_dispatch = Carbon::now()->format('g:i A');
            $incident->save();
            return redirect()->route('incident.show', $incident->id )->with('success', 'Response team added successfully');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function enroute(Request $request,Patient $patient)
    {
        // Allow accounts except hospital to update timings
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set enroute to current time from pcr page
            $incident = Incident::find($patient->incident_id);
            $incident->update([
                $incident->timing_enroute = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Incident timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function arrival(Request $request,Patient $patient)
    {
        // Allow accounts except hospital to update timings
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set arrival to current time from pcr page
            $incident = Incident::find($patient->incident_id);
            $incident->update([
                $incident->timing_arrival = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Incident timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function depart(Request $request,Patient $patient)
    {
        // Allow accounts except hospital to update timings
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set depart to current time from pcr page
            $incident = Incident::find($patient->incident_id);
            $incident->update([
                $incident->timing_depart = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Incident timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function enrouteIncident(Request $request,Incident $incident)
    {
        // Allow accounts except hospital to update timings
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set enroute to current time from incident page
            $incident = Incident::find($incident->id);
            $incident->update([
                $incident->timing_enroute = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('incident.show', $incident->id)->with('success', 'Incident timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function arrivalIncident(Request $request,Incident $incident)
    {
        // Allow accounts except hospital to update timings
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set arrival to current time from incident page
            $incident = Incident::find($incident->id);
            $incident->update([
                $incident->timing_arrival = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('incident.show', $incident->id)->with('success', 'Incident timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function departIncident(Request $request,Incident $incident)
    {
        // Allow accounts except hospital to update timings
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set depart to current time from incident page
            $incident = Incident::find($incident->id);
            $incident->update([
                $incident->timing_depart = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('incident.show', $incident->id)->with('success', 'Incident timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

}
