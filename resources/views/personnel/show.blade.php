@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-3 fw-bold">Medic Information</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 mt-3">
                                <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="text-center"><span class="fs-5 fw-bold">{{$personnel->personnel_first_name}} {{$personnel->personnel_mid_name}} {{$personnel->personnel_last_name}}</span><a href="" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a></li>
                                    <li class="text-capitalize">ID{{ $personnel->id }} <span class="fs-5">|</span><span class="text-success fw-semibold">Assigned</span></li>
                                    <li class="text-capitalize"><span class="fw-semibold text-secondary">Sex: </span> {{$personnel->sex}} </li>
                                    <li class="text-capitalize"><span class="fw-semibold text-secondary">Age: </span> <span>{{\Carbon\Carbon::parse($personnel->birthday)->diff(\Carbon\Carbon::now())->format('%y')}}</span> </li>
                                    <li class="text-capitalize"><span class="fw-semibold text-secondary">Birthday: </span>
                                        @isset($personnel->birthday)
                                            {{ \Carbon\Carbon::parse($personnel->birthday)->format('M d, Y') }}
                                        @else
                                            <small class="fst-italic">(Not set)</small>
                                        @endisset
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <h5 class="fw-semibold">Account Details</h5>
                            <div class="col-md-12">
                                <ul class="list-group list-group-flush custom-list">
                                    <li> <span class="text-secondary fw-semibold">Contact No: </span><span>{{$personnel->contact}} </span></li>
                                    <li> <span class="text-secondary fw-semibold">Added on: </span><span>{{$personnel->created_at->diffForHumans()}}</span></li>
                                </ul>
                            </div>
                        </div>
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
                    </div>
                </div>
                <div class="text-start">
                    <a href="{{ url()->previous() }}" class="btn btn-primary my-2">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection