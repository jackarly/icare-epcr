<div class="card-body">
    <hr>
    <h5 class="fw-semibold text-secondary">Incidents</h5>
    <div class="row mb-3">
        <div class="col-md-4 mb-2" style="height: 10rem;">
            <div class="text-center border border-success rounded bg-success text-light opacity-75" style="height: 100%; width: 100%">
                <ul class="list-group list-group-flush custom-list">
                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">New</h5></li>
                    <li class="mt-2"><span class="display-4">{{  App\Models\UserAmbulance::dashboardNewToday()}}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 mb-2" style="height: 10rem;">
            <div class="text-center border border-warning rounded bg-warning opacity-75" style="height: 100%; width: 100%">
                <ul class="list-group list-group-flush custom-list">
                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Completed Today</h5></li>
                    <li class="mt-2"><span class="display-4">{{ App\Models\UserAmbulance::dashboardCompletedToday() }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 mb-2" style="height: 10rem;">
            <div class="text-center border border-secondary rounded bg-secondary text-light opacity-75" style="height: 100%; width: 100%">
                <ul class="list-group list-group-flush custom-list">
                    <li class="custom-dashboard-title mt-3 mt-lg-4"><h5 class="fw-bold">Overall Completed</h5></li>
                    <li class="mt-2"><span class="display-4">{{ App\Models\UserAmbulance::dashboardCompletedOverall() }}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    
    
    <h5 class="fw-semibold text-secondary">Account Overview</h5> <span></span>
    <span class="text-secondary"> Ambulance Plate No:</span> <span class="fw-semibold text-secondary">{{auth()->user()->user_ambulance->plate_no}}</span> 
    <div class="row justify-content-around my-4">

        @php $medics = App\Models\UserAmbulance::dashboardMedics() @endphp
        @if ($medics->count() > 0)
            @foreach ($medics as $medic)
                <div class="card col-md-6 col-lg-5">
                    <div class="row mb-3">
                        <div class="col-md-12 mt-3">
                            <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                            <ul class="list-group list-group-flush custom-list">
                                <li class="text-center"><span class="fs-5 fw-bold">{{$medic->personnel_first_name}} {{$medic->personnel_mid_name}} {{$medic->personnel_last_name}}</span></li>
                                <li class="text-capitalize"><span class="fw-semibold text-secondary">Sex: </span> {{$medic->sex}} </li>
                                <li class="text-capitalize"><span class="fw-semibold text-secondary">Age: </span> <span>{{\Carbon\Carbon::parse($medic->birthday)->diff(\Carbon\Carbon::now())->format('%y')}}</span> </li>
                                <li class="text-capitalize"><span class="fw-semibold text-secondary">Birthday: </span>
                                    @isset($medic->birthday)
                                        {{ \Carbon\Carbon::parse($medic->birthday)->format('M d, Y') }}
                                    @else
                                        <small class="fst-italic">(Not set)</small>
                                    @endisset
                                </li>
                                <li> <span class="text-secondary fw-semibold">Contact No: </span><span>{{$medic->contact}} </span></li>
                            </ul>
                        </div>
                        
                    </div>
                    <div class="row mb-3">
                    </div>
                </div>
            @endforeach
        @else
            <span class="fst-italic text-secondary">Not assigned to a Response Team</span>
        @endif
        
    </div>
    <hr>
</div>