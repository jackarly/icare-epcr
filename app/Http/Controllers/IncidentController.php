<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Patient;
use App\Models\ResponseTeam;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = Incident::latest()->paginate(12);

        return view('incident.index', [
            'incidents' => $incidents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incident.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        // dd("okay");
        // return redirect()->route('login');

        // saveOnly VS saveTeam
        return redirect()->route('incident')->with('success', 'New incident added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        // Only show response team added today
        $responses = ResponseTeam::whereDate('created_at', Carbon::today())->get();
        // dd($incident->id);
        // dd($pcr = Patient::find($incident->id));
        // $patient = Patient::where('incident_id', $incident->id);
        // $patients = Patient::where('incident_id', $incident->id)->get();
        $patients = $incident->patients()->get();
        // dd($patients);
        $medics= null;
        if  ($incident->response_team_id){
            $medics = DB::table('personnels')
                ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
                ->join('response_teams', 'response_teams.id', '=', 'response_personnels.response_team_id')
                ->where('response_teams.id','=',$incident->response_team_id)
                ->get();
        }
        // dd($patient->id);

        return view('incident.show', [
            'incident' => $incident,
            'patients' => $patients,
            'responses' => $responses,
            'medics' => $medics,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        return view('incident.edit', [
            'incident' => $incident,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident)
    {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assign(Request $request,Incident $incident)
    {
        $this->validate($request, [
            'response_team'=> 'required',
        ]);

        $incident->response_team_id = $request->response_team;
        $incident->save();

        // dd($request);
        return redirect()->route('incident.show', $incident->id )->with('success', 'Response team added successfully');
    }
    
    public function updateTimings(Request $request, Patient $patient)
    {

        $this->validate($request, [
            'timing_dispatch'=> 'required|string',
            'timing_enroute'=> 'required|string',
            'timing_arrival'=> 'required|string',
            'timing_depart'=> 'required|string',
        ]);
        // $incident = $patient->incident();

        $incident = Incident::find($patient->incident_id);
        $incident->timing_dispatch = $request->timing_dispatch;
        $incident->timing_enroute = $request->timing_enroute;
        $incident->timing_arrival = $request->timing_arrival;
        $incident->timing_depart = $request->timing_depart;
        $incident->save();

        // dd($request);
        return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient incident updated successfully');
    }
}
