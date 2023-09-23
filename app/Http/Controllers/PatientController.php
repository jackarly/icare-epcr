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
        // Set default search result values to null
        $searchKeyword = null;
        $searchDate = null;
        $reportDate = null;

        // Check if request if from search or report queries
        if ($request->searchQuery || $request->reportQuery){

            if ($request->searchQuery ){
                $searchKeyword = $request->search_name;
                $searchDate = $request->search_date;

                // Search for both name & date
                if($searchKeyword && $searchDate){
                    $patientList = DB::table('patients')
                        ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                        ->where(DB::raw("CONCAT(COALESCE(patients.patient_first_name,''),' ',COALESCE(patients.patient_mid_name,''),' ',COALESCE(patients.patient_last_name,''),' ',COALESCE(incidents.caller_first_name,''),' ',COALESCE(incidents.caller_mid_name,''),' ',COALESCE(incidents.caller_last_name,''))"), 'LIKE', '%'.$searchKeyword.'%')
                        ->whereDate('patients.created_at', '=', $searchDate)
                        ->pluck('patients.id');
                }
                // Search for either name or date
                elseif($searchKeyword == null || $searchDate == null){
                    // Search for keyword only
                    if ($searchKeyword){
                        $patientList = DB::table('patients')
                            ->join('incidents', 'patients.incident_id', '=', 'incidents.id')
                            ->where(DB::raw("CONCAT(COALESCE(patients.patient_first_name,''),' ',COALESCE(patients.patient_mid_name,''),' ',COALESCE(patients.patient_last_name,''),' ',COALESCE(incidents.caller_first_name,''),' ',COALESCE(incidents.caller_mid_name,''),' ',COALESCE(incidents.caller_last_name,''))"), 'LIKE', '%'.$searchKeyword.'%')
                            ->pluck('patients.id');
                    }
                    // Search for date only
                    elseif($searchDate){
                        $patientList = Patient::whereDate('created_at', '=', $searchDate)
                            ->pluck('id');
                    }
                    // Search all "No Name"/Unconcious patient
                    elseif ($searchKeyword == null){
                        $patientList = Patient::whereNull('patient_first_name')
                            ->pluck('id');
                    }
                }
            }
            elseif ($request->reportQuery){
                // Set reportDate
                $reportDate = $request->report_month;

                // Explode reportDate for easier query
                $yearMonth = explode("-", $reportDate);
                $year = $yearMonth[0];
                $month = $yearMonth[1];

                // Select query based on month or year
                switch($request->month_year) {
                    case('year_month'):
                        $patientList = Patient::whereYear('created_at', '=', $year)
                            ->whereMonth('created_at', '=', $month)
                            ->pluck('id');
                        break;
    
                    case('year_only'):
                        $patientList = Patient::whereYear('created_at', '=', $year)
                            ->pluck('id');
                        $reportDate = $year;
                        break;
    
                    default:
                        return view('errors.404');
                }
            }
            // Set default status for search & report queries
            $status = 'all patients';
        }

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
                    $patients = Patient::whereIn('id', $assignedPatients)
                        ->where('completed_at', null)
                        ->latest()
                        ->with(['incident', 'patient_management', 'patient_refusals'])
                        ->paginate(12);
                    break;

                case('completed'):
                    $patients = Patient::whereIn('id', $assignedPatients)
                        ->whereNot('completed_at', null)
                        ->latest()->with(['incident', 'patient_management', 'patient_refusals'])
                        ->paginate(12);
                    break;

                default:
                    
                    // Update assignedPatients if from search or report queries
                    if ($request->searchQuery || $request->reportQuery){
                        $assignedPatients=array_intersect($patientList,$assignedPatients);
                    }
                    $patients = Patient::whereIn('id', $assignedPatients)
                        ->latest()->with(['incident', 'patient_management', 'patient_refusals'])
                        ->paginate(12);
                    $status = 'all patients';
            }
        }
        // Show comcen and admin all patients
        else{

            // Show patients by status
            switch($status) {
                case('ongoing'):
                    $patients = Patient::where('completed_at', null)
                        ->latest()
                        ->with(['incident', 'patient_management', 'patient_refusals'])
                        ->paginate(12);
                    break;

                case('completed'):
                    $patients = Patient::whereNot('completed_at', null)
                        ->latest()
                        ->with(['incident', 'patient_management', 'patient_refusals'])
                        ->paginate(12);
                    break;

                default:
                    // Check if from search or report queries
                    if ($request->searchQuery || $request->reportQuery){
                        $patients = Patient::whereIn('id', $patientList)
                            ->latest()
                            ->with(['incident', 'patient_management', 'patient_refusals'])
                            ->paginate(12);
                    }
                    else{
                        $patients = Patient::latest()
                            ->with(['incident', 'patient_management', 'patient_refusals'])
                            ->paginate(12);
                    }
                    $status = 'all patients';
            }
        }

        return view('patient.index', [
            'patients' => $patients,
            'status' => $status,
            'searchKeyword' => $searchKeyword,
            'searchDate' => $searchDate,
            'reportDate' => $reportDate,
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

            // Calculate age based on known birthday
            if ($request->birthday) {
                $tempAge = Carbon::parse($request->birthday)->age;;
            }
            else{
                $tempAge = $request->age;
            }

            $patient = $incident->patients()->create([
                'ppcr_color'=> $request->ppcr_color,
                'patient_first_name'=> $request->patient_first_name,
                'patient_mid_name'=> $request->patient_mid_name,
                'patient_last_name'=> $request->patient_last_name,
                'age'=> $tempAge,
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
    
            // Calculate age based on known birthday
            if ($request->birthday) {
                $tempAge = Carbon::parse($request->birthday)->age;;
            }
            else{
                $tempAge = $request->age;
            }

            $patient->update([
                'ppcr_color'=> $request->ppcr_color,
                'patient_first_name'=> $request->patient_first_name,
                'patient_mid_name'=> $request->patient_mid_name,
                'patient_last_name'=> $request->patient_last_name,
                'age'=> $tempAge,
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
