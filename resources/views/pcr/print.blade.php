<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app-3ea8b221.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app-d4b42df8.js') }}"></script>
    <script src="https://kit.fontawesome.com/d6f1131e8e.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <div class="my-3" id="buttons">
        <div class="col text-center">
            <button class="btn btn-success" id="print">Print</button>
            <button class="btn btn-primary" id="download">Download</button>
        </div>
    </div>

    <div id="the-content">
        <page size="A4">
            <div class="custom-margin">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-3"><img src="{{ asset('storage/default/red-cross-ph.png') }}" class="mx-auto d-block thumbnail" alt="Red Cross" width="80px"></div>
                            <div class="col-9 mt-2">
                                <ul class="list-group list-group-flush custom-list fs-7 fw-semibold">
                                    <li class="lh-1"><span class="fw-semibold">PHILIPPINE RED CROSS<span class="text-decoration-underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span></li>
                                    <li class="small-address"><span>National Headquarters, Bonifacio Drive, Port Area, Manila, Philippines </span></li>
                                    <li class="text-decoration-underline"><span class="fs-8">PRE HOSPITAL PATIENT CARE REPORT (PPCR)</span></li>
                                    <li>
                                        <ul class="list-inline">
                                            <li class="list-inline-item text-danger">
                                                <i class="fa-regular fa-square{{ ($patient->ppcr_color === 'red')? '-check' : ''}}"></i> Red</span>
                                            </li>
                                            <li class="list-inline-item text-warning">
                                                <i class="fa-regular fa-square{{ ($patient->ppcr_color === 'yellow')? '-check' : ''}}"></i> Yellow</span>
                                            </li>
                                            <li class="list-inline-item text-success">
                                                <i class="fa-regular fa-square{{ ($patient->ppcr_color === 'green')? '-check' : ''}}"></i> Green</span>
                                            </li>
                                            <li class="list-inline-item text-dark">
                                                <i class="fa-regular fa-square{{ ($patient->ppcr_color === 'black')? '-check' : ''}}"></i> Black</span>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <p class="fs-7 fw-semibold text-light mb-0 custom-bg-incident">INCIDENT INFORMATION</p>
                            <ul class="list-inline fs-7 mb-0">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Nature of call</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->nature_of_call === 'emergency')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">emergency</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->nature_of_call === 'non-emergency')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">non-emergency</span>
                                </li>
                            </ul>
                            <ul class="list-inline fs-7 mb-2">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Type of Incident</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->incident_type === 'medical')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">medical</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->incident_type === 'trauma')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">trauma</span>
                                </li>
                            </ul>
                            <span class="fw-semibold fs-7">Timings</span>
                            <table class="table table-bordered table-sm border-primary fs-7 custom-table mb-0">
                                <thead>
                                    <tr class="custom-bg-incident text-light text-center">
                                        <th scope="col">Dispath</th>
                                        <th scope="col">En Route</th>
                                        <th scope="col">Arrival</th>
                                        <th scope="col">Depart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center custom-width-25">
                                        <td>
                                            @if ($incident->timing_dispatch)
                                                {{$incident->timing_dispatch}}
                                            @else
                                                <small class="fst-italic text-light">(not set)</small>
                                            @endif
                                        </td>
                                        <td>{{$incident->timing_enroute }}</td>
                                        <td>{{$incident->timing_arrival }}</td>
                                        <td>{{$incident->timing_depart }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <ul class="list-inline fs-7 mb-0">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Location:</span>
                                </li>
                                <li class="list-inline-item">
                                    <span class="text-capitalize">{{$incident->incident_location}}</span>
                                </li>
                            </ul>
                            <ul class="list-inline fs-7">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Area Type</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->area_type === 'residential')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">residential</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->area_type === 'commercial')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">commercial</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->area_type === 'recreation')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">recreation</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->area_type === 'road/street')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">road/street</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($incident->area_type === 'other')? '-check' : ''}}"></i>
                                    <span class="text-capitalize">other</span>
                                </li>
                                <li class="list-inline-item">
                                <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </li>
                            </ul>
                        </div>

                        <div class="row">
                            <p class="fs-7 fw-semibold text-light custom-bg-patient mb-0">PATIENT INFORMATION</p>
                            <ul class="list-group list-group-flush custom-list fs-7 custom-list-print">
                                <li class="">
                                    <span class="fw-semibold">Patient Name: </span>
                                    <span class="text-capitalize">{{$patient->patient_first_name}} {{$patient->patient_mid_name}} {{$patient->patient_last_name}}</span>
                                </li>
                                <li class="">
                                    <ul class="list-inline fs-7 mb-0">
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Age: </span><span class="text-capitalize">{{$patient->age}}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Sex: </span><span class="text-capitalize">{{$patient->sex}}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Contact No: </span><span class="text-capitalize">{{$patient->contact_no}}</span>
                                        </li>
                                    </ul>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">Address: </span>
                                    <span class="text-capitalize">{{$patient->address}}</span>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">Patient No: </span>
                                    <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </li>
                            </ul>
                        </div>

                        <div class="row mt-2">
                            <p class="fs-7 fw-semibold text-light custom-bg-assessment mb-0">ASSESSMENT</p>
                            <ul class="list-group list-group-flush custom-list fs-7 custom-list-print">
                                <li class="">
                                    <span class="fw-semibold">Chief Complaint: </span>
                                    <span class="text-capitalize">{{$patient_assessment->chief_complaint}}</span>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">History: </span>
                                    <span class="text-capitalize">{{$patient_assessment->history}}</span>
                                </li>
                                <li class="">
                                    <ul class="list-inline fs-7 mb-0">
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Primary</span></span>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="fa-regular fa-square{{ ($patient_assessment->primary1 === 'conscious')? '-check' : ''}}"></i>
                                            <span class="text-capitalize">conscious</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <i class="fa-regular fa-square{{ ($patient_assessment->primary1 === 'unconscious')? '-check' : ''}}"></i>
                                            <span class="text-capitalize">unconscious</span>
                                        </li>
                                    </ul>
                                    <ul class="list-group fs-7 custom-list-print" style="list-style-type: disc">
                                        <li class="">
                                            <ul class="list-inline fs-7 mb-0">
                                                <li class="list-inline-item">
                                                    <span class="fw-semibold">Airway</span></span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa-regular fa-square{{ ($patient_assessment->airway === 'clear')? '-check' : ''}}"></i>
                                                    <span class="text-capitalize">clear</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa-regular fa-square{{ ($patient_assessment->airway === 'partial')? '-check' : ''}}"></i>
                                                    <span class="text-capitalize">partial</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa-regular fa-square{{ ($patient_assessment->airway === 'obstructed')? '-check' : ''}}"></i>
                                                    <span class="text-capitalize">obstructed</span>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="">
                                            <ul class="list-inline fs-7 mb-0">
                                                <li class="list-inline-item">
                                                    <span class="fw-semibold">Breathing</span></span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa-regular fa-square{{ ($patient_assessment->breathing === 'normal')? '-check' : ''}}"></i>
                                                    <span class="text-capitalize">normal</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa-regular fa-square{{ ($patient_assessment->breathing === 'fast')? '-check' : ''}}"></i>
                                                    <span class="text-capitalize">fast</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa-regular fa-square{{ ($patient_assessment->breathing === 'slow')? '-check' : ''}}"></i>
                                                    <span class="text-capitalize">slow</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <i class="fa-regular fa-square{{ ($patient_assessment->breathing === 'absent')? '-check' : ''}}"></i>
                                                    <span class="text-capitalize">absent</span>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li class="">
                                            <ul class="list-inline fs-7 mb-0">
                                                <li class="list-inline-item">
                                                    <span class="fw-semibold">Circulation</span></span>
                                                </li>
                                                <li>
                                                    <ul class="fs-7 mb-0">
                                                        <li class="">
                                                            <ul class="list-inline fs-7 mb-0">
                                                                <li class="list-inline-item">
                                                                    <span class="fw-semibold">Pulse</span></span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->pulse === 'present')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">present</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->pulse === 'rapid')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">rapid</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->pulse === 'weak')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">weak</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->pulse === 'absent')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">absent</span>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="">
                                                            <ul class="list-inline fs-7 mb-0">
                                                                <li class="list-inline-item">
                                                                    <span class="fw-semibold">Skin Appearance</span></span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->skin_appearance === 'normal')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">normal</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->skin_appearance === 'pale')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">pale</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->skin_appearance === 'cyanosed')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">cyanosed</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->skin_appearance === 'warm')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">warm</span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa-regular fa-square{{ ($patient_assessment->skin_appearance === 'cold')? '-check' : ''}}"></i>
                                                                    <span class="text-capitalize">cold</span>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <span class="fw-semibold fs-7">Glasgow Coma Scale</span>
                            <table class="table table-bordered table-sm border-warning fs-8 custom-table mb-0">
                                <thead>
                                    <tr class="custom-bg-assessment text-light text-center">
                                        <th scope="col">Eye</th>
                                        <th scope="col">Verbal</th>
                                        <th scope="col">Motor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="custom-width-33 fs-8">
                                        <td class="{{$patient_assessment->gcs_eye == 4 ? 'fw-semibold' : ''}}">4 Spontaneous</td>
                                        <td class="{{$patient_assessment->gcs_verbal == 5 ? 'fw-semibold' : ''}}">5 Oriented</td>
                                        <td class="{{$patient_assessment->gcs_motor == 6 ? 'fw-semibold' : ''}}">6 Obeys</td>
                                    </tr>
                                    <tr class="custom-width-33 fs-8">
                                        <td class="{{$patient_assessment->gcs_eye == 3 ? 'fw-semibold' : ''}}">3 Voice</td>
                                        <td class="{{$patient_assessment->gcs_verbal == 4 ? 'fw-semibold' : ''}}">4 Confused</td>
                                        <td class="{{$patient_assessment->gcs_motor == 5 ? 'fw-semibold' : ''}}">5 Localizes</td>
                                    </tr>
                                    <tr class="custom-width-33 fs-8">
                                        <td class="{{$patient_assessment->gcs_eye == 2 ? 'fw-semibold' : ''}}">2 Pain</td>
                                        <td class="{{$patient_assessment->gcs_verbal == 3 ? 'fw-semibold' : ''}}">3 Inappropriate</td>
                                        <td class="{{$patient_assessment->gcs_motor == 4 ? 'fw-semibold' : ''}}">4 Withdraw</td>
                                    </tr>
                                    <tr class="custom-width-33 fs-8">
                                        <td class="{{$patient_assessment->gcs_eye == 1 ? 'fw-semibold' : ''}}">1 None</td>
                                        <td class="{{$patient_assessment->gcs_verbal == 2 ? 'fw-semibold' : ''}}">2 Garbled</td>
                                        <td class="{{$patient_assessment->gcs_motor == 3 ? 'fw-semibold' : ''}}">3 Flexion</td>
                                    </tr>
                                    <tr class="custom-width-33 fs-8">
                                        <td class=""></td>
                                        <td class="{{$patient_assessment->gcs_verbal == 1 ? 'fw-semibold' : ''}}">1 None</td>
                                        <td class="{{$patient_assessment->gcs_motor == 2 ? 'fw-semibold' : ''}}">2 Extension</td>
                                    </tr>
                                    <tr class="custom-width-33 fs-8">
                                        <td class="" colspan="2"><span class="fw-semibold"> Total GCS: {{$patient_assessment->gcs_total}}</span></td>
                                        <td class="{{$patient_assessment->gcs_motor == 1 ? 'fw-semibold' : ''}}">1 None</td>
                                    </tr>
                                </tbody>
                            </table>
                            <span class="fw-semibold fs-7">Secondary</span>
                            <ul class="custom-list fs-7 custom-list-print mb-0">
                                <li class="">
                                    <span class="fw-semibold">Signs & Symptoms: </span>
                                    <span class="text-capitalize">{{$patient_assessment->signs_symptoms}}</span>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">Allergies: </span>
                                    <span class="text-capitalize">{{$patient_assessment->allergies}}</span>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">Medications: </span>
                                    <span class="text-capitalize">{{$patient_assessment->medications}}</span>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">Past History: </span>
                                    <span class="text-capitalize">{{$patient_assessment->past_history}}</span>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">Last Intake: </span>
                                    <span class="text-capitalize">{{$patient_assessment->last_intake}}</span>
                                </li>
                                <li class="">
                                    <span class="fw-semibold">Event Prior: </span>
                                    <span class="text-capitalize">{{$patient_assessment->event_prior}}</span>
                                </li>
                            </ul>
                            <span class="fw-semibold fs-7">Vital Signs</span>
                            <table class="table table-bordered table-sm border-success fs-7 custom-table">
                                <thead>
                                    <tr class="bg-success text-light text-center">
                                        <th scope="col">Time</th>
                                        <th scope="col">B/P</th>
                                        <th scope="col">HR</th>
                                        <th scope="col">RR</th>
                                        <th scope="col">O2 Sat</th>
                                        <th scope="col">Glucose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center custom-width-16">
                                        <td>
                                            @if ($patient_assessment->vital_time1)
                                                {{$patient_assessment->vital_time1}}
                                            @else
                                                <small class="fst-italic text-light">(not set)</small>
                                            @endif
                                        </td>
                                        <td>{{$patient_assessment->vital_bp1 }}</td>
                                        <td>{{$patient_assessment->vital_hr1 }}</td>
                                        <td>{{$patient_assessment->vital_rr1 }}</td>
                                        <td>{{$patient_assessment->vital_o2sat1 }}</td>
                                        <td>{{$patient_assessment->vital_glucose1 }}</td>
                                    </tr>
                                    <tr class="text-center custom-width-16">
                                        <td>
                                            @if ($patient_assessment->vital_time2)
                                                {{$patient_assessment->vital_time2 }}
                                            @else
                                                <small class="fst-italic text-light">(not set)</small>
                                            @endif
                                        </td>
                                        <td>{{$patient_assessment->vital_bp2 }}</td>
                                        <td>{{$patient_assessment->vital_hr2 }}</td>
                                        <td>{{$patient_assessment->vital_rr2 }}</td>
                                        <td>{{$patient_assessment->vital_o2sat2 }}</td>
                                        <td>{{$patient_assessment->vital_glucose2 }}</td>
                                    </tr>
                                    <tr class="text-center custom-width-16">
                                        <td>
                                            @if ($patient_assessment->vital_time3)
                                                {{$patient_assessment->vital_time3 }}
                                            @else
                                                <small class="fst-italic text-light">(not set)</small>
                                            @endif
                                        </td>
                                        <td>{{$patient_assessment->vital_bp3 }}</td>
                                        <td>{{$patient_assessment->vital_hr3 }}</td>
                                        <td>{{$patient_assessment->vital_rr3 }}</td>
                                        <td>{{$patient_assessment->vital_o2sat3 }}</td>
                                        <td>{{$patient_assessment->vital_glucose3 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="row">
                            <ul class="list-group list-group-flush custom-list fs-7">
                                <li class="">
                                    <span class="fw-semibold">Observations: </span>
                                    <span class="text-capitalize">{{$patient_observation->observations}}</span>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col-4">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="fs-7 text-capitalize">
                                            <i class="fa-regular fa-square{{ ($patient_observation->wound === 1)? '-check' : ''}}"></i> w wound
                                        </li>
                                        @if ($patient_observation->burn_calculation > 0)
                                            <li class="fs-7 text-capitalize"><i class="fa-regular fa-square-check"></i> 
                                                b burn {{$patient_observation->burn_calculation}}<span>%</span>
                                            </li>
                                        @else
                                            <li class="fs-7 text-capitalize"><i class="fa-regular fa-square"></i>
                                                b burn
                                            </li>
                                        @endif
                                        <li class="fs-7 text-capitalize">
                                            <i class="fa-regular fa-square{{ ($patient_observation->dislocation === 1)? '-check' : ''}}"></i> d dislocation
                                        </li>
                                        <li class="fs-7 text-capitalize">
                                            <i class="fa-regular fa-square{{ ($patient_observation->fracture === 1)? '-check' : ''}}"></i> f fracture
                                        </li>
                                        <li class="fs-7 text-capitalize">
                                            <i class="fa-regular fa-square{{ ($patient_observation->numbness === 1)? '-check' : ''}}"></i> n numbness
                                        </li>
                                        <li class="fs-7 text-capitalize">
                                            <i class="fa-regular fa-square{{ ($patient_observation->rash === 1)? '-check' : ''}}"></i> r rash
                                        </li>
                                        <li class="fs-7 text-capitalize">
                                            <i class="fa-regular fa-square{{ ($patient_observation->swelling === 1)? '-check' : ''}}"></i> s swelling
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-8">
                                    <img src="{{ asset('images/rule-9-alt.png') }}" class="mx-auto d-block thumbnail" alt="Rule 9" width="100%">
                                </div>
                            </div>
                            
                            <ul class="list-inline fs-7 mb-0 text-capitalize">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Burn Classification</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_observation->burn_classification === 'critical')? '-check' : ''}}"></i>
                                    critical
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_observation->burn_classification === 'moderate')? '-check' : ''}}"></i>
                                    moderate
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_observation->burn_classification === 'minor')? '-check' : ''}}"></i>
                                    minor
                                </li>
                            </ul>
                        </div>
                        <div class="row mt-2">
                            <p class="fs-7 fw-semibold text-light custom-bg-management mb-0">MANAGEMENT</p>
                            <ul class="list-inline fs-7 text-capitalize mb-2">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Airway & Breathing</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->airway_breathing === 'open airway')? '-check' : ''}}"></i>
                                    open airway
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->airway_breathing === 'suction')? '-check' : ''}}"></i>
                                    suction
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->airway_breathing === 'airway adjuncts')? '-check' : ''}}"></i>
                                    airway adjuncts
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->airway_breathing === 'facemask')? '-check' : ''}}"></i>
                                    facemask
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->airway_breathing === 'nasal cannula')? '-check' : ''}}"></i>
                                    nasal cannula
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->airway_breathing === 'NRB mask')? '-check' : ''}}"></i>
                                    NRB mask
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->airway_breathing === 'BGM')? '-check' : ''}}"></i>
                                    BGM
                                </li>
                            </ul>
                            <ul class="list-inline fs-7 text-capitalize mb-2">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Circulation</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->circulation === 'chest compression')? '-check' : ''}}"></i>
                                    chest compression
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->circulation === 'defibrillation')? '-check' : ''}}"></i>
                                    defibrillation
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->circulation === 'bleeding control')? '-check' : ''}}"></i>
                                    bleeding control
                                </li>
                            </ul>
                            <ul class="list-inline fs-7 text-capitalize mb-2">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Wound/Burn Care</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->wound_burn_care === 'cleaning & disinfecting')? '-check' : ''}}"></i>
                                    cleaning & disinfecting
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->wound_burn_care === 'dressing & bandaging')? '-check' : ''}}"></i>
                                    dressing & bandaging
                                </li>
                            </ul>
                            <ul class="list-inline fs-7 text-capitalize mb-2">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Immobilization</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->immobilization === 'c-spine control')? '-check' : ''}}"></i>
                                    c-spine control
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->immobilization === 'spineboard')? '-check' : ''}}"></i>
                                    spineboard
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->immobilization === 'KED')? '-check' : ''}}"></i>
                                    KED
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->immobilization === 'splints')? '-check' : ''}}"></i>
                                    splints
                                </li>
                            </ul>
                            <ul class="list-inline fs-7 text-capitalize mb-0">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Others</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->others1 === 'positioning')? '-check' : ''}}"></i>
                                    positioning
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square{{ ($patient_management->others1 === 'cold/warm compress')? '-check' : ''}}"></i>
                                    cold/warm compress
                                </li>
                            </ul>
                            @if ($patient_management->others2)
                                <ul class="list-inline fs-7 text-capitalize mb-0">
                                    <li class="list-inline-item">
                                        {{$patient_management->others2}}
                                    </li>
                                </ul>
                            @endif
                            
                            <span class="fw-semibold fs-7 mt-2">Receiving Facility</span>
                            <ul class="list-inline fs-7 text-capitalize mb-0">
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square-check"></i>
                                    hospital
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square"></i>
                                    clinic
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square"></i>
                                    home
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square"></i>
                                    terminal
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa-regular fa-square"></i>
                                    institution
                                </li>
                            </ul>
                            <ul class="list-group list-group-flush custom-list fs-7 custom-list-print">
                                <li class="text-capitalize">
                                    <span class="fw-semibold">Name of Facility: </span><span>{{$patient_management->user_hospital->hospital_abbreviation . '-'}}{{$patient_management->user_hospital->hospital_name}}</span>
                                </li>
                                <li class="text-capitalize">
                                    <span class="fw-semibold">Location: </span><span>{{$patient_management->user_hospital->hospital_address}}</span>
                                </li>
                            </ul>
                            
                            <span class="fw-semibold fs-7 mt-2">Timings</span>
                            <table class="table table-bordered table-sm border-warning fs-7 custom-table">
                                <thead>
                                    <tr class="custom-bg-management text-light text-center">
                                        <th scope="col">Arrival</th>
                                        <th scope="col">Handover</th>
                                        <th scope="col">Clear</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center custom-width-33">
                                        <td>
                                            @if ($patient_management->timings_arrival)
                                                {{$patient_management->timings_arrival}}
                                            @else
                                                <small class="fst-italic text-light">(not set)</small>
                                            @endif
                                        </td>
                                        <td>{{$patient_management->timings_handover}}</td>
                                        <td>{{$patient_management->timings_clear}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <ul class="list-group list-group-flush custom-list fs-7 custom-list-print">
                                <li class="text-capitalize">
                                    <span class="fw-semibold">Narrative: </span><span>{{$patient_management->narrative}}</span>
                                </li>
                                <li class="text-capitalize">
                                    <span class="fw-semibold">Receiving Provider </span><span>{{$patient_management->receiving_provider}}</span>
                                </li>
                                <li>
                                    <ul class="list-inline fs-7 text-capitalize mb-0">
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Position: </span>
                                            {{$patient_management->provider_position}}
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Signature: </span>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <span class="fw-semibold fs-7 mt-2">REFUSAL OF TREATMENT AND/OR TRANSPORT</span>
                            <p class="fs-7 lh-sm mb-0" style="text-align: justify">I, the undersigned have been advised that the medical assistance on my behalf is necessary and that refusal of said medical assistance and/or transportation for further treatment may result in death, or imperil my health condition. Nevertheless, I refuse to accept treatment and/or transport and assume all risk and consequences of my decision and release the Philippine Red Cross from any liability arising from my refusal.</p>

                            <ul class="list-group list-group-flush custom-list fs-7 custom-list-print mb-2">
                                <li>
                                    <ul class="list-inline fs-7 text-capitalize mb-1">
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Signature: </span>
                                            <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Date: </span>
                                            <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="list-inline fs-7 text-capitalize mb-1">
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Witness Signature: </span>
                                            <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-semibold">Time: </span>
                                            <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <hr>

                            <span class="fw-semibold fs-7">HOSPITAL REFUSED TO RECEIVE PATIENT</span>
                            <ul class="list-group list-group-flush custom-list fs-7 custom-list-print">
                                <li>
                                    <ul class="list-inline fs-7 text-capitalize mb-1">
                                        <li class="list-inline-item name-space">
                                            <span class="">DUE TO THE FOLLOWING REASONS: </span>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="list-inline fs-7 mb-1 text-end">
                                        <li class="list-inline-item">
                                            <span class="fw-semibold border-top border-dark px-3">Nurse on duty/Physician on duty </span>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="row mt-2">
                            <p class="fs-7 mb-0 fw-semibold text-light custom-bg-incident">PROVIDER</p>
                            <ul class="list-inline fs-7 text-capitalize mb-1 row">
                                @foreach ($medics as $medic)
                                    <li class="list-inline-item col-7">
                                        <span class="fw-semibold">{{ $medic->personnel_type }}: </span>
                                        <span class="text-capitalize">{{ $medic->personnel_first_name }} {{ $medic->personnel_mid_name }} {{ $medic->personnel_last_name }}</span>
                                    </li>
                                    <li class="list-inline-item col-4">
                                        <span class="fw-semibold">Signature: </span>
                                    </li>
                                @endforeach
                                
                            </ul>

                            <ul class="list-inline fs-7 text-capitalize mb-1">
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Station Code: </span>
                                    <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </li>
                                <li class="list-inline-item">
                                    <span class="fw-semibold">Ambu Unit: </span>
                                    <span class="text-decoration-underline text-secondary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </page>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        const printBtn = document.getElementById('print');
        printBtn.addEventListener('click', function(){
            print();
        })
        
        const downloadBtn = document.getElementById('download');
        downloadBtn.addEventListener('click', function(){
            var element = document.getElementById('the-content');
            var opt = {
                margin:       0,
                filename:     'pcr.pdf',
                image:        { type: 'jpeg', quality: 1.0 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
                };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        })
    </script>
</body>
</html>

