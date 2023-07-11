@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-capitalize">{{ ($status) ?? 'incidents today'}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('incident',) }}">Incidents Today</a></li>
                            <li><a class="dropdown-item" href="{{ route('incident', 'unassigned today') }}">Unassigned Today</a></li>
                            <li><a class="dropdown-item" href="{{ route('incident', 'assigned today') }}">Assigned Today</a></li>
                            <li><a class="dropdown-item" href="{{ route('incident', 'all incidents') }}">All Incidents</a></li>
                        </ul>
                    </ul>

                    @if ( (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                        <a href=" {{route('incident.create')}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Create Incident</a>
                    @endif
                    <button type="button" class="btn btn-outline-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <span><i class="fa-solid fa-magnifying-glass"></i></span>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">

        <!-- Show searched keywords -->
        @isset($searchKeyword)
            <span class="text-secondary fst-italic">Search results for "{{$searchKeyword}}"
                @isset($searchDate)
                    on "{{ \Carbon\Carbon::parse($searchDate)->format('m/d/Y') }}"
                @endisset
            </span>
        @endisset

        @if ($incidents->count())
            @foreach ($incidents as $incident)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-capitalize text-center"><span class="fs-5 fw-bold">{{$incident->caller_first_name}} {{$incident->caller_last_name}}</span></li>
                                        <li class="">INCIDENT{{$incident->id}}<span class="fs-5">|</span> 

                                            <!-- Check if incident is assigned to a response team or not -->
                                            @isset($incident->response_team_id)
                                                <span class="text-success fw-semibold">Assigned</span>
                                            @else
                                                <span class="text-danger fw-semibold">Unassigned</span>
                                            @endisset 
                                        </li>
                                        <li class="text-capitalize">{{$incident->nature_of_call}} <span class="fs-5">&middot;</span> {{$incident->incident_type}}</li>
                                        <li class="name-space">{{$incident->caller_number}}</li>
                                        <li class="fst-italic"><small>Added {{$incident->created_at->diffForHumans()}}</small></li>
                                        <li class="mt-2"><a href="{{route('incident.show', $incident->id)}}" class="btn btn-outline-primary btn-sm d-block">View Incident</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="d-flex">
                {{ $incidents->links('pagination::simple-bootstrap-5') }}
            </div>
            
        @else
            <hr>
            <div class="col-md-12 text-center">
                <span class="text-secondary my-5">Nothing to show</span>
            </div>
        @endif        
    </div>

    <!-- Modal -->
    <div class="modal fade" id="searchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="searchModalLabel">Search Incidents</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form method="POST" action="{{route('incident.search')}}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="search_name" class="col-md-4 col-form-label text-md-end">Caller Name</label>
                            <div class="col-md-6">
                                <input id="search_name" type="text" class="form-control @error('search_name') is-invalid @enderror" name="search_name" 
                                    value="{{ old('search_name') }}" autocomplete="search_name" autofocus>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
                            <div class="col-md-6">
                                <select class="form-select text-capitalize" id="searchStatus" name="status" class="form-control @error('status') is-invalid @enderror" onchange="selectAll()"> 
                                    <option class="text-capitalize" value="incidents today" {{ $status == 'incidents today' ? 'selected' : ''}} >incidents today</option>
                                    <option class="text-capitalize" value="unassigned today" {{ $status == 'unassigned today' ? 'selected' : ''}} >unassigned today</option>
                                    <option class="text-capitalize" value="assigned today" {{ $status == 'assigned today' ? 'selected' : ''}} >assigned today</option>
                                    <option class="text-capitalize" value="all incidents" {{ $status == 'all incidents' ? 'selected' : ''}}>all incidents</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="search_date" class="col-md-4 col-form-label text-md-end">Date</label>
                            <div class="col-md-6">
                                <input id="search_date" type="date" class="form-control @error('search_date') is-invalid @enderror" name="search_date" 
                                    value="{{ old('search_date') }}" autocomplete="search_date" autofocus disabled>
                            </div>
                        </div>
                    
                        <input type="hidden" id="searchedQuery" name="searchedQuery" value="true">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function selectAll() {
            var x = document.getElementById('searchStatus').value;
            if(x == 'all incidents'){
                document.getElementById('search_date').disabled = false;
                document.getElementById('search_date').required = true;
            }else{
                document.getElementById('search_date').disabled = true; 
                document.getElementById('search_date').required = false;
            }
        }
    </script>
@endpush