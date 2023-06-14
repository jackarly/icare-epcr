<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\UserHospital;
use App\Models\PatientManagement;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(Patient $patient)
    {
        // Only allow ambulance and admin to create patient management
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            $hospitals = UserHospital::all();
            return view('patient-management.create', [
                'patient' => $patient,
                'hospitals' => $hospitals,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function store(Patient $patient, Request $request)
    {
        // Only allow ambulance and admin to save patient management
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'airway_breathing'=> 'required|string',
                'circulation'=> 'required|string',
                'wound_burn_care'=> 'required|string',
                'immobilization'=> 'required|string',
                'others1'=> 'required|string',
                'others2'=> 'nullable|string',
                'receiving_facility'=> 'required|string',
                'facility_assigned'=> 'required|integer',
                'narrative'=> 'nullable|string',
                'receiving_provider'=> 'required|string',
                'provider_position'=> 'nullable|string',
            ]);
    
            $patient->patient_management()->create([
                'airway_breathing' => $request->airway_breathing,
                'circulation' => $request->circulation,
                'wound_burn_care' => $request->wound_burn_care,
                'immobilization' => $request->immobilization,
                'others1' => $request->others1,
                'others2' => $request->others2,
                'receiving_facility' => $request->receiving_facility,
                'narrative' => $request->narrative,
                'receiving_provider' => $request->receiving_provider,
                'provider_position'=> $request->provider_position,
                'user_hospital_id' => $request->facility_assigned,
            ]);
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient management added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function edit(PatientManagement $patientManagement)
    {
        // Only allow ambulance, comcen, and admin to save patient management
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $hospitals = UserHospital::all();
    
            return view('patient-management.edit', [
                'patient_management' => $patientManagement,
                'hospitals' => $hospitals,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, PatientManagement $patientManagement)
    {
        // Only allow ambulance, comcen, and admin to save patient management
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'airway_breathing'=> 'required|string',
                'circulation'=> 'required|string',
                'wound_burn_care'=> 'required|string',
                'immobilization'=> 'required|string',
                'others1'=> 'required|string',
                'others2'=> 'nullable|string',
                'receiving_facility'=> 'required|string',
                'facility_assigned'=> 'required|integer',
                'narrative'=> 'nullable|string',
                'receiving_provider'=> 'required|string',
                'provider_position'=> 'nullable|string',
            ]);
            
            $patientManagement->update([
                'airway_breathing' => $request->airway_breathing,
                'circulation' => $request->circulation,
                'wound_burn_care' => $request->wound_burn_care,
                'immobilization' => $request->immobilization,
                'others1' => $request->others1,
                'others2' => $request->others2,
                'receiving_facility' => $request->receiving_facility,
                'narrative' => $request->narrative,
                'receiving_provider' => $request->receiving_provider,
                'provider_position'=> $request->provider_position,
                'user_hospital_id' => $request->facility_assigned,
            ]);
            return redirect()->route('pcr.show', $patientManagement->patient_id)->with('success', 'Patient management updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function arrival(Request $request,Patient $patient)
    {
        // Only allow ambulance, comcen, and admin to save patient management
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set arrival to current time
            $patientManagement = PatientManagement::where('patient_id', $patient->id)->first();
            $patientManagement->update([
                $patientManagement->timings_arrival = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }
    
    public function handover(Request $request,Patient $patient)
    {
        // Only allow ambulance, comcen, and admin to save patient management
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set handover to current time
            $patientManagement = PatientManagement::where('patient_id', $patient->id)->first();
            $patientManagement->update([
                $patientManagement->timings_handover = Carbon::now()->format('g:i A')
            ]);
    
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient timing updated successfully');
        }
        else{
            return view('errors.404');
        }
    }
    
    public function clear(Request $request,Patient $patient)
    {
        // Only allow hospital, comcen, and admin update timings_clear
        if ( (Auth::user()->user_type == 'hospital') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            
            // Set clear to current time
            $patientManagement = PatientManagement::where('patient_id', $patient->id)->first();
            $patientManagement->update([
                $patientManagement->timings_clear = Carbon::now()->format('g:i A')
            ]);

            $patient->update([
                'completed_at'=> Carbon::now(),
            ]);
    
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient Care Report Completed');
        }
        else{
            return view('errors.404');
        }
    }
}
