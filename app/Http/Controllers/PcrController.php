<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Incident;
use App\Models\PatientAssessment;
use App\Models\PatientManagement;
use App\Models\PatientObservation;
use Illuminate\Support\Facades\DB;

class PcrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        dd('hallu');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        // dd('hallu dot show');
        // dd($patient->id);

        $incident = Incident::find($patient->incident_id);

        // dd($incident->id);

        $patient_assessment = PatientAssessment::where('patient_id',$patient->id)->first();
        $patient_management = PatientManagement::where('patient_id',$patient->id)->first();
        $patient_observation = PatientObservation::where('patient_id',$patient->id)->first();
        
        // dd($patient_management);
        $medics = DB::table('personnels')
            ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
            ->join('response_teams', 'response_teams.id', '=', 'response_personnels.response_team_id')
            ->where('response_teams.id','=',$incident->response_team_id)
            ->get();


        return view('pcr.show', [
            'patient' => $patient,
            'incident' => $incident,
            'patient_assessment' => $patient_assessment,
            'patient_management' => $patient_management,
            'patient_observation' => $patient_observation,
            'medics' => $medics,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
