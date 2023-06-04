@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Available Teams
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Available Teams</a></li>
                    </ul>
                </ul>

                <a href=" {{route('response.create')}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Create Response Team</a>
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">
        @if ($responses->count())
            @foreach ($responses as $response)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center name-space"><span class="text-capitalize fs-5 fw-semibold">{{ $response->user_ambulance->plate_no }}</span></li>
                                        <li class="">RT{{$response->id}}</li>
                                        <li class="text-capitalize fw-semibold name-space"><span class="">Incidents Today: {{ $response->incidents->count() }}</span>
                                        <li class=""><a href="{{ route('response.show', $response->id) }}" class="btn btn-outline-primary btn-sm d-block">View Team</a></li>
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