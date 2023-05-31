<?php

namespace App\Http\Controllers;

use App\Models\PatientObservation;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientObservationController extends Controller
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
        return view('patient-observation.create', [
            'patient' => $patient,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Patient $patient, Request $request)
    {

        // dd($request->age_group);

        $this->validate($request, [
            'observations'=> 'nullable|string',
            'age_group'=> 'nullable|string',
            'wound'=> 'nullable|boolean',
            'burn'=> 'nullable|boolean',
            'dislocation'=> 'nullable|boolean',
            'fracture'=> 'nullable|boolean',
            'numbness'=> 'nullable|boolean',
            'rash'=> 'nullable|boolean',
            'swelling'=> 'nullable|boolean',
            'burn_classification'=> 'nullable|string',
        ]);

        
        // Calculate Burn Area
        $burn_total = 0;
        if($request->age_group === "adult"){
            if($request->back_head){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->back_left_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->back_right_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->front_head){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->front_left_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->front_right_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->front_genitalia){
                $burn_total = $burn_total + 1;
            }
        }elseif($request->age_group === "pedia"){
            if($request->back_head){
                $burn_total = $burn_total + 7;
            }
            if($request->back_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->back_left_leg){
                $burn_total = $burn_total + 8;
            }
            if($request->back_right_leg){
                $burn_total = $burn_total + 8;
            }
            if($request->front_head){
                $burn_total = $burn_total + 7;
            }
            if($request->front_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->front_left_leg){
                $burn_total = $burn_total + 8;
            }
            if($request->front_right_leg){
                $burn_total = $burn_total + 8;
            }
        }else{
            dd('error');
        }

        $patient->patient_observation()->create([
            'observations'=>  $request->observations,
            'age_group'=> $request->age_group,
            'wound'=> $request->wound,
            'burn'=> $request->burn,
            'burn_calculation'=> $burn_total,
            'dislocation'=> $request->dislocation,
            'fracture'=> $request->fracture,
            'numbness'=> $request->numbness,
            'rash'=> $request->rash,
            'swelling'=> $request->swelling,
            'burn_classification'=>  $request->burn_classification,
        ]);
        
        return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient assessment added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientObservation $patientObservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientObservation $patientObservation)
    {
        return view('patient-observation.edit', [
            'patient_observation' => $patientObservation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PatientObservation $patientObservation)
    {
        $this->validate($request, [
            'observations'=> 'nullable|string',
            'age_group'=> 'nullable|string',
            'wound'=> 'nullable|boolean',
            'burn'=> 'nullable|boolean',
            'dislocation'=> 'nullable|boolean',
            'fracture'=> 'nullable|boolean',
            'numbness'=> 'nullable|boolean',
            'rash'=> 'nullable|boolean',
            'swelling'=> 'nullable|boolean',
            'burn_classification'=> 'nullable|string',
        ]);

        
        // Calculate Burn Area
        $burn_total = 0;
        if($request->age_group === "adult"){
            if($request->back_head){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->back_left_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->back_right_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->front_head){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->front_left_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->front_right_leg){
                $burn_total = $burn_total + 9;
            }
            if($request->front_genitalia){
                $burn_total = $burn_total + 1;
            }
        }elseif($request->age_group === "pedia"){
            if($request->back_head){
                $burn_total = $burn_total + 7;
            }
            if($request->back_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->back_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->back_left_leg){
                $burn_total = $burn_total + 8;
            }
            if($request->back_right_leg){
                $burn_total = $burn_total + 8;
            }
            if($request->front_head){
                $burn_total = $burn_total + 7;
            }
            if($request->front_left_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_right_arm){
                $burn_total = $burn_total + 4.5;
            }
            if($request->front_torso){
                $burn_total = $burn_total + 18;
            }
            if($request->front_left_leg){
                $burn_total = $burn_total + 8;
            }
            if($request->front_right_leg){
                $burn_total = $burn_total + 8;
            }
        }else{
            dd('error');
        }

        $patientObservation->update([
            'observations'=>  $request->observations,
            'age_group'=> $request->age_group,
            'wound'=> $request->wound,
            'burn'=> $request->burn,
            'burn_calculation'=> $burn_total,
            'dislocation'=> $request->dislocation,
            'fracture'=> $request->fracture,
            'numbness'=> $request->numbness,
            'rash'=> $request->rash,
            'swelling'=> $request->swelling,
            'burn_classification'=>  $request->burn_classification,
        ]);
        
        return redirect()->route('pcr.show', $patientObservation->patient_id)->with('success', 'Patient assessment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientObservation $patientObservation)
    {
        //
    }
}
