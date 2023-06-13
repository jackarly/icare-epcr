@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-capitalize">{{ ($status) ?? 'all medics'}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('personnel') }}">All Medics</a></li>
                        <li><a class="dropdown-item" href="{{ route('personnel', 'available') }}">Available</a></li>
                        <li><a class="dropdown-item" href="{{ route('personnel', 'assigned') }}">Assigned</a></li>
                        <!-- <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                    </ul>
                </ul>

                <a href=" {{route('personnel.create')}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Add Medic</a>
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">
        @if ($personnels->count())
            @foreach ($personnels as $personnel)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center"><span class="text-capitalize fs-5 fw-semibold">{{$personnel->personnel_first_name}} {{$personnel->personnel_last_name}}</span></li>
                                        <li class="">MEDIC{{$personnel->id}}<span class="fs-5">|</span>
                                            @if ($personnel->medicStatus)
                                                <span class="text-warning fw-semibold">Assigned</span>
                                            @else
                                                <span class="text-success fw-semibold">Available</span>
                                            @endif
                                            
                                        </li>
                                        <li class="name-space"><span>{{$personnel->contact}}</span></li>
                                        <li class="mt-2"><a href="{{route('personnel.show', $personnel->id)}}" class="btn btn-outline-primary btn-sm d-block">View Medic</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
        @else
            <hr>
            <div class="col-md-12 text-center">
                <span class="text-secondary my-5">Nothing to show</span>
            </div>
        @endif        
    </div>
</div>
@endsection