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

    public function index(Request $request, $status = null)
    {
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

                // Get patients assigned to current logged on hospital
                if (Auth::user()->user_type == 'hospital'){
                    $assignedPatients = PatientManagement::where('user_hospital_id', Auth::user()->user_hospital->id)->pluck('patient_id');
                }
                // Get patients assigned to current logged on ambulance
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
                // Show patients by status
                switch($status) {
                    case('ongoing'):
                        // $patients = Patient::whereIn('id', $assignedPatients)->where('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);

                        // Check if keyword is null
                        if ($searchKeyword) {
                            
                            $patients =  DB::table('patients')
                                ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                                ->whereIn('patients.id', $assignedPatients)
                                ->whereNull('patients.completed_at')
                                ->whereNull('patients.patient_refused_at')
                                ->whereNull('patients.hospital_refused_at')
                                ->where('incidents.caller_first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('incidents.caller_mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('incidents.caller_last_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_last_name', 'like', '%'.$searchKeyword.'%')
                                ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                                ->latest('patients.created_at')
                                ->paginate(12);
                        } 
                        else {
                            $patients =  DB::table('patients')
                                ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                                ->whereIn('patients.id', $assignedPatients)
                                ->whereNull('patients.completed_at')
                                ->whereNull('patients.patient_refused_at')
                                ->whereNull('patients.hospital_refused_at')
                                ->whereNull('patients.patient_first_name')
                                ->whereNull('patients.patient_mid_name')
                                ->whereNull('patients.patient_last_name')
                                ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                                ->latest('patients.created_at')
                                ->paginate(12);
                        }
                        break;

                    case('completed'):
                        // $patients = Patient::whereIn('id', $assignedPatients)->whereNot('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        
                        // Set date and default if null
                        if ($request->search_date){
                            $tempDate = $request->search_date;
                        }
                        else{
                            $tempDate = Carbon::today();
                        }

                        // Check if keyword is null
                        if ($searchKeyword) {
                            $patients = DB::table('patients')
                                ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                                ->whereIn('patients.id', $assignedPatients)
                                ->whereDate('patients.created_at', $tempDate)
                                ->whereNot('patients.completed_at', null)
                                ->whereNot('patients.patient_refused_at', null)
                                ->whereNot('patients.hospital_refused_at', null)
                                ->where('incidents.caller_first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('incidents.caller_mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('incidents.caller_last_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_last_name', 'like', '%'.$searchKeyword.'%')
                                ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                                ->latest('patients.created_at')
                                ->paginate(12);
                        } else {
                            $patients = DB::table('patients')
                                ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                                ->whereIn('patients.id', $assignedPatients)
                                ->whereNot('patients.completed_at', null)
                                ->whereNot('patients.patient_refused_at', null)
                                ->whereNot('patients.hospital_refused_at', null)
                                ->whereDate('patients.created_at', $tempDate)
                                ->whereNull('patients.patient_first_name')
                                ->whereNull('patients.patient_mid_name')
                                ->whereNull('patients.patient_last_name')
                                ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                                ->latest('patients.created_at')
                                ->paginate(12);
                        }
                        break;

                    default:
                        // $patients = Patient::whereIn('id', $assignedPatients)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        
                        // Set date and default if null
                        if ($request->search_date){
                            $tempDate = $request->search_date;
                        }
                        else{
                            $tempDate = Carbon::today();
                        }
                        if ($searchKeyword) {
                            $patients = DB::table('patients')
                                ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                                ->whereIn('patients.id', $assignedPatients)
                                ->whereDate('patients.created_at', $tempDate)
                                ->where('incidents.caller_first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('incidents.caller_mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('incidents.caller_last_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('patients.patient_last_name', 'like', '%'.$searchKeyword.'%')
                                ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                                ->latest('patients.created_at')
                                ->paginate(12);
                        } else {
                            $patients = DB::table('patients')
                                ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                                ->whereIn('patients.id', $assignedPatients)
                                ->whereDate('patients.created_at', $tempDate)
                                ->whereNull('patients.patient_first_name')
                                ->whereNull('patients.patient_mid_name')
                                ->whereNull('patients.patient_last_name')
                                ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                                ->latest('patients.created_at')
                                ->paginate(12);
                        }
                        $status = 'all patients';
                }
            }
            // Show comcen and admin all patients
            else{
                // Show patients by status
                switch($status) {
                    case('ongoing'):
                        // $patients = Patient::where('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        
                        // dd( $searchKeyword);
                        // dd( $request->search_name);
                        
                        // Check if keyword is null
                        if ($searchKeyword) {
                            
                            $patients =  DB::table('patients')
                            ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                            ->whereNull('patients.completed_at')
                            ->whereNull('patients.patient_refused_at')
                            ->whereNull('patients.hospital_refused_at')
                            ->where('incidents.caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('incidents.caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('incidents.caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_last_name', 'like', '%'.$searchKeyword.'%')
                            ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                            ->latest('patients.created_at')
                            ->paginate(12);
                        } else {

                            $patients =  DB::table('patients')
                            ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                            ->whereNull('patients.completed_at')
                            ->whereNull('patients.patient_refused_at')
                            ->whereNull('patients.hospital_refused_at')
                            ->whereNull('patients.patient_first_name')
                            ->whereNull('patients.patient_mid_name')
                            ->whereNull('patients.patient_last_name')
                            ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                            ->latest('patients.created_at')
                            ->paginate(12);
                        }
                        break;

                    case('completed'):
                        // $patients = Patient::whereNot('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        
                        // Set date and default if null
                        if ($request->search_date){
                            $tempDate = $request->search_date;
                        }
                        else{
                            $tempDate = Carbon::today();
                        }

                        // Check if keyword is null
                        if ($searchKeyword) {
                            $patients = DB::table('patients')
                            ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                            ->whereNot('patients.completed_at', null)
                            ->whereNot('patients.patient_refused_at', null)
                            ->whereNot('patients.hospital_refused_at', null)
                            ->whereDate('patients.created_at', $tempDate)
                            ->where('incidents.caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('incidents.caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('incidents.caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_last_name', 'like', '%'.$searchKeyword.'%')
                            ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                            ->latest('patients.created_at')
                            ->paginate(12);
                        } else {
                            // dd('hello');
                            $patients = DB::table('patients')
                            ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                            ->whereNotNull('patients.completed_at')
                            ->orWhereNotNull('patients.patient_refused_at')
                            ->orWhereNotNull('patients.hospital_refused_at')
                            ->whereDate('patients.created_at', $tempDate)
                            ->whereNull('patients.patient_first_name')
                            ->whereNull('patients.patient_mid_name')
                            ->whereNull('patients.patient_last_name')
                            ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                            ->latest('patients.created_at')
                            ->paginate(12);
                        }
                        break;

                    default:
                        // $patients = Patient::latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        
                        // Set date and default if null
                        if ($request->search_date){
                            $tempDate = $request->search_date;
                        }
                        else{
                            $tempDate = Carbon::today();
                        }

                        // Check if keyword is null
                        if ($searchKeyword) {
                            $patients = DB::table('patients')
                            ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                            ->whereDate('patients.created_at', $tempDate)
                            ->where('incidents.caller_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('incidents.caller_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('incidents.caller_last_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('patients.patient_last_name', 'like', '%'.$searchKeyword.'%')
                            ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                            ->latest('patients.created_at')
                            ->paginate(12);
                        } else {
                            $patients = DB::table('patients')
                            ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                            ->whereDate('patients.created_at', $tempDate)
                            ->whereNull('patients.patient_first_name')
                            ->whereNull('patients.patient_mid_name')
                            ->whereNull('patients.patient_last_name')
                            ->select('patients.*', 'incidents.caller_first_name', 'incidents.caller_mid_name', 'incidents.caller_last_name', 'incidents.caller_number')
                            ->latest('patients.created_at')
                            ->paginate(12);
                        }
                        $status = 'all patients';
                }
            }
        }else{
            // Show hospital and ambulance only their assigned patients
            if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'ambulance') ){

                // Get patients assigned to current logged on hospital
                if (Auth::user()->user_type == 'hospital'){
                    $assignedPatients = PatientManagement::where('user_hospital_id', Auth::user()->user_hospital->id)->pluck('patient_id');
                }
                // Get patients assigned to current logged on ambulance
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
                // Show patients by status
                switch($status) {
                    case('ongoing'):
                        $patients = Patient::whereIn('id', $assignedPatients)->where('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        break;

                    case('completed'):
                        $patients = Patient::whereIn('id', $assignedPatients)->whereNot('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        break;

                    default:
                        $patients = Patient::whereIn('id', $assignedPatients)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        $status = 'all patients';
                }
            }
            // Show comcen and admin all patients
            else{
                // Show patients by status
                switch($status) {
                    case('ongoing'):
                        $patients = Patient::where('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        break;

                    case('completed'):
                        $patients = Patient::whereNot('completed_at', null)->latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        break;

                    default:
                        $patients = Patient::latest()->with(['incident', 'patient_management', 'patient_refusals'])->paginate(12);
                        $status = 'all patients';
                }

            }
        }
        return view('patient.index', [
            'patients' => $patients,
            'status' => $status,
            'searchKeyword' => $searchKeyword,
            'searchDate' => $searchDate,
        ]);
    }

    public function create(Incident $incident)
    {
        // Only allow ambulance and admin to create patient info
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
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
        // Only allow ambulance and admin to save patient info
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            if ($request->patient_conscious == "yes"){
                $this->validate($request, [
                    'ppcr_color'=> 'required|string',
                    'patient_first_name'=> 'required|string',
                    'patient_mid_name'=> 'nullable|string',
                    'patient_last_name'=> 'required|string',
                    'age'=> 'nullable|numeric',
                    'birthday'=> 'nullable|date',
                    'sex'=> 'required|string',
                    'contact_no'=> 'nullable|numeric',
                    'address'=> 'nullable|string',
                ]);
            }
            elseif ($request->patient_conscious == "no"){
                $this->validate($request, [
                    'ppcr_color'=> 'required|string',
                    'patient_first_name'=> 'nullable|string',
                    'patient_mid_name'=> 'nullable|string',
                    'patient_last_name'=> 'nullable|string',
                    'age'=> 'nullable|numeric',
                    'birthday'=> 'nullable|date',
                    'sex'=> 'required|string',
                    'contact_no'=> 'nullable|numeric',
                    'address'=> 'nullable|string',
                ]);
            }
            else{
                return view('errors.404');
            }
    
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
        // Only allow ambulance, comcen, and admin to edit patient info
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
        // Only allow ambulance, comcen, and admin to update patient info
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
    
    public function vital1(Request $request, $id)
    {
        // Allow accounts except hospital to update timings
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set enroute to current time from pcr page
            $assessment = PatientAssessment::where('patient_id', $id);
            $assessment->update([
                $assessment->vital_time1 = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->back();
        }
        else{
            return view('errors.404');
        }
    }
}
