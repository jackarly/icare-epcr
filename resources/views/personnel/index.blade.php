@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        All Medics
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">All Medics</a></li>
                        <li><a class="dropdown-item" href="#">Availalbe</a></li>
                        <li><a class="dropdown-item" href="#">Assigned</a></li>
                        <!-- <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                    </ul>
                </ul>

                <a href=" {{route('personnel.create')}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Add Medic</a>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
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
                                    <!-- <img src="{{ asset('storage/default/thumbnail-default.jpg') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px"> -->
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center"><span class="text-capitalize fs-5 fw-semibold">{{$personnel->personnel_first_name}} {{$personnel->personnel_last_name}}</span></li>
                                        <li class="">MEDIC{{$personnel->id}}<span class="fs-5">|</span> <span class="text-success fw-semibold">Assigned</span></li>
                                        <li class="name-space"><span>{{$personnel->contact}}</span></li>
                                        <li class="mt-2"><a href="{{route('personnel.show', $personnel->id)}}" class="btn btn-outline-primary btn-sm d-block">View Medic</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div> -->
                
            @endforeach
            
        @else
            <div class="col-md-8">
                Nothing
            </div>
        @endif        
    </div>
</div>
@endsection