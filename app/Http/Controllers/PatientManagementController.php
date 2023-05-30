<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\UserHospital;
use App\Models\PatientManagement;

class PatientManagementController extends Controller
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
        $hospitals = UserHospital::all();

        return view('patient-management.create', [
            'patient' => $patient,
            'hospitals' => $hospitals,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Patient $patient, Request $request)
    {
        // dd("okay");
        // dd($request);
        
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
            'arrival'=> 'nullable|string',
            'handover'=> 'nullable|string',
            'clear'=> 'nullable|string',
            'receiving_provider'=> 'required|string',
            'provider_position'=> 'nullable|string',
        ]);

        
        // dd($request->facility_assigned);

        // dd("okay");

        $patient->patient_management()->create([
            'airway_breathing' => $request->airway_breathing,
            'circulation' => $request->circulation,
            'wound_burn_care' => $request->wound_burn_care,
            'immobilization' => $request->immobilization,
            'others1' => $request->others1,
            'others2' => $request->others2,
            'receiving_facility' => $request->receiving_facility,
            'timings_arrival' => $request->arrival,
            'timings_handover' => $request->handover,
            'timings_clear' => $request->clear,
            'narrative' => $request->narrative,
            'receiving_provider' => $request->receiving_provider,
            'provider_position'=> $request->provider_position,
            'user_hospital_id' => $request->facility_assigned,
        ]);

        // dd("okay");

        return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient management added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientManagement $patientManagement)
    {
        $hospitals = UserHospital::all();

        return view('patient-management.edit', [
            'patient_management' => $patientManagement,
            'hospitals' => $hospitals,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PatientManagement $patientManagement)
    {
        // dd($request->provider_position);

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
            'arrival'=> 'nullable|string',
            'handover'=> 'nullable|string',
            'clear'=> 'nullable|string',
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
            'timings_arrival' => $request->arrival,
            'timings_handover' => $request->handover,
            'timings_clear' => $request->clear,
            'narrative' => $request->narrative,
            'receiving_provider' => $request->receiving_provider,
            'provider_position'=> $request->provider_position,
            'user_hospital_id' => $request->facility_assigned,
        ]);

        // dd($patientManagement->provider_position);

        return redirect()->route('pcr.show', $patientManagement->patient_id)->with('success', 'Patient management updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
