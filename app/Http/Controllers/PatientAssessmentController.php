<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientAssessment;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class PatientAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Patient $patient)
    {
        // Only allow ambulance and admin to create patient assessment
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            return view('patient-assessment.create', [
                'patient' => $patient,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function store(Patient $patient, Request $request)
    {
        // Only allow ambulance and admin to save patient assessment
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'chief_complaint'=> 'required|string',
                'history'=> 'required|string',
                'primary1'=> 'required|string',
                'airway'=> 'required|string',
                'breathing'=> 'required|string',
                'pulse'=> 'required|string',
                'skin_appearance'=> 'required|string',
                'eye'=> 'required|numeric',
                'verbal'=> 'required|numeric',
                'motor'=> 'required|numeric',
                'signs_symptoms'=> 'nullable|string',
                'allergies'=> 'nullable|string',
                'medications'=> 'nullable|string',
                'past_history'=> 'nullable|string',
                'last_intake'=> 'nullable|string',
                'event_prior'=> 'nullable|string',
                'vital_time1'=> 'nullable|string',
                'vital_time2'=> 'nullable|string',
                'vital_time3'=> 'nullable|string',
                'vital_bp1'=> 'nullable|string',
                'vital_bp2'=> 'nullable|string',
                'vital_bp3'=> 'nullable|string',
                'vital_hr1'=> 'nullable|string',
                'vital_hr2'=> 'nullable|string',
                'vital_hr3'=> 'nullable|string',
                'vital_rr1'=> 'nullable|string',
                'vital_rr2'=> 'nullable|string',
                'vital_rr3'=> 'nullable|string',
                'vital_o2sat1'=> 'nullable|string',
                'vital_o2sat2'=> 'nullable|string',
                'vital_o2sat3'=> 'nullable|string',
                'vital_glucose1'=> 'nullable|string',
                'vital_glucose2'=> 'nullable|string',
                'vital_glucose3'=> 'nullable|string',
            ]);
    
            $patient->patient_assessment()->create([
                'chief_complaint'=> $request->chief_complaint,
                'history'=> $request->history,
                'primary1'=> $request->primary1,
                'airway'=> $request->airway,
                'breathing'=> $request->breathing,
                'pulse'=> $request->pulse,
                'skin_appearance'=> $request->skin_appearance,
                'gcs_eye'=> $request->eye,
                'gcs_verbal'=> $request->verbal,
                'gcs_motor'=> $request->motor,
                'gcs_total'=> $request->eye + $request->verbal + $request->motor,
                'signs_symptoms'=> $request->signs_symptoms,
                'allergies'=> $request->allergies,
                'medications'=> $request->medications,
                'past_history'=> $request->past_history,
                'last_intake'=> $request->last_intake,
                'event_prior'=> $request->event_prior,
                'vital_time1'=>$request->vital_time1,	
                'vital_time2'=>$request->vital_time2,	
                'vital_time3'=>$request->vital_time3,	
                'vital_bp1'=>$request->vital_bp1,	
                'vital_bp2'=>$request->vital_bp2,	
                'vital_bp3'=>$request->vital_bp3,	
                'vital_hr1'=>$request->vital_hr1,	
                'vital_hr2'=>$request->vital_hr2,	
                'vital_hr3'=>$request->vital_hr3,	
                'vital_rr1'=>$request->vital_rr1,	
                'vital_rr2'=>$request->vital_rr2,	
                'vital_rr3'=>$request->vital_rr3,	
                'vital_o2sat1'=>$request->vital_o2sat1,	
                'vital_o2sat2'=>$request->vital_o2sat2,	
                'vital_o2sat3'=>$request->vital_o2sat3,	
                'vital_glucose1'=>$request->vital_glucose1,	
                'vital_glucose2'=>$request->vital_glucose2,	
                'vital_glucose3'=>$request->vital_glucose3,	
                
            ]);
            return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient assessment added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function edit(PatientAssessment $patientAssessment)
    {
        // Only allow ambulance, comcen admin to edit patient assessment
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('patient-assessment.edit', [
                'patient_assessment' => $patientAssessment,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, PatientAssessment $patientAssessment)
    {
        // Only allow ambulance, comcen admin to update patient assessment
        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'chief_complaint'=> 'required|string',
                'history'=> 'required|string',
                'primary1'=> 'required|string',
                'airway'=> 'required|string',
                'breathing'=> 'required|string',
                'pulse'=> 'required|string',
                'skin_appearance'=> 'required|string',
                'eye'=> 'required|numeric',
                'verbal'=> 'required|numeric',
                'motor'=> 'required|numeric',
                'signs_symptoms'=> 'nullable|string',
                'allergies'=> 'nullable|string',
                'medications'=> 'nullable|string',
                'past_history'=> 'nullable|string',
                'last_intake'=> 'nullable|string',
                'event_prior'=> 'nullable|string',
                'vital_time1'=> 'nullable|string',
                'vital_time2'=> 'nullable|string',
                'vital_time3'=> 'nullable|string',
                'vital_bp1'=> 'nullable|string',
                'vital_bp2'=> 'nullable|string',
                'vital_bp3'=> 'nullable|string',
                'vital_hr1'=> 'nullable|string',
                'vital_hr2'=> 'nullable|string',
                'vital_hr3'=> 'nullable|string',
                'vital_rr1'=> 'nullable|string',
                'vital_rr2'=> 'nullable|string',
                'vital_rr3'=> 'nullable|string',
                'vital_o2sat1'=> 'nullable|string',
                'vital_o2sat2'=> 'nullable|string',
                'vital_o2sat3'=> 'nullable|string',
                'vital_glucose1'=> 'nullable|string',
                'vital_glucose2'=> 'nullable|string',
                'vital_glucose3'=> 'nullable|string',
            ]);
    
            $patientAssessment->update([
                'chief_complaint'=> $request->chief_complaint,
                'history'=> $request->history,
                'primary1'=> $request->primary1,
                'airway'=> $request->airway,
                'breathing'=> $request->breathing,
                'pulse'=> $request->pulse,
                'skin_appearance'=> $request->skin_appearance,
                'gcs_eye'=> $request->eye,
                'gcs_verbal'=> $request->verbal,
                'gcs_motor'=> $request->motor,
                'gcs_total'=> $request->eye + $request->verbal + $request->motor,
                'signs_symptoms'=> $request->signs_symptoms,
                'allergies'=> $request->allergies,
                'medications'=> $request->medications,
                'past_history'=> $request->past_history,
                'last_intake'=> $request->last_intake,
                'event_prior'=> $request->event_prior,
                'vital_time1'=>$request->vital_time1,	
                'vital_time2'=>$request->vital_time2,	
                'vital_time3'=>$request->vital_time3,	
                'vital_bp1'=>$request->vital_bp1,	
                'vital_bp2'=>$request->vital_bp2,	
                'vital_bp3'=>$request->vital_bp3,	
                'vital_hr1'=>$request->vital_hr1,	
                'vital_hr2'=>$request->vital_hr2,	
                'vital_hr3'=>$request->vital_hr3,	
                'vital_rr1'=>$request->vital_rr1,	
                'vital_rr2'=>$request->vital_rr2,	
                'vital_rr3'=>$request->vital_rr3,	
                'vital_o2sat1'=>$request->vital_o2sat1,	
                'vital_o2sat2'=>$request->vital_o2sat2,	
                'vital_o2sat3'=>$request->vital_o2sat3,	
                'vital_glucose1'=>$request->vital_glucose1,	
                'vital_glucose2'=>$request->vital_glucose2,	
                'vital_glucose3'=>$request->vital_glucose3,	
                
            ]);
            return redirect()->route('pcr.show', $patientAssessment->patient_id)->with('success', 'Patient assessment updated successfully');
        }
        else{
            return view('errors.404');
        }
    }    
}
