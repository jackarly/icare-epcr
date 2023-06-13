<div class="card-body">
    <hr>
    <h5 class="fw-semibold text-secondary">Patients Received</h5>
    <div class="row mb-3">

        <!-- Count en route patients -->
        <div class="col-md-4 mb-2" style="height: 10rem;">
            <div class="text-center border border-success rounded bg-success text-light opacity-75" style="height: 100%; width: 100%">
                <ul class="list-group list-group-flush custom-list">
                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">En Route</h5></li>
                    <li class="mt-2"><span class="display-4">{{  App\Models\UserHospital::dashboardEnrouteToday()}}</span></li>
                </ul>
            </div>
        </div>

        <!-- Count completed patients today-->
        <div class="col-md-4 mb-2" style="height: 10rem;">
            <div class="text-center border border-warning rounded bg-warning opacity-75" style="height: 100%; width: 100%">
                <ul class="list-group list-group-flush custom-list">
                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Completed Today</h5></li>
                    <li class="mt-2"><span class="display-4">{{  App\Models\UserHospital::dashboardCompletedToday()}}</span></li>
                </ul>
            </div>
        </div>

        <!-- Count overall patients -->
        <div class="col-md-4 mb-2" style="height: 10rem;">
            <div class="text-center border border-secondary rounded bg-secondary text-light opacity-75" style="height: 100%; width: 100%">
                <ul class="list-group list-group-flush custom-list">
                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Overall Patients</h5></li>
                    <li class="mt-2"><span class="display-4">{{  App\Models\UserHospital::dashboardCompletedOverall()}}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    
    <h5 class="fw-semibold text-secondary">Account Overview</h5>
    <div class="row justify-content-around mb-4">
        <div class="card col-md-6 col-lg-5">
            <div class="row mb-3">
                <div class="col-md-12 mt-3">
                    <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <ul class="list-group list-group-flush custom-list">
                        <li class="text-center"><span class="fs-5 fw-bold">{{ auth()->user()->username }}</span>
                        </li>
                        <li class="text-capitalize">ID{{ auth()->user()->id }} <span class="fs-5">|</span> {{ auth()->user()->user_type }}</li>
                        <li class="account-name">
                            <span class="text-secondary fw-semibold">Hospital Name: </span>{{ auth()->user()->user_hospital->hospital_abbreviation . ' - '}}{{ auth()->user()->user_hospital->hospital_name}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card col-md-6 col-lg-5">
            <div class="row my-3">
                <h5 class="fw-semibold text-secondary">Account Details
                    <a href="{{ route('account.edit') }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a>
                </h5>
                <div class="col-md-12 mt-3">
                    <ul class="list-group list-group-flush custom-list">
                        <li> <span class="text-secondary fw-semibold">Address: </span><span>{{ auth()->user()->user_hospital->hospital_address}} </span></li>
                        <li> <span class="text-secondary fw-semibold">Contact No: </span><span>{{ auth()->user()->user_hospital->contact_1}} </span> | <span> {{ auth()->user()->user_hospital->contact_1}} </span></li>
                        <li> <span class="text-secondary fw-semibold">Email: </span><span>{{ auth()->user()->user_hospital->email}} </span></li>
                        <li> <span class="text-secondary fw-semibold">Added on: </span><span>{{ auth()->user()->created_at->diffForHumans()}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>