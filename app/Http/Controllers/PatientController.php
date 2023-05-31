<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Patient;
use App\Models\PatientAssessment;
use App\Models\PatientManagement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($status = null)
    {
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

        return view('patient.index', [
            'patients' => $patients,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Incident $incident)
    {
        return view('patient.create', [
            'incident' => $incident,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Incident $incident, Request $request)
    {   
        // dd($incident->nature_of_call);

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
    public function edit(Patient $patient)
    {
        return view('patient.edit', [
            'patient' => $patient,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
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
        
        // dd("okay");
        // return back();
        return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function completePatient(Patient $patient)
    {
        $patient->update([
            'completed_at'=> Carbon::now(),
        ]);
        return redirect()->route('pcr.show', $patient->id)->with('success', 'Patient information updated successfully');
    }
}
