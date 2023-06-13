@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-3 fw-bold">Incident Report</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <h5 class="fw-semibold">Incident Information
                                @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                    <a href="{{ route('incident.edit', $incident->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                                @endif
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">Incident ID: </span>{{ $incident->id }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Nature of call: </span>{{ $incident->nature_of_call }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Incident Type: </span>{{ $incident->incident_type }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">Status:</span>

                                            <!-- Check if incident is assigned to a response team or not -->
                                            @isset($incident->response_team_id)
                                                <span class="text-success fw-semibold">Assigned</span>
                                            @else
                                                <span class="text-danger fw-semibold">Unassigned</span>
                                            @endisset 
                                        </li>
                                        <li class="text-capitalize"><span class="fw-semibold">Reported at: </span>{{ $incident->created_at->diffForHumans() }}</li>
                                        
                                    </ul>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">No of person involved/injured: </span>{{ $incident->no_of_persons_involved }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Caller: </span>{{ $incident->caller_first_name }} {{ $incident->caller_last_name }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Contact: </span>{{ $incident->caller_number }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold"></span> </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">Area Type: </span>{{ $incident->area_type }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold">Location: </span>{{ $incident->incident_location }}</li>
                                        <li class="text-capitalize"><span class="fw-semibold"></span> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <h5 class="fw-semibold">Incident Details</h5>
                            <div class="col-md-12">
                                <span>{{ $incident->incident_details }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <h5 class="fw-semibold">Nature & Extent of Injuries</h5>
                            <div class="col-md-12">
                                <span>{{ $incident->injuries_details }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-10 mx-auto">
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
                                            <td>
                                                <!-- Check if dispatch is not null -->
                                                @if ($incident->timing_dispatch)
                                                    <small>{{$incident->timing_dispatch }}</small>
                                                @else
                                                    <small class="text-secondary fst-italic">(not set)</small>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Check if enroute is not null -->
                                                @if ($incident->timing_enroute)
                                                    <small>{{$incident->timing_enroute }}</small>
                                                @else
                                                    
                                                    <!-- Only show to user_type Admin or Ambulance -->
                                                    @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                                        <form method="POST" action="{{route('incident.only.enroute',  $incident->id)}}">
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

                                                <!-- Check if arrival is not null -->
                                                @if ($incident->timing_arrival)
                                                    <small>{{$incident->timing_arrival }}</small>
                                                @else
                                                    
                                                    <!-- Only show if enroute is not null -->
                                                    @if ($incident->timing_enroute)
                                                        <!-- Only show to user_type Admin or Ambulance -->
                                                        @if ((auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                                            <form method="POST" action="{{route('incident.only.arrival',  $incident->id)}}">
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
                                                <!-- Check if depart is not null -->
                                                @if ($incident->timing_depart)
                                                    <small>{{$incident->timing_depart }}</small>
                                                @else
                                                    @if ($incident->timing_arrival)
                                                        <small class="text-secondary">(see PCR)</small>
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
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row mb-3">

                            <!-- Show if response team is assigned -->
                            @isset( $incident->response_team_id)
                                <h5 class="fw-semibold">Response Team
                                    @if ( (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                                        <button type="button" class="btn btn-outline-success btn-sm custom-rounded-btn float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <small>Update</small>
                                        </button>
                                    @endif
                                    
                                </h5>
                                <div class="col-md-12 text-center">
                                    <ul class="list-group list-group-flush text-start custom-list">
                                        <li class="text-capitalize"><span class="fw-semibold">Ambulance: </span> {{$incident->response_team->user_ambulance->plate_no}}</li>
                                        @foreach ($medics as $medic)
                                            <li class="text-capitalize"><span class="fw-semibold">Medic: </span>{{ $medic->personnel_first_name }} {{ $medic->personnel_last_name }}</li>
                                        @endforeach
                                        <li class="text-capitalize"><span class="fw-semibold"></span> </li>
                                    </ul>
                                </div>
                            @else
                                <h5 class="fw-semibold">Response Team</h5>
                                <div class="col-md-12 text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Assign Response Team
                                    </button>
                                </div>
                                
                            @endisset
                        </div>
                        <hr>
                        <div class="row mb-1">
                            <h5 class="fw-semibold">Patient Information</h5>
                            @isset( $incident->response_team_id)
                                @if($patients->count())
                                    <div class="col-md-12">
                                        @foreach ($patients as $patient)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <ul class="list-group list-group-flush custom-list">
                                                        <li class="text-capitalize"><span class="fw-semibold">Patient Name: </span> {{$patient->patient_first_name}} {{$patient->patient_last_name}}</li>
                                                        <li class="text-capitalize"><span class="fw-semibold">Sex: </span> {{$patient->sex}} </li>
                                                        <li class="text-capitalize"><span class="fw-semibold">Age: </span> {{$patient->age}} </li>
                                                        <li class="text-capitalize"><span class="fw-semibold"></span> </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="list-group list-group-flush custom-list">
                                                        <li class="text-capitalize"><span class="fw-semibold">Birthday: </span>
                                                            @isset($patient->birthday)
                                                                {{ \Carbon\Carbon::parse($patient->birthday)->format('M d, Y') }}
                                                            @else
                                                                <small class="fst-italic">(Not set)</small>
                                                            @endisset
                                                        </li>
                                                        <li class="text-capitalize"><span class="fw-semibold">Contact: </span> {{$patient->contact_no}}</li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-center mt-1">
                                                    <a class="btn btn-primary btn-sm" href="{{route('pcr.show', $patient->id)}}">View PCR</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="col-md-12 text-center">
                                        @if ( (auth()->user()->user_type == 'ambulance') || (auth()->user()->user_type == 'admin') )
                                            <a class="btn btn-primary btn-sm" href=" {{route('patient.create', $incident->id)}} "> Create Patient Info</a> 
                                        @else
                                            <small class="fst-italic text-secondary">Nothing to show</small>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="col-md-12">
                                    <small class="fst-italic">Nothing to show</small>
                                </div>
                            @endisset 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal can only be accessed by user_type comcen or admin -->
    @if ( (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Assign Response Team</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form method="POST" action="{{ route('incident.assign', $incident->id)}}">
                        <div class="modal-body">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-4">
                                        <label for="ambulance" class="col-form-label">Response Team</label>
                                    </div>
                                    @if ($responses->count())
                                        <div class="col-8 text-center">
                                            <select class="form-select" aria-label="Default select example" name="response_team" class="form-control @error('response_team') is-invalid @enderror" required>
                                                <option class="text-center" value="" selected disabled>--- Available Teams ---</option>
                                                @foreach ($responses as $response)
                                                    <option class="text-capitalize" value="{{$response->id}}">Ambulance: {{$response->user_ambulance->plate_no}}
                                                @endforeach
                                            </select>
                                            @error('response_team')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="col-8 text-center">
                                            <select class="form-select" aria-label="Default select example" name="response_team" class="form-control">
                                                <option disabled selected>No response team available</option>
                                            </select>
                                        </div>
                                    @endif
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                            @if ($responses->count())
                                <button type="submit" class="btn btn-primary">{{ __('Assign') }}</button>
                            @endif
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection