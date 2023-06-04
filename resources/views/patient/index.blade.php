@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-capitalize">{{ ($status) ?? 'all patients'}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('patient') }}">All Patients</a></li>
                            <li><a class="dropdown-item" href="{{ route('patient', 'ongoing') }}">Ongoing</a></li>
                            <li><a class="dropdown-item" href="{{ route('patient', 'completed') }}">Completed</a></li>
                        </ul>
                    </ul>
                    
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">
        @if ($patients->count())
            @foreach ($patients as $patient)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center"><span class="text-capitalize fs-5 fw-semibold">
                                            {{$patient->patient_first_name}}
                                            {{$patient->patient_mid_name}}
                                            {{$patient->patient_last_name}}
                                            </span>
                                        </li>
                                        <li class="">PATIENT{{$patient->id}}
                                            <span class="fs-5">|</span> 
                                            @isset ($patient->completed_at)
                                                <span class="text-success text-capitalize fw-semibold">Completed</span>
                                            @else
                                                <span class="text-warning text-capitalize fw-semibold">Ongoing</span>
                                            @endisset
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <ul class="list-group list-group-flush custom-list">
                                        <li class=""><span class="text-capitalize">{{$patient->sex}}</span></li>
                                        <li class="">Age:
                                            @isset($patient->birthday)
                                                <span>{{\Carbon\Carbon::parse($patient->birthday)->diff(\Carbon\Carbon::now())->format('%y')}}</span>
                                            @else
                                                <span>{{$patient->age}}</span>
                                            @endisset
                                        </li>
                                        <li class="fst-italic"><small>Added {{$patient->created_at->diffForHumans()}}</small></li>
                                        <li class="mt-2">
                                            <a href="{{route('incident.show', $patient->incident_id)}}" class="btn btn-outline-primary btn-sm d-block">View IR</a>
                                        </li>
                                        <li class="mt-1">
                                            <a href="{{route('pcr.show', $patient->id)}}" class="btn btn-primary btn-sm d-block">View PCR</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="d-flex">
                {{ $patients->links('pagination::simple-bootstrap-5') }}
            </div>
            
        @else
            <hr>
            <div class="col-md-12 text-center">
                <span class="text-secondary my-5">Nothing to show</span>
            </div>
        @endif        
    </div>
</div>
@endsection