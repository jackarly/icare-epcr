@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <h4 class="text-center mb-3 fw-bold">Patient Care Report</h5>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="fw-bold mb-3">Pre-Hospital Patient Care Report
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                            </h5>
                            
                            <div class="col-md-12">
                                <ul class="list-inline">
                                    <li class="list-inline-item text-{{ ($patient->ppcr_color === 'red')? 'danger' : 'secondary'}}">
                                        <i class="fa-solid fa-square{{ ($patient->ppcr_color === 'red')? '-check' : ''}}"></i> Red</span>
                                    </li>
                                    <li class="list-inline-item text-{{ ($patient->ppcr_color === 'yellow')? 'warning' : 'secondary'}}">
                                        <i class="fa-solid fa-square{{ ($patient->ppcr_color === 'yellow')? '-check' : ''}}"></i> Yellow</span>
                                    </li>
                                    <li class="list-inline-item text-{{ ($patient->ppcr_color === 'green')? 'success' : 'secondary'}}">
                                        <i class="fa-solid fa-square{{ ($patient->ppcr_color === 'green')? '-check' : ''}}"></i> Green</span>
                                    </li>
                                    <li class="list-inline-item text-{{ ($patient->ppcr_color === 'black')? 'dark' : 'secondary'}}">
                                        <i class="fa-solid fa-square{{ ($patient->ppcr_color === 'black')? '-check' : ''}}"></i> Black</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="fw-semibold mb-3">Incident Information
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('incident.edit', $incident->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                            </h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Incident ID: </span>{{ $incident->id }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Nature of call: </span>{{ $incident->nature_of_call }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Incident Type: </span>{{ $incident->incident_type }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Status: </span>
                                            @isset($incident->response_team_id)
                                                <span class="text-success fw-semibold">Assigned</span>
                                            @else
                                                <span class="text-danger fw-semibold">Unassigned</span>
                                            @endisset 
                                        </li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Reported at: </span>{{ $incident->created_at->diffForHumans() }}</li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">No of person involved/injured: </span>{{ $incident->no_of_persons_involved }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Caller: </span>{{ $incident->caller_first_name }} {{ $incident->caller_last_name }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Contact: </span>{{ $incident->caller_number }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary"></span> </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Area Type: </span>{{ $incident->area_type }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Location: </span>{{ $incident->incident_location }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary"></span> </li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="fw-semibold text-secondary mb-3">Timings</span>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr class="text-secondary fw-semibold">
                                                <td>Dispatch</td>
                                                <td>En Route</td>
                                                <td>Arrival</td>
                                                <td>Depart</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td><small>{{$incident->timing_dispatch }}</small></td>
                                                <td><small>{{$incident->timing_enroute }}</small></td>
                                                <td><small>{{$incident->timing_arrival }}</small></td>
                                                <td><small>{{$incident->timing_depart }}</small></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 text-center my-auto">
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Update Incident Timings
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="fw-semibold mb-3">Patient Information
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Patient Name: </span> {{$patient->patient_first_name}} {{$patient->patient_last_name}}</li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Sex: </span> {{$patient->sex}} </li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Age: </span> {{$patient->age}} </li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary"></span> </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Birthday: </span>
                                            @isset($patient->birthday)
                                                {{ \Carbon\Carbon::parse($patient->birthday)->format('M d, Y') }}
                                            @else
                                                <small class="fst-italic">(Not set)</small>
                                            @endisset
                                        </li>
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Contact: </span> {{$patient->contact_no}}</li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="fw-semibold text-secondary">Address: </span><span>{{$patient->address}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            @isset($patient_assessment)
                                <h5 class="fw-semibold mb-3">Patient Assessment
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('assessment.edit', $patient_assessment->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Chief Complaint: </span>
                                                <p>{{ $patient_assessment->chief_complaint }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">History: </span>
                                                <p>{{ $patient_assessment->history }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-capitalize"><span class="fw-semibold text-secondary">Primary: </span>{{$patient_assessment->primary1}}</span>
                                        <ul class="">
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Airway: </span><span>{{$patient_assessment->airway}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Breathing: </span><span>{{$patient_assessment->breathing}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Circulation</span>
                                                <ul>
                                                    <li class="text-capitalize"><span class="fw-semibold text-secondary">Pulse: </span><span>{{$patient_assessment->pulse}}</span></li>
                                                    <li class="text-capitalize"><span class="fw-semibold text-secondary">Skin Appearance: </span><span>{{$patient_assessment->skin_appearance}}</span></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-capitalize fw-semibold text-secondary mb-2">Glasgow Coma Scale: </span>
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-secondary">Verbal</th>
                                                    <th scope="col" class="text-secondary">Motor</th>
                                                    <th scope="col" class="text-secondary">Eye</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fs-6 {{$patient_assessment->gcs_eye == 4 ? 'fw-semibold text-danger opacity-75' : ''}}"><small class=""> 4 Spontaneous</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_verbal == 5 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 5 Oriented</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_motor == 6 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 6 Obeys</small></td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-6 {{$patient_assessment->gcs_eye == 3 ? 'fw-semibold text-danger opacity-75' : ''}}"><small class="xxx"> 3 Voice</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_verbal == 4 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 4 Confused</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_motor == 5 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 5 Localizes</small></td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-6 {{$patient_assessment->gcs_eye == 2 ? 'fw-semibold text-danger opacity-75' : ''}}"><small class="xxx"> 2 Pain</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_verbal == 3 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 3 Inappropriate</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_motor == 4 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 4 Withdraw</small></td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-6 {{$patient_assessment->gcs_eye == 1 ? 'fw-semibold text-danger opacity-75' : ''}}"><small class="xxx"> 1 None</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_verbal == 2 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 2 Garbled</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_motor == 3 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 3 Flexion</small></td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-6"><small class="xxx"> </small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_verbal == 1 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 1 None</small></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_motor == 2 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 2 Extension</small></td>
                                                </tr>
                                                <tr>
                                                    <td class="fs-6" colspan="2"><span class="text-secondary fw-semibold"> Total GCS: {{$patient_assessment->gcs_total}}</span></td>
                                                    <td class="fs-6 {{$patient_assessment->gcs_motor == 1 ? 'fw-semibold text-danger opacity-75' : ''}}"><small> 1 None</small></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-capitalize fw-semibold text-secondary">Secondary: </span>
                                        <ul class="">
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold text-secondary">Signs & Symptoms: </span><span>{{$patient_assessment->signs_symptoms}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold text-secondary">Allergies: </span><span>{{$patient_assessment->allergies}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold text-secondary">Medications: </span><span>{{$patient_assessment->medications}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold text-secondary">Past History: </span><span>{{$patient_assessment->past_history}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold text-secondary">Last Intake: </span><span>{{$patient_assessment->last_intake}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold text-secondary">Event Prior: </span><span>{{$patient_assessment->event_prior}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-capitalize fw-semibold text-secondary">Vital Signs: </span>
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr class="text-secondary">
                                                    <th scope="col">Time</th>
                                                    <th scope="col">B/P</th>
                                                    <th scope="col">HR</th>
                                                    <th scope="col">RR</th>
                                                    <th scope="col">O2 Sat</th>
                                                    <th scope="col">Glucose</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-secondary">
                                                    <td><small>{{$patient_assessment->vital_time1}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_bp1}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_hr1}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_rr1}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_o2sat1}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_glucose1}}</small></td>
                                                </tr>
                                                <tr class="text-secondary">
                                                    <td><small>{{$patient_assessment->vital_time2}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_bp2}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_hr2}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_rr2}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_o2sat2}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_glucose2}}</small></td>
                                                </tr>
                                                <tr class="text-secondary">
                                                    <td><small>{{$patient_assessment->vital_time3}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_bp3}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_hr3}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_rr3}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_o2sat3}}</small></td>
                                                    <td><small>{{$patient_assessment->vital_glucose3}}</small></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <h5 class="fw-semibold mb-3">Patient Assessment</h5>
                                <div class="col-md-12 text-center mb-3">
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                        <a class="btn btn-primary btn-sm" href=" {{route('assessment.create', $patient->id)}} ">Create Patient Assessment</a>
                                    @else
                                        <small class="fst-italic text-secondary">Nothing to show</small>
                                    @endif
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                        @isset($patient_observation)
                            <h5 class="fw-semibold mb-3">Patient Observation
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('observation.edit', $patient_observation->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <span class="text-capitalize fw-semibold text-secondary">Observations: </span>
                                                <ul class="list-group list-group-flush custom-list">
                                                    <li>{{$patient_observation->observations}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <ul class="list-group list-group-flush custom-list">
                                                    <li class="text-capitalize ms-3"><i class="fa-solid fa-square{{ ($patient_observation->wound === 1)? '-check text-success' : ' text-secondary opacity-50'}}"></i> w wound</li>
                                                    <li class="text-capitalize ms-3"><i class="fa-solid fa-square{{ ($patient_observation->dislocation === 1)? '-check text-success' : ' text-secondary opacity-50'}}"></i> d dislocation</li>
                                                    <li class="text-capitalize ms-3"><i class="fa-solid fa-square{{ ($patient_observation->fracture === 1)? '-check text-success' : ' text-secondary opacity-50'}}"></i> f fracture</li>
                                                    <li class="text-capitalize ms-3"><i class="fa-solid fa-square{{ ($patient_observation->numbness === 1)? '-check text-success' : ' text-secondary opacity-50'}}"></i> n numbness</li>
                                                    <li class="text-capitalize ms-3"><i class="fa-solid fa-square{{ ($patient_observation->rash === 1)? '-check text-success' : ' text-secondary opacity-50'}}"></i> r rash</li>
                                                    <li class="text-capitalize ms-3"><i class="fa-solid fa-square{{ ($patient_observation->swelling === 1)? '-check text-success' : ' text-secondary opacity-50'}}"></i> s swelling</li>
                                                    @if ($patient_observation->burn_calculation > 0)
                                                        <li class="text-capitalize ms-3"><i class="fa-solid fa-square-check text-success"></i> 
                                                            b burn {{$patient_observation->burn_calculation}}<span>%</span>
                                                        </li>
                                                    @else
                                                        <li class="text-capitalize ms-3"><i class="fa-solid fa-square text-secondary opacity-50"></i>
                                                            b burn
                                                        </li>
                                                    @endif
                                                    <li class="text-capitalize mt-3 "><span class="fw-semibold text-secondary">Burn Classification: </span>{{$patient_observation->burn_classification}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-12 text-center">
                                                @if ($patient_observation->age_group === "adult")
                                                    <img src="{{ asset('/images/rule-9-adult.jpg') }}" alt="Rule 9 Adult" style="height: auto; width: 75%; object-fit: contain">
                                                @elseif ($patient_observation->age_group === "pedia")
                                                    <img src="{{ asset('/images/rule-9-pedia.png') }}" alt="Rule 9 Pedia" style="height: auto; width: 75%; object-fit: contain">
                                                @else
                                                    <small class="">Error: Update patient observation</small>
                                                @endif
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            @else
                                <h5 class="fw-semibold mb-3">Patient Observation</h5>
                                <div class="col-md-12 text-center mb-3">
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                        <a class="btn btn-primary btn-sm" href=" {{route('observation.create', $patient->id)}} ">Create Patient Observation</a>
                                    @else
                                        <small class="fst-italic text-secondary">Nothing to show</small>
                                    @endif
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            @isset($patient_management)
                                <h5 class="fw-semibold mb-3">Patient Management
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                        <a href="{{ route('management.edit', $patient_management->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                    @endif
                                </h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Airway & Breathing: </span><span>{{$patient_management->airway_breathing}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Circulation: </span><span>{{$patient_management->circulation}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Wound/Burn Care: </span><span>{{$patient_management->wound_burn_care}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Immobilization: </span><span>{{$patient_management->immobilization}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Others: </span><span>{{$patient_management->others1}}</span></li>
                                            <li class="text-capitalize"><span>{{$patient_management->others2}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Receiving Facility: </span>
                                                <span>{{$patient_management->receiving_facility}}</span>
                                            </li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Name of Facility: </span>
                                                <span>{{$patient_management->user_hospital->hospital_abbreviation . ' - '}}{{$patient_management->user_hospital->hospital_name}}</span>
                                            </li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Location: </span>
                                                <span>{{$patient_management->user_hospital->hospital_address}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li><span class="fw-semibold text-secondary">Contact: </span> <span>{{$patient_management->user_hospital->email}}</span>
                                                <ul class="custom-list custom-management-contact">
                                                    <li>{{$patient_management->user_hospital->contact_1}}</li>
                                                    <li>{{$patient_management->user_hospital->contact_2}}</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                    <span class="fw-semibold text-secondary">Timings: </span>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr class="text-secondary fw-semibold">
                                                <td>Arrival</td>
                                                <td>Handover</td>
                                                <td>Clear</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-secondary">
                                                <td><small>{{$patient_management->timings_arrival}}</small></td>
                                                <td><small>{{$patient_management->timings_handover}}</small></td>
                                                <td><small>{{$patient_management->timings_clear}}</small></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Narrative: </span>
                                                <span>{{$patient_management->narrative}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Receiving Provider: </span>
                                                <span>{{$patient_management->receiving_provider}}</span>
                                            </li>
                                            <li class="text-capitalize"><span class="fw-semibold text-secondary">Position: </span>
                                                <span>{{$patient_management->provider_position}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <h5 class="fw-semibold mb-3">Patient Management</h5>
                                <div class="col-md-12 text-center mb-3">
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                        <a class="btn btn-primary btn-sm" href=" {{route('management.create', $patient->id)}} ">Create Patient Management</a>
                                    @else
                                        <small class="fst-italic text-secondary">Nothing to show</small>
                                    @endif
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                            <h5 class="fw-semibold mb-3">Patient Provider</h5>
                                <ul class="list-group list-group-flush text-start custom-list">
                                    <li class="text-capitalize"><span class="fw-semibold text-secondary">Ambulance: </span> {{$incident->response_team->user_ambulance->plate_no}}</li>
                                    @foreach ($medics as $medic)
                                        <li class="text-capitalize"><span class="fw-semibold text-secondary">Medic: </span>{{ $medic->personnel_first_name }} {{ $medic->personnel_last_name }}</li>
                                    @endforeach
                                    <li class="text-capitalize"><span class="fw-semibold text-secondary"></span> </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                            <h5 class="fw-semibold mb-3">Patient Progress
                                @if ($patient->completed_at)
                                    <a href="{{ route('pcr.print', $patient->id) }}" class="btn btn-outline-primary btn-sm custom-rounded-btn text-decoration-none float-end"><small>Print/Download</small></a>
                                @endif
                            </h5>
                                <ul class="row list-group list-group-flush text-start custom-list">
                                    @if ($patient->completed_at)
                                        <span class="col-10 mx-auto btn btn-outline-success btn-sm rounded-pill">Completed {{ \Carbon\Carbon::parse($patient->completed_at)->diffForHumans() }}</span>
                                    @else
                                        @if ($patient_assessment && $patient_management)
                                            @if ($patient_management->timings_handover && $patient_management->timings_clear)
                                                <li class="col-10 mx-auto mb-1">
                                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                                        <form method="POST" action="{{route('patient.complete',  $patient->id)}}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="d-grid">
                                                                <button type="submit" class="btn btn-success btn-sm rounded-pill fw-semibold">
                                                                    Tag PCR as Complete
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <li class="col-10 mx-auto btn btn-warning btn-sm rounded-pill mb-1">To be cleared by facility</li>
                                                    @endif
                                                    
                                                </li>
                                            @else
                                                <li class="col-10 mx-auto btn btn-warning btn-sm rounded-pill mb-1">Update Patient Management Timings</li>
                                                <li class="col-10 mx-auto btn btn-warning btn-sm rounded-pill mb-1">Complete PCR to Print/Download</li>
                                            @endif
                                            
                                        @else
                                            @if (!$patient_assessment)
                                                <li class="col-10 mx-auto btn btn-warning btn-sm rounded-pill mb-1">Add Patient Assessment</li>
                                            @endif
                                            @if (!$patient_management)
                                                <li class="col-10 mx-auto btn btn-warning btn-sm rounded-pill mb-1">Add Patient Management</li>
                                            @endif
                                            <li class="col-10 mx-auto btn btn-warning btn-sm rounded-pill mb-1">Complete PCR to Print/Download</li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Incident Timings</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="POST" action="{{ route('incident.timings', $patient->id) }}">
                    <div class="modal-body">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <td>Dispatch</td>
                                                <td>En Route</td>
                                                <td>Arrival</td>
                                                <td>Depart</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="input-group input-group-sm"><input type="text" class="form-control" name="timing_dispatch" value="{{ old('timing_dispatch') ?? $incident->timing_dispatch }}"></div></td>
                                                <td><div class="input-group input-group-sm"><input type="text" class="form-control" name="timing_enroute" value="{{ old('timing_enroute') ?? $incident->timing_enroute }}"></div></td>
                                                <td><div class="input-group input-group-sm"><input type="text" class="form-control" name="timing_arrival" value="{{ old('timing_arrival') ?? $incident->timing_arrival }}"></div></td>
                                                <td><div class="input-group input-group-sm"><input type="text" class="form-control" name="timing_depart" value="{{ old('timing_depart') ?? $incident->timing_depart }}"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection