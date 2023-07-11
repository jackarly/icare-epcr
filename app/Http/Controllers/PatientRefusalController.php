<?php

namespace App\Http\Controllers;

use App\Models\PatientRefusal;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientRefusalController extends Controller
{
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
        // Only allow ambulance and admin to create patient observation
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            return view('patient-refusal.patient', [
                'patient' => $patient,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        // Only allow ambulance and admin to create patient observation
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'patient_refusal_witness'=> 'required',
            ]);

            $patient->update([
                'patient_refusal_witness'=>  $request->patient_refusal_witness,
                'patient_refused_at'=>  Carbon::now()
            ]);

            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient refusal added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function createHospital(Patient $patient)
    {
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'admin') ){
            return view('patient-refusal.hospital-create', [
                'patient' => $patient,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function storeHospital(Request $request, Patient $patient)
    {
        $this->validate($request, [
            'hospital_nurse_doctor'=> 'required',
            'hospital_reasons'=> 'required',
        ]);

        // Update current hospital refused time
        $patient->update([
            'hospital_refused_at'=>  Carbon::now()
        ]);

        // Get current hospital id
        $hospital_id = $patient->patient_management->user_hospital_id;

        $patient->patient_refusals()->create([
            'hospital_nurse_doctor'=>  $request->hospital_nurse_doctor,
            'hospital_reasons'=>  $request->hospital_reasons,
            'user_hospital_id'=>  $hospital_id,
        ]);
        
        return redirect()->route('pcr.show', $patient->id)->with('success', 'Hospital refusal added successfully');
    }

    public function editHospital(PatientRefusal $patientRefusal)
    {
        if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'admin') ){
            return view('patient-refusal.hospital-edit', [
                'patientRefusal' => $patientRefusal,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function updateHospital(PatientRefusal $patientRefusal)
    {
        $this->validate($request, [
            'hospital_nurse_doctor'=> 'required',
            'hospital_reasons'=> 'required',
        ]);

        // Get current hospital id
        $hospital_id = $patient->patient_management->user_hospital_id;

        $patient->patient_refusals()->create([
            'hospital_nurse_doctor'=>  $request->hospital_nurse_doctor,
            'hospital_reasons'=>  $request->hospital_reasons,
            'user_hospital_id'=>  $hospital_id,
        ]);
        
        return redirect()->route('pcr.show', $patient->id)->with('success', 'Hospital refusal added successfully');
    }

    public function destroyHospital(PatientRefusal $patientRefusal)
    {
        $patientRefusal->delete();
        
        return redirect()->route('pcr.show', $patientRefusal->patient_id)->with('success', 'Hospital refusal updated successfully');
    }
}
