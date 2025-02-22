@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8">
            <h4 class="text-center mb-3 fw-bold">Update Patient Assessment</h5>
            <div class="card">
                <div class="card-header">Patient Assessment</div>
                    
                <div class="card-body">
                <form method="POST" action="{{ route('assessment.update', $patient_assessment->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="chief_complaint" class="col-md-4 col-form-label text-md-end">Chief Complaint</label>
                            <div class="col-md-6">
                                <textarea id="chief_complaint" class="form-control @error('chief_complaint') is-invalid @enderror" name="chief_complaint"  required autocomplete="chief_complaint" autofocus>{{ old('chief_complaint') ?? $patient_assessment->chief_complaint }}</textarea>

                                @error('chief_complaint')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <textarea id="chief_complaint" class="form-control @error('chief_complaint') is-invalid @enderror" name="chief_complaint"  required autocomplete="chief_complaint" autofocus>{{ old('chief_complaint') ?? $patient_assessment->chief_complaint }}</textarea>

                                @error('chief_complaint')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="history" class="col-md-4 col-form-label text-md-end">History</label>
                            <div class="col-md-6">
                                <textarea id="history" class="form-control @error('history') is-invalid @enderror" name="history" required autocomplete="history" autofocus>{{ old('history') ?? $patient_assessment->history }}</textarea>

                                @error('history')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label for="primary1" class="col-md-4 col-form-label text-md-end">Primary</label>
                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="primary1" id="primary11" value="conscious"{{($patient_assessment->primary1 == 'conscious') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="primary11" style="text-transform: capitalize">
                                        conscious
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="primary1" id="primary12" value="unconscious" {{($patient_assessment->primary1 == 'unconscious') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="primary12" style="text-transform: capitalize">
                                        unconscious
                                    </label>
                                </div>
                                

                                @error('primary1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4 mt-2">
                                <span class="">Airway</span>
                                <div class="row">
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="airway" id="airway1" value="clear" {{($patient_assessment->airway == 'clear') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway1" style="text-transform: capitalize">
                                                clear
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="airway" id="airway2" value="partial" {{($patient_assessment->airway == 'partial') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway2" style="text-transform: capitalize">
                                                partial
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="airway" id="airway3" value="obstructed" {{($patient_assessment->airway == 'obstructed') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway3" style="text-transform: capitalize">
                                                obstructed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4 mt-2">
                                <span class="">Breathing</span>
                                <div class="row">
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="breathing" id="breathing1" value="normal" {{($patient_assessment->breathing == 'normal') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="breathing1" style="text-transform: capitalize">
                                                normal
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="breathing" id="breathing2" value="fast" {{($patient_assessment->breathing == 'fast') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="breathing2" style="text-transform: capitalize">
                                                fast
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="breathing" id="breathing3" value="slow" {{($patient_assessment->breathing == 'slow') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="breathing3" style="text-transform: capitalize">
                                                slow
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="breathing" id="breathing4" value="absent" {{($patient_assessment->breathing == 'absent') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="breathing4" style="text-transform: capitalize">
                                                absent
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <span class="col-md-4 text-md-end mt-2">Circulation</span>
                            <div class="col-md-6 mt-2">
                                <span class="">Pulse</span>
                                <div class="row">
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pulse" id="pulse1" value="present" {{($patient_assessment->pulse == 'present') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="pulse1" style="text-transform: capitalize">
                                                present
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pulse" id="pulse2" value="rapid" {{($patient_assessment->pulse == 'rapid') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="pulse2" style="text-transform: capitalize">
                                                rapid
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pulse" id="pulse3" value="weak" {{($patient_assessment->pulse == 'weak') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="pulse3" style="text-transform: capitalize">
                                                weak
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pulse" id="pulse4" value="absent" {{($patient_assessment->pulse == 'absent') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="pulse4" style="text-transform: capitalize">
                                                absent
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <span class="">Skin Appearance</span>
                                <div class="row">
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="skin_appearance" id="skin_appearance1" value="normal" {{($patient_assessment->skin_appearance == 'normal') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="skin_appearance1" style="text-transform: capitalize">
                                                normal
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="skin_appearance" id="skin_appearance2" value="pale" {{($patient_assessment->skin_appearance == 'pale') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="skin_appearance2" style="text-transform: capitalize">
                                                pale
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="skin_appearance" id="skin_appearance3" value="cyanosed" {{($patient_assessment->skin_appearance == 'cyanosed') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="skin_appearance3" style="text-transform: capitalize">
                                                cyanosed
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="skin_appearance" id="skin_appearance4" value="warm" {{($patient_assessment->skin_appearance == 'warm') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="skin_appearance4" style="text-transform: capitalize">
                                                warm
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="skin_appearance" id="skin_appearance5" value="cold" {{($patient_assessment->skin_appearance == 'cold') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="skin_appearance5" style="text-transform: capitalize">
                                                cold
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label for="gcs_total" class="col-md-4 col-form-label text-md-end">Glasgow Coma Scale</label>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span>Eye</span>
                                        <hr class="my-0">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="eye" id="eye4" value="4" {{($patient_assessment->gcs_eye == '4') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="eye4" style="text-transform: capitalize">
                                                4 Spontaneous
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="eye" id="eye3" value="3" {{($patient_assessment->gcs_eye == '3') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="eye3" style="text-transform: capitalize">
                                                3 Voice
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="eye" id="eye2" value="2" {{($patient_assessment->gcs_eye == '2') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="eye2" style="text-transform: capitalize">
                                                2 Pain
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="eye" id="eye1" value="1" {{($patient_assessment->gcs_eye == '1') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="eye1" style="text-transform: capitalize">
                                                1 None
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <span>Verbal</span>
                                        <hr class="my-0">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="verbal" id="verbal5" value="5" {{($patient_assessment->gcs_verbal == '5') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="verbal5" style="text-transform: capitalize">
                                                5 Oriented
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verbal" id="verbal4" value="4" {{($patient_assessment->gcs_verbal == '4') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="verbal4" style="text-transform: capitalize">
                                                4 Confused
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verbal" id="verbal3" value="3" {{($patient_assessment->gcs_verbal == '3') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="verbal3" style="text-transform: capitalize">
                                                3 Inappropriate
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verbal" id="verbal2" value="2" {{($patient_assessment->gcs_verbal == '2') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="verbal2" style="text-transform: capitalize">
                                                2 Garbled
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="verbal" id="verbal1" value="1" {{($patient_assessment->gcs_verbal == '1') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="verbal1" style="text-transform: capitalize">
                                                1 None
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <span>Motor</span>
                                        <hr class="my-0">
                                        <div class="form-check form-check-inline mt-1">
                                            <input class="form-check-input" type="radio" name="motor" id="motor6" value="6" {{($patient_assessment->gcs_motor == '6') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="motor6" style="text-transform: capitalize">
                                                6 Obeys
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="motor" id="motor5" value="5" {{($patient_assessment->gcs_motor == '5') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="motor5" style="text-transform: capitalize">
                                                5 Localizes
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="motor" id="motor4" value="4" {{($patient_assessment->gcs_motor == '4') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="motor4" style="text-transform: capitalize">
                                                4 Withdraws
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="motor" id="motor3" value="3" {{($patient_assessment->gcs_motor == '3') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="motor3" style="text-transform: capitalize">
                                                3 Flexion
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="motor" id="motor2" value="2" {{($patient_assessment->gcs_motor == '2') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="motor2" style="text-transform: capitalize">
                                                2 Extension
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="motor" id="motor1" value="1" {{($patient_assessment->gcs_motor == '1') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="motor1" style="text-transform: capitalize">
                                                1 None
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <span class="col-md-4 text-md-end">Secondary</span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <span class="">Signs & Symptoms</span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-select text-capitalize" id="selection_signs_symptoms" name="selection_signs_symptoms" class="form-control" onchange="PopulateSignSymptoms()">
                                            <option class="text-center" value="">--- Select Multiple ---</option>
                                            <option class="text-start" value="abdominal pain ">abdominal pain </option>
                                            <option class="text-start" value="blood in stool ">blood in stool </option>
                                            <option class="text-start" value="chest pain ">chest pain </option>
                                            <option class="text-start" value="constipation ">constipation </option>
                                            <option class="text-start" value="cough ">cough </option>
                                            <option class="text-start" value="diarrhea ">diarrhea </option>
                                            <option class="text-start" value="difficulty swallowing ">difficulty swallowing </option>
                                            <option class="text-start" value="dizziness ">dizziness </option>
                                            <option class="text-start" value="eye discomfort and redness ">eye discomfort and redness </option>
                                            <option class="text-start" value="eye problems ">eye problems </option>
                                            <option class="text-start" value="foot pain or ankle pain ">foot pain or ankle pain </option>
                                            <option class="text-start" value="foot swelling or leg swelling ">foot swelling or leg swelling </option>
                                            <option class="text-start" value="headaches ">headaches </option>
                                            <option class="text-start" value="heart palpitations ">heart palpitations </option>
                                            <option class="text-start" value="hip pain ">hip pain </option>
                                            <option class="text-start" value="knee pain ">knee pain </option>
                                            <option class="text-start" value="low back pain ">low back pain </option>
                                            <option class="text-start" value="nasal congestion ">nasal congestion </option>
                                            <option class="text-start" value="nausea or vomiting ">nausea or vomiting </option>
                                            <option class="text-start" value="neck pain ">neck pain </option>
                                            <option class="text-start" value="numbness or tingling in hands ">numbness or tingling in hands </option>
                                            <option class="text-start" value="pelvic pain">pelvic pain</option>
                                            <option class="text-start" value="shortness of breath ">shortness of breath </option>
                                            <option class="text-start" value="shoulder pain ">shoulder pain </option>
                                            <option class="text-start" value="sore throat ">sore throat </option>
                                            <option class="text-start" value="urinary problems ">urinary problems </option>
                                            <option class="text-start" value="wheezing ">wheezing </option>
                                        </select>

                                        <textarea id="signs_symptoms" class="form-control @error('signs_symptoms') is-invalid @enderror mt-1" name="signs_symptoms" autocomplete="signs_symptoms" autofocus>{{ old('signs_symptoms') ?? $patient_assessment->signs_symptoms }}</textarea>

                                        @error('signs_symptoms')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <span class="">Allergies</span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-select text-capitalize" id="selection_allergies" name="selection_allergies" class="form-control" onchange="PopulateAllergies()">
                                            <option class="text-center" value="">--- Select Multiple ---</option>
                                            <option class="text-start" value="no known drug allergies">no known drug allergies</option>
                                            <option class="text-start" value="no known environmental, food, or seasonal allergies">no known environmental, food, or seasonal allergies</option>
                                            <option class="text-start" value="benadryl">benadryl</option>
                                            <option class="text-start" value="cipro">cipro</option>
                                            <option class="text-start" value="sulfa drugs">sulfa drugs</option>
                                        </select>

                                        <textarea id="allergies" class="form-control @error('allergies') is-invalid @enderror mt-1" name="allergies" autocomplete="allergies" autofocus>{{ old('allergies') ?? $patient_assessment->allergies }}</textarea>

                                        @error('allergies')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <span class="">Medications</span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-select text-capitalize" id="selection_medications" name="selection_medications" class="form-control" onchange="PopulateMedications()">
                                            <option class="text-center" value="">--- Select Multiple ---</option>
                                            <option class="text-start" value="aspirin 81 mg">aspirin 81 mg</option>
                                            <option class="text-start" value="diltiazem 300 mg">diltiazem 300 mg</option>
                                            <option class="text-start" value="ibrupofen">ibrupofen</option>
                                            <option class="text-start" value="metformin 500 mg">metformin 500 mg</option>
                                            <option class="text-start" value="theophyline (uniphyl) 600 mg">theophyline (uniphyl) 600 mg</option>
                                        </select>

                                        <textarea id="medications"class="form-control @error('medications') is-invalid @enderror mt-1" name="medications"  autocomplete="medications" autofocus>{{ old('medications') ?? $patient_assessment->medications }}</textarea>

                                        @error('medications')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <span class="">Past History</span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-select text-capitalize" id="selection_past_history" name="selection_past_history" class="form-control" onchange="PopulatePastHistory()">
                                            <option class="text-center" value="">--- Select Multiple ---</option>
                                            <option class="text-start" value="cardiac stent in">cardiac stent in (YEAR)</option>
                                            <option class="text-start" value="kidney stone retrieval in">kidney stone retrieval in (YEAR)</option>
                                        </select>

                                        <textarea id="past_history" class="form-control @error('past_history') is-invalid @enderror mt-1" name="past_history"  autocomplete="past_history" autofocus>{{ old('past_history') ?? $patient_assessment->past_history }}</textarea>

                                        @error('past_history')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <span class="">Last Intake</span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea id="last_intake" class="form-control @error('last_intake') is-invalid @enderror" name="last_intake"  autocomplete="last_intake" autofocus>{{ old('last_intake') ?? $patient_assessment->last_intake }}</textarea>

                                        @error('last_intake')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <span class="">Event Prior</span>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea id="event_prior" class="form-control @error('event_prior') is-invalid @enderror" name="event_prior"  autocomplete="event_prior" autofocus>{{ old('event_prior') ?? $patient_assessment->event_prior }}</textarea>

                                        @error('event_prior')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function PopulateChiefComplaint() {
            var dropdown = document.getElementById("selection_chief_complaint");
            var field = document.getElementById("chief_complaint");
            if ( field.value == "" ){
                field.value = dropdown.value;   
            }else{
                field.value += ", " + dropdown.value;
            }
        }

        function PopulateSignSymptoms() {
            var dropdown = document.getElementById("selection_signs_symptoms");
            var field = document.getElementById("signs_symptoms");
            if ( field.value == "" ){
                field.value = dropdown.value;   
            }else{
                field.value += ", " + dropdown.value;
            }
        }

        function PopulateAllergies() {
            var dropdown = document.getElementById("selection_allergies");
            var field = document.getElementById("allergies");
            if ( field.value == "" ){
                field.value = dropdown.value;   
            }else{
                field.value += ", " + dropdown.value;
            }
        }

        function PopulateMedications() {
            var dropdown = document.getElementById("selection_medications");
            var field = document.getElementById("medications");
            if ( field.value == "" ){
                field.value = dropdown.value;   
            }else{
                field.value += ", " + dropdown.value;
            }
        }

        function PopulatePastHistory() {
            var dropdown = document.getElementById("selection_past_history");
            var field = document.getElementById("past_history");
            if ( field.value == "" ){
                field.value = dropdown.value;   
            }else{
                field.value += ", " + dropdown.value;
            }
        }
        
    </script>
@endpush