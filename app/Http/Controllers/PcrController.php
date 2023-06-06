<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Incident;
use App\Models\PatientAssessment;
use App\Models\PatientManagement;
use App\Models\PatientObservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PcrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Patient $patient)
    { 
        if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'ambulance') ){
            $grantAccess = false;
            if (Auth::user()->user_type == 'hospital'){
                $assignedPatients = PatientManagement::where('user_hospital_id', Auth::user()->user_hospital->id)->pluck('patient_id');
                foreach ($assignedPatients as $item) {
                    if($patient->id == $item){
                        $grantAccess = true;
                        break;
                    }
                }
            }
            elseif(Auth::user()->user_type == 'ambulance'){
                $assignedPatients = DB::table('user_ambulances')
                ->join('response_teams', 'user_ambulances.id', '=', 'response_teams.user_ambulance_id')
                ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
                ->join('patients', 'incidents.id', '=', 'patients.incident_id')
                ->where('response_teams.user_ambulance_id', '=', Auth::user()->user_ambulance->id)
                ->pluck('patients.id');
                foreach ($assignedPatients as $item) {
                    if($patient->id == $item){
                        $grantAccess = true;
                        break;
                    }
                }
            }
            else{
                return view('errors.404');
            }

            if($grantAccess){
                $incident = Incident::find($patient->incident_id);
                $patient_assessment = PatientAssessment::where('patient_id',$patient->id)->first();
                $patient_management = PatientManagement::where('patient_id',$patient->id)->first();
                $patient_observation = PatientObservation::where('patient_id',$patient->id)->first();
                
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
            }else{
                return view('errors.404');
            }
            
        }else{
            $incident = Incident::find($patient->incident_id);
            $patient_assessment = PatientAssessment::where('patient_id',$patient->id)->first();
            $patient_management = PatientManagement::where('patient_id',$patient->id)->first();
            $patient_observation = PatientObservation::where('patient_id',$patient->id)->first();
            
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
    }

    public function print(Patient $patient){
        $incident = Incident::find($patient->incident_id);
            $patient_assessment = PatientAssessment::where('patient_id',$patient->id)->first();
            $patient_management = PatientManagement::where('patient_id',$patient->id)->first();
            $patient_observation = PatientObservation::where('patient_id',$patient->id)->first();
            
            $medics = DB::table('personnels')
                ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
                ->join('response_teams', 'response_teams.id', '=', 'response_personnels.response_team_id')
                ->where('response_teams.id','=',$incident->response_team_id)
                ->get();

        return view('pcr.print', [
            'patient' => $patient,
            'incident' => $incident,
            'patient_assessment' => $patient_assessment,
            'patient_management' => $patient_management,
            'patient_observation' => $patient_observation,
            'medics' => $medics,
        ]);
    }
        
}
