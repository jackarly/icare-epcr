@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="fw-semibold">Dashboard</h4>
            <div class="card bg-transparent border border-0">
                <div class="card-body">
                    <hr>
                    <h5 class="fw-semibold text-secondary">Incidents Today</h5>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-success rounded bg-success text-light opacity-75" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">New</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\Incident::getActiveToday()}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-warning rounded bg-warning opacity-75" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">In Progress</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\Incident::getOngoingToday()}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-secondary rounded bg-secondary text-light opacity-75" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Completed</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\Patient::getCompletedToday()}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-3 border-success rounded bg-white" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Available Response Team</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\Incident::getAvailableToday()}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-3 border-warning rounded bg-white" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Deployed Response Team</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\Incident::getDeployedToday()}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-3 border-secondary rounded bg-white" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Total Response Team</h5></li>
                                    <li class="mt-2"><span class="display-4">{{App\Models\ResponseTeam::whereDate('created_at', Carbon\Carbon::today())->count()}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="fw-semibold text-secondary mt-3">Overall</h5>
                    <div class="row">
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-3 rounded bg-white" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Ambulance Registered</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\UserAmbulance::all()->count()}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-3 rounded bg-white" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Medic Registered</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\Personnel::all()->count()}}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2" style="height: 10rem;">
                            <div class="text-center border border-3 rounded bg-white" style="height: 100%; width: 100%">
                                <ul class="list-group list-group-flush custom-list">
                                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Total Patients</h5></li>
                                    <li class="mt-2"><span class="display-4">{{ App\Models\Patient::getCompletedPatients()}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
