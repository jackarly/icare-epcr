<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientAssessment;
use App\Models\Patient;

class PatientAssessmentController extends Controller
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
        return view('patient-assessment.create', [
            'patient' => $patient,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Patient $patient, Request $request)
    {
    
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

        // dd("okay");

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

        // dd("okay");

        return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient assessment added successfully');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
