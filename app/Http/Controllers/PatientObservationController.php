<?php

namespace App\Http\Controllers;

use App\Models\PatientObservation;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientObservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Patient $patient)
    {
        // Only allow ambulance and admin to create patient observation
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            return view('patient-observation.create', [
                'patient' => $patient,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function store(Patient $patient, Request $request)
    {
        // Only allow ambulance and admin to save patient observation
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
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
        else{
            return view('errors.404');
        }
    }

    public function edit(PatientObservation $patientObservation)
    {
        // Only allow ambulance, comcen, and admin to edit patient observation
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('patient-observation.edit', [
                'patient_observation' => $patientObservation,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, PatientObservation $patientObservation)
    {
        // Only allow ambulance, comcen, and admin to update patient observation
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
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
        else{
            return view('errors.404');
        }
    }
    
}
