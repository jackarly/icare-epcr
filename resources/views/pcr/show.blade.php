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
                                <!-- Show update button if user_type == Ambulance, Comcen, or Admin -->
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
                                <!-- Show update button if user_type == Ambulance, Comcen, or Admin -->
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('incident.edit', $incident->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                            </h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">Incident ID: </span>{{ $incident->id }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Nature of call: </span>{{ $incident->nature_of_call }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Incident Type: </span>{{ $incident->incident_type }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Status: </span>

                                            <!-- Check if incident is assigned or not -->
                                            @isset($incident->response_team_id)
                                                @if ($patient->completed_at)
                                                    <span class="text-success fw-semibold">Completed</span>
                                                @elseif ($patient->patient_refused_at)
                                                    <span class="text-danger fw-semibold">Patient refused transport</span>
                                                @elseif ($patient->hospital_refused_at)
                                                    <span class="text-danger fw-semibold">Refused by hospital</span>
                                                @else
                                                    <span class="text-success fw-semibold">Assigned</span>
                                                @endif
                                            @else
                                                <span class="text-danger fw-semibold">Unassigned</span>
                                            @endisset 
                                        </li>
                                        <li class=""><span class="fw-semibold">Reported </span>{{ $incident->created_at->diffForHumans() }}</li>
                                        <li class="text-capitalize">{{ $incident->created_at->format('M d, Y g:i:s A') }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">No of person involved/injured: </span>{{ $incident->no_of_persons_involved }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Caller: </span>{{ $incident->caller_first_name }} {{ $incident->caller_last_name }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Contact: </span>{{ $incident->caller_number }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold"></span> </li>
                                        <li class="text-capitalize"><span class="fw-semibold">Area Type: </span>{{ $incident->area_type }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Location: </span>{{ $incident->incident_location }}</li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-10 col-lg-6 mx-auto">
                                    <span class="fw-semibold mb-3">Timings</span>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr class="text-secondary fw-semibold">
                                                <td style="width:25%">Dispatch</td>
                                                <td style="width:25%">En Route</td>
                                                <td style="width:25%">Arrival</td>
                                                <td style="width:25%">Depart</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <td><small>{{$incident->timing_dispatch }}</small></td>
                                                <td>
                                                    <!-- Check if enroute is set -->
                                                    @if ($incident->timing_enroute)
                                                        <small>{{$incident->timing_enroute }}</small>
                                                    @else
                                                        <!-- Show add time is user_type == Ambulance or Admin -->
                                                        @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                                            <form method="POST" action="{{route('incident.enroute',  $patient->id)}}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="d-grid">
                                                                    <button type="submit" class="btn btn-primary btn-sm custom-rounded-btn">
                                                                        Add Time
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <small class="text-secondary fst-italic">(not set)</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Check if arrival is set -->
                                                    @if ($incident->timing_arrival)
                                                        <small>{{$incident->timing_arrival }}</small>
                                                    @else
                                                        <!-- Check if enroute is set -->
                                                        @if ($incident->timing_enroute)
                                                            <!-- Show add time is user_type == Ambulance or Admin -->
                                                            @if ((auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                                                <form method="POST" action="{{route('incident.arrival',  $patient->id)}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="d-grid">
                                                                        <button type="submit" class="btn btn-primary btn-sm custom-rounded-btn">
                                                                            Add Time
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <small class="text-secondary fst-italic">(not set)</small>
                                                            @endif
                                                        @else
                                                            <small class="text-secondary fst-italic">(not set)</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Check if depart is set -->
                                                    @if ($incident->timing_depart)
                                                        <small>{{$incident->timing_depart }}</small>
                                                    @else
                                                        <!-- Check if arrival is set -->
                                                        @if ($incident->timing_arrival)
                                                            <!-- Show add time is user_type == Ambulance or Admin -->
                                                            @if ((auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                                                <form method="POST" action="{{route('incident.depart',  $patient->id)}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="d-grid">
                                                                        <button type="submit" class="btn btn-primary btn-sm custom-rounded-btn">
                                                                            Add Time
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <small class="text-secondary fst-italic">(not set)</small>
                                                            @endif
                                                        @else
                                                            <small class="text-secondary fst-italic">(not set)</small>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="fw-semibold mb-3">Patient Information
                                <!-- Show update button if user_type == Ambulance, Comcen, or Admin -->
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize">
                                            <span class="fw-semibold">Patient Name: </span> 
                                            @if($patient->patient_first_name || $patient->patient_mid_name || $patient->patient_last_name)
                                                {{$patient->patient_first_name}} {{$patient->patient_mid_name}} {{$patient->patient_last_name}}
                                            @else
                                                <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                            @endif
                                        </li>
                                        <li class="text-capitalize">
                                            <span class="fw-semibold">Sex: </span> 
                                            @if($patient->sex)
                                                {{$patient->sex}}
                                            @else
                                                <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                            @endif
                                        </li>
                                        <li class="text-capitalize">
                                            <span class="fw-semibold">Age: </span> 
                                            @if($patient->age)
                                                {{$patient->age}} 
                                            @else
                                                <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">Birthday: </span>
                                            @isset($patient->birthday)
                                                {{ \Carbon\Carbon::parse($patient->birthday)->format('M d, Y') }}
                                            @else
                                                <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                            @endisset
                                        </li>
                                        <li class="text-capitalize">
                                            <span class="fw-semibold">Contact: </span>
                                            @if($patient->contact_no)
                                                {{$patient->contact_no}} 
                                            @else
                                                <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                            @endif
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="fw-semibold">Address: </span>
                                    @if($patient->address)
                                        <span>{{$patient->address}}</span> 
                                    @else
                                        <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <!-- Check is patient assessment is not null -->
                            @isset($patient_assessment)
                                <h5 class="fw-semibold mb-3">Patient Assessment
                                <!-- Show update button if user_type == Ambulance, Comcen, or Admin -->
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('assessment.edit', $patient_assessment->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold">Chief Complaint: </span>
                                                <p>{{ $patient_assessment->chief_complaint }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold">History: </span>
                                                <p>{{ $patient_assessment->history }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-capitalize"><span class="fw-semibold">Primary: </span>{{$patient_assessment->primary1}}</span>
                                        <ul class="">
                                            <li class="text-capitalize"><span class="fw-semibold">Airway: </span><span>{{$patient_assessment->airway}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold">Breathing: </span><span>{{$patient_assessment->breathing}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold">Circulation</span>
                                                <ul>
                                                    <li class="text-capitalize"><span class="fw-semibold">Pulse: </span><span>{{$patient_assessment->pulse}}</span></li>
                                                    <li class="text-capitalize"><span class="fw-semibold">Skin Appearance: </span><span>{{$patient_assessment->skin_appearance}}</span></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-capitalize fw-semibold mb-2">Glasgow Coma Scale: </span>
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-secondary" style="width:33%">Verbal</th>
                                                    <th scope="col" class="text-secondary" style="width:33%">Motor</th>
                                                    <th scope="col" class="text-secondary" style="width:33%">Eye</th>
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
                                        <span class="text-capitalize fw-semibold">Secondary: </span>
                                        <ul class="">
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold">Signs & Symptoms: </span><span>{{$patient_assessment->signs_symptoms}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold">Allergies: </span><span>{{$patient_assessment->allergies}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold">Medications: </span><span>{{$patient_assessment->medications}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold">Past History: </span><span>{{$patient_assessment->past_history}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold">Last Intake: </span><span>{{$patient_assessment->last_intake}}</span></li>
                                            <li class="text-capitalize mb-3 mb-md-2"><span class="fw-semibold">Event Prior: </span><span>{{$patient_assessment->event_prior}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-capitalize fw-semibold">Vital Signs: </span>
                                        @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                            <a href="{{ route('assessment.vitals.create', $patient_assessment->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                        @endif
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr class="text-secondary">
                                                    <th scope="col" style="width:16%">Time</th>
                                                    <th scope="col" style="width:16%">B/P</th>
                                                    <th scope="col" style="width:16%">HR</th>
                                                    <th scope="col" style="width:16%">RR</th>
                                                    <th scope="col" style="width:16%">O2 Sat</th>
                                                    <th scope="col" style="width:16%">Glucose</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-secondary">
                                                    <td style="width:16%">
                                                        <!-- Set default value to preserve cell height -->
                                                        @if ($patient_assessment->vital_time1)
                                                            <small>{{$patient_assessment->vital_time1}}</small>
                                                        @else
                                                            <small class="fst-italic text-light">(not set)</small>
                                                        @endif
                                                    </td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_bp1}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_hr1}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_rr1}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_o2sat1}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_glucose1}}</small></td>
                                                </tr>
                                                <tr class="text-secondary">
                                                    <td style="width:16%">
                                                        <!-- Set default value to preserve cell height -->
                                                        @if ($patient_assessment->vital_time2)
                                                            <small>{{$patient_assessment->vital_time2}}</small>
                                                        @else
                                                            <small class="fst-italic text-light">(not set)</small>
                                                        @endif
                                                    </td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_bp2}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_hr2}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_rr2}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_o2sat2}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_glucose2}}</small></td>
                                                </tr>
                                                <tr class="text-secondary">
                                                    <td style="width:16%">
                                                        <!-- Set default value to preserve cell height -->
                                                        @if ($patient_assessment->vital_time3)
                                                        <small>{{$patient_assessment->vital_time3}}</small>
                                                        @else
                                                            <small class="fst-italic text-light">(not set)</small>
                                                        @endif
                                                    </td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_bp3}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_hr3}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_rr3}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_o2sat3}}</small></td>
                                                    <td style="width:16%"><small>{{$patient_assessment->vital_glucose3}}</small></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <h5 class="fw-semibold mb-3">Patient Assessment</h5>
                                <div class="col-md-12 text-center mb-3">
                                    <!-- Show create button if user_type == Ambulance or Admin -->
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                        <a class="btn btn-primary btn-sm" href=" {{route('assessment.create', $patient->id)}}">Create Patient Assessment</a>
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
                                <!-- Show update button if user_type == Ambulance, Comcen, or Admin -->
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('observation.edit', $patient_observation->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <span class="text-capitalize fw-semibold">Observations: </span>
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
                                                    <li class="text-capitalize mt-3 "><span class="fw-semibold">Burn Classification: </span>{{$patient_observation->burn_classification}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-12 text-center">
                                                <!-- Show/hide chart based on age_group -->
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
                                    <!-- Show create button if user_type == Ambulance or Admin -->
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
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
                                    <!-- Show update button if user_type == Ambulance, Comcen, or Admin -->
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                        <a href="{{ route('management.edit', $patient_management->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                    @endif
                                </h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold">Airway & Breathing: </span><span>{{$patient_management->airway_breathing}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold">Circulation: </span><span>{{$patient_management->circulation}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold">Wound/Burn Care: </span><span>{{$patient_management->wound_burn_care}}</span></li>
                                            <li class="text-capitalize"><span class="fw-semibold">Immobilization: </span><span>{{$patient_management->immobilization}}</span></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">Others: </span><span>{{$patient_management->others1}}</span></li>
                                            <li class="text-capitalize"><span>{{$patient_management->others2}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold">Receiving Facility: </span>
                                                <span>{{$patient_management->receiving_facility}}</span>
                                            </li>
                                            <li class="text-capitalize"><span class="fw-semibold">Name of Facility: </span>
                                                <span>{{$patient_management->user_hospital->hospital_abbreviation . ' - '}}{{$patient_management->user_hospital->hospital_name}}</span>
                                            </li>
                                            <li class="text-capitalize"><span class="fw-semibold">Location: </span>
                                                <span>{{$patient_management->user_hospital->hospital_address}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li><span class="fw-semibold">Contact: </span> <span>{{$patient_management->user_hospital->email}}</span>
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
                                    <span class="fw-semibold">Timings: </span>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr class="text-secondary fw-semibold">
                                                <td style="width:33%">Arrival</td>
                                                <td style="width:33%">Handover</td>
                                                <td style="width:33%">Clear</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-secondary text-center">
                                                <td>
                                                    <!-- Check if arrival is set -->
                                                    @if ($patient_management->timings_arrival)
                                                        <small>{{$patient_management->timings_arrival}}</small>
                                                    @else
                                                        <!-- Check if incident depart is set -->
                                                        @if ($incident->timing_depart)
                                                            <!-- Show add time if user_type == Ambulance or Admin -->
                                                            @if ((auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                                                <form method="POST" action="{{route('management.arrival',  $patient->id)}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="d-grid">
                                                                        <button type="submit" class="btn btn-primary btn-sm custom-rounded-btn">
                                                                            Add Time
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <small class="text-secondary fst-italic">(not set)</small>
                                                            @endif
                                                        @else
                                                            <small class="text-secondary fst-italic lh-1">(set incident depart)</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Check if handover is set -->
                                                    @if ($patient_management->timings_handover)
                                                        <small>{{$patient_management->timings_handover}}</small>
                                                    @else
                                                        <!-- Check if arrival is set -->
                                                        @if ($patient_management->timings_arrival)
                                                            <!-- Show add time if user_type == Ambulance or Admin -->
                                                            @if ((auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                                                @if ($patient_assessment && $patient_observation)
                                                                    <form method="POST" action="{{route('management.handover',  $patient->id)}}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="d-grid">
                                                                            <button type="submit" class="btn btn-primary btn-sm custom-rounded-btn">
                                                                                Add Time
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    <small class="text-secondary fst-italic lh-1">(see patient progress)</small>
                                                                @endif
                                                            @else
                                                                <small class="text-secondary fst-italic">(not set)</small>
                                                            @endif
                                                        @else
                                                            <small class="text-secondary fst-italic">(not set)</small>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Check if clear is set -->
                                                    @if ($patient_management->timings_clear)
                                                        <small>{{$patient_management->timings_clear}}</small>
                                                    @else
                                                        <!-- Show add time if user_type == Hospital or Admin -->
                                                        @if ((auth()->user()->user_type == 'hospital') || (auth()->user()->user_type == 'admin'))
                                                            @if ($patient_management->timings_handover)
                                                                <form method="POST" action="{{route('management.clear',  $patient->id)}}">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="d-grid">
                                                                        <button type="submit" class="btn btn-primary btn-sm custom-rounded-btn">
                                                                            Add Time
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <small class="text-secondary fst-italic">(not set)</small>
                                                            @endif
                                                        @elseif (auth()->user()->user_type == 'ambulance')   
                                                            <small class="btn btn-outline-danger btn-sm custom-rounded-btn lh-1">to be cleared by facility</small>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li class="text-capitalize"><span class="fw-semibold">Narrative: </span>
                                                <span>{{$patient_management->narrative}}</span>
                                            </li>
                                            <li class="text-capitalize"><span class="fw-semibold">Receiving Provider: </span>
                                                <span>{{$patient_management->receiving_provider}}</span>
                                            </li>
                                            <li class="text-capitalize"><span class="fw-semibold">Position: </span>
                                                <span>{{$patient_management->provider_position}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    
                                    <span class="text-capitalize fw-semibold mb-2">Refusal:</span>
                                    <div class="col-md-6 text-center">
                                        @if ($patient->patient_refused_at)
                                            <a href="{{ route('refusal.create', $patient->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                            <ul class="list-group list-group-flush custom-list text-start">
                                                <li class="text-capitalize"><span class="fw-semibold text-decoration-underline">Patient Refused Transport </span></li>
                                                <li class="text-capitalize"><span class="fw-semibold">Witness: </span><span>{{$patient->patient_refusal_witness}}</span></li>
                                                <li class="text-capitalize"><span class="fw-semibold">Date: </span><span>{{Carbon\Carbon::parse($patient->patient_refused_at)->format('m/d/Y')}}</span></li>
                                                <li class=""><span class="fw-semibold">Time: </span><span>{{Carbon\Carbon::parse($patient->patient_refused_at)->format('h:i:s a')}}</span></li>
                                            </ul>
                                        @else
                                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('refusal.create', $patient->id) }}">Create Patient Refusal</a>
                                        @endif
                                        
                                    </div>
                                    <div class="col-md-6 text-center">
                                        @if ($patient->hospital_refused_at)
                                            @foreach ( $patient_refusals as $refusal)
                                                <a href="{{ route('refusal.hospital.edit', $refusal->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                                <ul class="list-group list-group-flush custom-list text-start">
                                                    <li class="text-capitalize"><span class="fw-semibold text-decoration-underline">Hospital Refused to Receive Patient </span></li>
                                                    <li class=""><span class="fw-semibold">Hospital: </span><span>{{$refusal->hospital_reasons}}</span></li>
                                                    <li class=""><span class="fw-semibold">Due to the following reasons: </span><span>{{$refusal->hospital_reasons}}</span></li>
                                                    <li class=""><span class="fw-semibold">Nurse/Physician on duty: </span><span>{{$refusal->hospital_nurse_doctor}}</span></li>
                                                </ul>
                                            @endforeach
                                            
                                        @else
                                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('refusal.hospital.create', $patient->id) }}">Create Hospital Refusal</a>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <h5 class="fw-semibold mb-3">Patient Management</h5>
                                <div class="col-md-12 text-center">
                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
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
                        <div class="col-md-6 mb-3">
                                <h5 class="fw-semibold">Patient Provider</h5>
                                <ul class="list-group list-group-flush text-start custom-list">
                                    <li class="text-capitalize"><span class="fw-semibold">Ambulance: </span> {{$incident->response_team->user_ambulance->plate_no}}</li>
                                    @foreach ($medics as $medic)
                                        <li class="text-capitalize"><span class="fw-semibold">{{ $medic->personnel_type }}: </span>{{ $medic->personnel_first_name }} {{ $medic->personnel_last_name }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-semibold">Patient Progress</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="list-group custom-list ps-1">
                                            <li class="">
                                                <i class="fa-solid fa-square{{ ($patient_assessment)? '-check text-success' : ' text-secondary'}}"></i>
                                                <span class="{{ ($patient_assessment)? 'fw-semibold text-success' : ' text-secondary'}}">Patient Assessment</span>
                                            </li>
                                            <li class="">
                                                <i class="fa-solid fa-square{{ ($patient_observation)? '-check text-success' : ' text-secondary'}}"></i>
                                                <span class="{{ ($patient_observation)? 'fw-semibold text-success' : ' text-secondary'}}">Patient Observation</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="list-group custom-list ps-1">
                                            <li class="">
                                                <i class="fa-solid fa-square{{ ($patient_management)? '-check text-success' : ' text-secondary'}}"></i>
                                                <span class="{{ ($patient_management)? 'fw-semibold text-success' : ' text-secondary'}}">Patient Management</span>
                                                <!-- Check if patient management is set -->
                                                <!-- Set checkbox style and color -->
                                                @if ($patient_management)
                                                    @if (($patient->patient_refused_at) || ($patient->hospital_refused_at) )
                                                        @if ($patient->patient_refused_at)
                                                            <li class="fs-7 ps-3">
                                                                <i class="fa-regular fa-square-check text-danger"></i>
                                                                <span class="fw-semibold text-danger">Patient refused transport</span>
                                                            </li>
                                                        @endif

                                                        @if ($patient->hospital_refused_at)
                                                            <li class="fs-7 ps-3">
                                                                <i class="fa-regular fa-square-check text-danger"></i>
                                                                <span class="fw-semibold text-danger">Refused by hospital</span>
                                                            </li>
                                                        @endif
                                                    @else
                                                        @if ($patient_management->timings_handover)
                                                            <li class="fs-7 ps-3">
                                                                <i class="fa-regular fa-square-check text-success"></i>
                                                                <span class="fw-semibold text-success">Handover to facility</span>
                                                            </li>
                                                        @else
                                                            <li class="fs-7 ps-3">
                                                                <i class="fa-regular fa-square text-secondary"></i>
                                                                <span class="text-secondary">Handover to facility</span>
                                                            </li>
                                                        @endif
                                                        @if ($patient_management->timings_clear)
                                                            <li class="fs-7 ps-3">
                                                                <i class="fa-regular fa-square-check text-success"></i>
                                                                <span class="fw-semibold text-success">Cleared by facility</span>
                                                            </li>
                                                        @else
                                                            <li class="fs-7 ps-3">
                                                                <i class="fa-regular fa-square text-secondary"></i>
                                                                <span class="text-secondary">Cleared by facility</span>
                                                            </li>
                                                        @endif
                                                    @endif
                                                    
                                                @else
                                                    <li class="fs-7 ps-3">
                                                        <i class="fa-regular fa-square text-secondary"></i>
                                                        <span class="text-secondary">Handover to facility</span>
                                                    </li>
                                                    <li class="fs-7 ps-3">
                                                        <i class="fa-regular fa-square text-secondary"></i>
                                                        <span class="text-secondary">Cleared by facility</span>
                                                    </li>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <span class="d-grid mt-1">
                                    <!-- Show download/print button if patient is tagged as completed -->
                                    @if ($patient_assessment && $patient_management)
                                        @if ($patient->completed_at || $patient->patient_refused_at || $patient_refusals->count() > 0)
                                            <a href="{{ route('pcr.print', $patient->id) }}" class="btn btn-success btn-sm rounded-pill custom-rounded-btn text-decoration-none">Print/Download PCR</a>   
                                        @else
                                            <a href="" class="btn btn-outline-secondary btn-sm custom-rounded-btn text-decoration-none disabled">Complete PCR to print/download</a>  
                                        @endif
                                    @else
                                        <a href="" class="btn btn-outline-secondary btn-sm custom-rounded-btn text-decoration-none disabled">Complete PCR to print/download</a>  
                                    @endif

                                    
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection