@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-3 fw-bold">
            @if (auth()->user()->id === $account->id)
                My Account
            @else
                Account Information
            @endif
                </h4>
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="row mb-3">
                            <h4>Personnel List</h4>
                            <div class="col-md-12">
                                <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <div class="col-md-4 mt-3">
                                <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center"><span class="fs-5 fw-bold">{{ $account->username }}</span><a href="" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a></li>
                                        <!-- <li class="text-capitalize fst-italic text-center">ID{{ $account->id }} <span class="fs-5">|</span> {{ $account->user_type }}</li> -->
                                        <li class="text-capitalize">ID{{ $account->id }} <span class="fs-5">|</span> {{ $account->user_type }}</li>
                                        <!-- <span class="fs-5">&middot;</span> -->
                                        <li class="account-name">
                                            @switch($account->user_type)
                                                @case('ambulance')
                                                    <span class="fw-semibold text-secondary">Plate: </span>
                                                    {{$account->user_ambulance->plate_no}}
                                                    @break

                                                @case('hospital')
                                                    <span class="fw-semibold text-secondary">Hospital Name: </span>
                                                    {{$account->user_hospital->hospital_name}} <small>({{$account->user_hospital->hospital_abbreviation}})</small>
                                                    @break

                                                @case('comcen')
                                                    <span class="fw-semibold text-secondary">Comcen Staff: </span>
                                                    <span class="text-capitalize">{{$account->user_comcen->first_name}} {{$account->user_comcen->last_name}}</span>
                                                    @break
                                                    
                                                @case('admin')
                                                    <span class="fw-semibold text-secondary">Admin: </span>
                                                    <span class="text-capitalize">{{$account->user_admin->first_name}} {{$account->user_admin->last_name}}</span>
                                                    @break

                                                @default
                                                    <span class="text-danger">Error</span>
                                            @endswitch
                                        </li>    
                                        <li class="text-capitalize"><span class="text-{{ ($account->status === 'active')? 'success' : 'danger' }} fw-semibold">{{ $account->status }}</span></li>
                                    </ul>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <h5 class="fw-semibold">Account Details</h5>
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush custom-list">
                                    @switch($account->user_type)
                                        @case('ambulance')
                                            <li> <span class="text-secondary fw-semibold">Contact No: </span><span>{{$account->user_ambulance->plate_no}}</span></li>
                                            <li> <span class="text-secondary fw-semibold">Added on: </span><span>{{$account->created_at->diffForHumans()}}</span></li>
                                            @break

                                        @case('hospital')
                                            <li> <span class="text-secondary fw-semibold">Address: </span><span>{{$account->user_hospital->hospital_address}} </span></li>
                                            <li> <span class="text-secondary fw-semibold">Contact No: </span><span>{{$account->user_hospital->contact_1}} </span> | <span> {{$account->user_hospital->contact_1}} </span></li>
                                            <li> <span class="text-secondary fw-semibold">Email: </span><span>{{$account->user_hospital->email}} </span></li>
                                            <li> <span class="text-secondary fw-semibold">Added on: </span><span>{{$account->created_at->diffForHumans()}}</span></li>
                                            @break

                                        @case('comcen')
                                            <li> <span class="text-secondary fw-semibold">Contact No: </span><span>{{$account->user_comcen->contact_1}} </span></li>
                                            <li> <span class="text-secondary fw-semibold">Email: </span><span>{{$account->user_comcen->email}} </span></li>
                                            <li> <span class="text-secondary fw-semibold">Added on: </span><span>{{$account->created_at->diffForHumans()}}</span></li>
                                            @break
                                            
                                        @case('admin')
                                            <li> <span class="text-secondary fw-semibold">Contact No: </span><span>{{$account->user_admin->contact_1}} </span></li>
                                            <li> <span class="text-secondary fw-semibold">Email: </span><span>{{$account->user_admin->email}} </span></li>
                                            <li> <span class="text-secondary fw-semibold">Added on: </span><span>{{$account->created_at->diffForHumans()}}</span></li>
                                            @break

                                        @default
                                            <span class="text-danger">Error</span>
                                    @endswitch
                                </ul>
                            </div>
                        </div>
                        @switch($account->user_type)
                            @case('ambulance')
                                <hr>
                                <div class="row mb-3">
                                    <h5 class="fw-semibold">Account Overview</h5>
                                    <div class="col-md-8">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li><span class="text-secondary fw-semibold">Active Incidents: </span></li>
                                            <li><span class="text-secondary fw-semibold">Completed Incidents: </span></li>
                                        </ul>
                                    </div>
                                </div>
                                @break

                            @case('hospital')
                                <hr>
                                <div class="row mb-3">
                                    <h5 class="fw-semibold">Account Overview</h5>
                                    <div class="col-md-8">
                                        <ul class="list-group list-group-flush custom-list">
                                            <li><span class="text-secondary fw-semibold">Received Patients: </span></li>
                                        </ul>
                                    </div>
                                </div>
                                @break

                            @case('comcen')
                                @break
                                
                            @case('admin')
                                @break

                            @default
                                <span class="text-danger">Error</span>
                        @endswitch
                        
                    </div>
                </div>
                <div class="text-start">
                    <a href="{{ url()->previous() }}" class="btn btn-primary my-2">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection