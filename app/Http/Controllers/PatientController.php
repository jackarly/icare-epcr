<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Patient;
use App\Models\PatientAssessment;
use App\Models\PatientManagement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($status = null)
    {
        if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'ambulance') ){
            if (Auth::user()->user_type == 'hospital'){
                $assignedPatients = PatientManagement::where('user_hospital_id', Auth::user()->user_hospital->id)->pluck('patient_id');
            }
            elseif(Auth::user()->user_type == 'ambulance'){
                $assignedPatients = DB::table('user_ambulances')
                ->join('response_teams', 'user_ambulances.id', '=', 'response_teams.user_ambulance_id')
                ->join('incidents', 'response_teams.id', '=', 'incidents.response_team_id')
                ->join('patients', 'incidents.id', '=', 'patients.incident_id')
                ->where('response_teams.user_ambulance_id', '=', Auth::user()->user_ambulance->id)
                ->pluck('patients.id');
            }
            else{
                return view('errors.404');
            }
            switch($status) {
                case('ongoing'):
                    $patients = Patient::whereIn('id', $assignedPatients)->where('completed_at', null)->latest()->with(['patient_management'])->paginate(12);
                    break;

                case('completed'):
                    $patients = Patient::whereIn('id', $assignedPatients)->whereNot('completed_at', null)->latest()->with(['patient_management'])->paginate(12);
                    break;

                default:
                    $patients = Patient::whereIn('id', $assignedPatients)->latest()->with(['patient_management'])->paginate(12);
                    $status = 'all patients';
            }
        }
        else{
            switch($status) {
                case('ongoing'):
                    $patients = Patient::where('completed_at', null)->latest()->with(['patient_management'])->paginate(12);
                    break;

                case('completed'):
                    $patients = Patient::whereNot('completed_at', null)->latest()->with(['patient_management'])->paginate(12);
                    break;

                default:
                    $patients = Patient::latest()->with(['patient_management'])->paginate(12);
                    $status = 'all patients';
            }

        }
        return view('patient.index', [
            'patients' => $patients,
            'status' => $status,
        ]);
    }

    public function create(Incident $incident)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('patient.create', [
                'incident' => $incident,
            ]);
        }
        else{
            return view('errors.404');
        } 
    }

    public function store(Incident $incident, Request $request)
    {   
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'ppcr_color'=> 'required|string',
                'patient_first_name'=> 'required|string',
                'patient_mid_name'=> 'nullable|string',
                'patient_last_name'=> 'required|string',
                'age'=> 'required|numeric',
                'birthday'=> 'nullable|date',
                'sex'=> 'required|string',
                'contact_no'=> 'nullable|numeric',
                'address'=> 'nullable|string',
            ]);
    
            $patient = $incident->patients()->create([
                'ppcr_color'=> $request->ppcr_color,
                'patient_first_name'=> $request->patient_first_name,
                'patient_mid_name'=> $request->patient_mid_name,
                'patient_last_name'=> $request->patient_last_name,
                'age'=> $request->age,
                'birthday'=> $request->birthday,
                'sex'=> $request->sex,
                'contact_no'=> $request->contact_no,
                'address'=> $request->address,
                
            ]);
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient information added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function edit(Patient $patient)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('patient.edit', [
                'patient' => $patient,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, Patient $patient)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'ppcr_color'=> 'required|string',
                'patient_first_name'=> 'required|string',
                'patient_mid_name'=> 'nullable|string',
                'patient_last_name'=> 'required|string',
                'age'=> 'required|numeric',
                'birthday'=> 'nullable|date',
                'sex'=> 'required|string',
                'contact_no'=> 'nullable|numeric',
                'address'=> 'nullable|string',
            ]);
    
            $patient->update([
                'ppcr_color'=> $request->ppcr_color,
                'patient_first_name'=> $request->patient_first_name,
                'patient_mid_name'=> $request->patient_mid_name,
                'patient_last_name'=> $request->patient_last_name,
                'age'=> $request->age,
                'birthday'=> $request->birthday,
                'sex'=> $request->sex,
                'contact_no'=> $request->contact_no,
                'address'=> $request->address,
                
            ]);
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient information updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function completePatient(Patient $patient)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $patient->update([
                'completed_at'=> Carbon::now(),
            ]);
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient information updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

}
