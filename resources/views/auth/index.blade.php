@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-capitalize">{{ ($user_type) ?? 'all users'}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('account.overview') }}">All Users</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.overview', 'ambulance') }}">Ambulance</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.overview', 'hospital') }}">Hospital</a></li>
                            @if ( auth()->user()->user_type == 'admin' )
                                <li><a class="dropdown-item" href="{{ route('account.overview', 'comcen') }}">ComCen</a></li>
                                <li><a class="dropdown-item" href="{{ route('account.overview', 'admin') }}">Admin</a></li>
                            @endif
                            <!-- <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        </ul>
                    </ul>

                    
                    <a href=" {{route('account.create' ,$user_type)}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Create User</a>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">
        @if ($accounts->count())
            @foreach ($accounts as $account)
                <!-- <div class="card" style="width: 18rem;"> -->
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                                    <!-- <img src="{{ asset('storage/default/thumbnail-default.jpg') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px"> -->
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center"><span class="fs-5 fw-bold">{{ $account->username }}</span></li>
                                        <li class="text-capitalize">USER{{ $account->id }} 
                                            <span class="fs-5">|</span> 
                                            <span class="text-success fw-semibold">{{ $account->user_type }}</span>
                                            <!-- <span class="fs-5">|</span> 
                                            <span class="text-{{ ($account->status === 'active')? 'success' : 'danger' }} fw-semibold">{{ $account->status }}</span></li> -->
                                        <li class="account-name">
                                            @switch($account->user_type)
                                                @case('ambulance')
                                                    {{$account->user_ambulance->plate_no}}
                                                    @break

                                                @case('hospital')
                                                    {{$account->user_hospital->hospital_name}} <small>({{$account->user_hospital->hospital_abbreviation}})</small>
                                                    @break

                                                @case('comcen')
                                                    <span class="text-capitalize">{{$account->user_comcen->first_name}} {{$account->user_comcen->last_name}}</span>
                                                    @break
                                                    
                                                @case('admin')
                                                    <span class="text-capitalize">{{$account->user_admin->first_name}} {{$account->user_admin->last_name}}</span>
                                                    @break

                                                @default
                                                    Something went wrong, please try again
                                            @endswitch
                                        </li>    
                                        <li class="mt-2"><a href="{{ route('account.show', $account->id) }}" class="btn btn-outline-primary btn-sm d-block">View User</a></li>
                                    </ul>
                                    
                                </div>
                            </div>

                            <!-- <div class="row mb-3">
                                <div class="col-md-12">

                                    @switch($account->user_type)
                                        @case('ambulance')
                                            <span>{{$account->user_ambulance->plate_no}}</span>
                                            @break

                                        @case('hospital')
                                            <span>{{$account->user_hospital->hospital_name}}</span>
                                            @break

                                        @case('comcen')
                                            <span class="text-capitalize">{{$account->user_comcen->first_name}} {{$account->user_comcen->last_name}}</span>
                                            @break
                                            
                                        @case('admin')
                                            <span class="text-capitalize">{{$account->user_admin->first_name}} {{$account->user_admin->last_name}}</span>
                                            @break

                                        @default
                                            <span>Something went wrong, please try again</span>
                                    @endswitch

                                </div>
                            </div> -->

                            <!-- <div class="row mb-3">
                                <div class="col-md-12">
                                    <span>Incidents</span><br>
                                    <span>Active: 0</span><br>
                                    <span>Complete: 0</span><br>
                                </div>
                            </div> -->
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
            <div class="d-flex">
                {{ $accounts->links('pagination::simple-bootstrap-5') }}
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