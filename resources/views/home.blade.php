@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="fw-semibold">
                <span>Dashboard</span>
                <!-- <button type="button" class="btn btn-outline-danger btn-sm custom-rounded-btn text-decoration-none float-end" data-bs-toggle="modal" data-bs-target="#hotlineModal">
                    <span>Hotline Numbers</span>
                </button> -->
                <a href="{{ route('hotline') }}" class="btn btn-outline-danger btn-sm custom-rounded-btn text-decoration-none float-end">
                    <span>Hotline Numbers</span>
                </a>
            </h4>
            <div class="card bg-transparent border border-0">
                <!-- Show different dashboard based on user_type -->
                @if (auth()->user()->user_type == 'hospital')
                    @include('inc.dashboard-hospital')
                @elseif (auth()->user()->user_type == 'ambulance')
                    @include('inc.dashboard-ambulance')
                @elseif ( (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                    @include('inc.dashboard-admin')
                @else
                    <span class="fst-italic">Nothing to show</span>
                @endif
                
                <!-- Deployed Response Team -->
                <div class="card-body">
                    @if ( (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                        <hr class="mt-4">
                        <h5 class="fw-semibold text-secondary">Deployed Response Team
                            <!-- <button type="button" class="btn btn-outline-secondary btn-sm custom-rounded-btn text-decoration-none float-end" data-bs-toggle="modal" data-bs-target="#hotlineModal">
                                <span><i class="fa-solid fa-magnifying-glass"></i></span>
                            </button> -->
                        </h5>
                        <div class="row justify-content-left">
                            @if ($responses->count())
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Plate No</th>
                                        <th scope="col">Driver</th>
                                        <th scope="col">Contact</th>
                                        <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($responses as $response)
                                            @php
                                                $personnels = App\Models\ResponseTeam::getPersonnelList($response->id)
                                            @endphp
                                            <tr>
                                                <th>{{ $response->id }}</th>
                                                <td>{{ $response->plate_no }}</td>
                                                <td class="text-capitalize">{{ $personnels['0']->personnel_first_name}} {{ $personnels['0']->personnel_mid_name}} {{ $personnels['0']->personnel_last_name}}</td>
                                                <td>{{ $personnels['0']->contact}}</td>
                                                <td class="text-end"><a href="{{ route('response.show', $response->id) }}" class="btn btn-outline-primary btn-sm custom-rounded-btn">View Team</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>   
                                
                                <div class="d-flex">
                                    {{ $responses->links('pagination::simple-bootstrap-5') }}
                                </div>    
                            @else
                                <div class="col-md-12 text-center">
                                    <span class="text-secondary my-5">Nothing to show</span>
                                </div>
                            @endif 
                        </div>
                        <hr class="mt-4">
                    @endif
                    
                    <!-- Ongoing Incidents -->
                    <h5 class="fw-semibold text-secondary">Ongoing Incidents
                        <!-- <button type="button" class="btn btn-outline-secondary btn-sm custom-rounded-btn text-decoration-none float-end" data-bs-toggle="modal" data-bs-target="#hotlineModal">
                            <span><i class="fa-solid fa-magnifying-glass"></i></span>
                        </button> -->
                    </h5>
                    <div class="row justify-content-left">
                        @if ($incidents->count())
                            <table class="table"> 
                                <thead>
                                    <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nature of Call</th>
                                    <th scope="col">Incident Type</th>
                                    <th scope="col">Caller Name</th>
                                    <th scope="col">Caller No</th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incidents as $incident)
                                        <tr class="text-capitalize">
                                            <th>{{ $incident->id }}</th>
                                            <td>{{$incident->nature_of_call}}</td>
                                            <td>{{$incident->incident_type}}</td>
                                            <td>{{$incident->caller_first_name}} {{$incident->caller_last_name}}</td>
                                            <td>{{$incident->caller_number}}</td>
                                            <td class="text-end"><a href="{{route('incident.show', $incident->id)}}" class="btn btn-outline-primary btn-sm custom-rounded-btn">View Incident</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>   
                            
                            <div class="d-flex">
                                {{ $incidents->links('pagination::simple-bootstrap-5') }}
                            </div> 
                            
                        @else
                            <div class="col-md-12 text-center">
                                <span class="text-secondary my-5">Nothing to show</span>
                            </div>
                        @endif        
                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
