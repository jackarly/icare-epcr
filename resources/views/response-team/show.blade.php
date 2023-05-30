@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4 class="text-center mb-3 fw-bold">Response Team</h4>
                <div class="card">
                    <div class="card-body">
                        <!-- <div class="row mb-3">
                            <h4>Personnel List</h4>
                            <div class="col-md-12">
                                <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                            </div>
                        </div> -->
                        <div class="row mb-3">
                            <h5 class="fw-semibold">Response Team Details
                                <a href="{{ route('response.edit', $response->id ) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                            </h5>
                            <div class="col-md-12">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="text-capitalize"><span class="fw-semibold text-secondary">Ambulance Plate: </span>{{ $response->user_ambulance->plate_no }}</li>
                                    @foreach ($medics as $medic)
                                        <li class="text-capitalize"><span class="fw-semibold fw-semibold text-secondary">Medic: </span>{{ $medic->personnel_first_name }} {{ $medic->personnel_last_name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <h5 class="fw-semibold">Response Team Overview</h5>
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush custom-list">
                                    <li>Incidents Assigned Today: {{$response->incidentsToday}}</li>
                                    <li>Incidents Completed Today: {{$response->incidentsTotal}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-start my-2">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection