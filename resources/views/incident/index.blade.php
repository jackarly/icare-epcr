@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        All Incidents
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">All Incidents</a></li>
                        <li><a class="dropdown-item" href="#">Unassigned</a></li>
                        <li><a class="dropdown-item" href="#">Assigned</a></li>
                        <li><a class="dropdown-item" href="#">Completed</a></li>
                        <!-- <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                    </ul>
                </ul>

                <a href=" {{route('incident.create')}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Create Incident</a>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">
        @if ($incidents->count())
            @foreach ($incidents as $incident)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize text-center"><span class="fs-5 fw-bold">{{$incident->caller_first_name}} {{$incident->caller_last_name}}</span></li>
                                        <li class="">INCIDENT{{$incident->id}}<span class="fs-5">|</span> 
                                            @isset($incident->response_team_id)
                                                <span class="text-success fw-semibold">Assigned</span>
                                            @else
                                                <span class="text-danger fw-semibold">Unassigned</span>
                                            @endisset 
                                        </li>
                                        <li class="text-capitalize">{{$incident->nature_of_call}} <span class="fs-5">&middot;</span> {{$incident->incident_type}}</li>
                                        <li class="name-space">{{$incident->caller_number}}</li>
                                        <li class="fst-italic"><small>Added {{$incident->created_at->diffForHumans()}}</small></li>
                                        <li class="mt-2"><a href="{{route('incident.show', $incident->id)}}" class="btn btn-outline-primary btn-sm d-block">View Incident</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
        @else
            <div class="col-md-8">
                Nothing
            </div>
        @endif        
    </div>
</div>
@endsection