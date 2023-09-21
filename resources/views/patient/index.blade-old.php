@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-capitalize">{{ ($status) ?? 'all patients'}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('patient') }}">All Patients</a></li>
                            <li><a class="dropdown-item" href="{{ route('patient', 'ongoing') }}">Ongoing</a></li>
                            <li><a class="dropdown-item" href="{{ route('patient', 'completed') }}">Completed</a></li>
                        </ul>
                    </ul>
                    
                    <button type="button" class="btn btn-outline-secondary text-decoration-none me-1" data-bs-toggle="modal" data-bs-target="#reportModal">
                        <span><i class="fa-regular fa-calendar"></i></span>
                    </button>
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

        <!-- Show searched keywords -->
        @isset($reportDate)
            <span class="text-secondary fst-italic">Search results for "{{$reportDate}}"</span>
        @endisset 
        
        @if ($patients->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Conscious?</th>
                        <th scope="col">Sex</th>
                        <th scope="col">Age</th>
                        <th scope="col">Caller</th>
                        <th scope="col">Added</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <th scope="row">
                                <!-- Patient ID -->
                                PATIENT{{$patient->id}}
                            </th>
                            <td>
                                <!-- Patient Name -->
                                @if($patient->patient_first_name || $patient->patient_last_name)
                                    {{$patient->patient_first_name}} {{$patient->patient_last_name}}
                                @else
                                    <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                @endif
                            </td>
                            <td>
                                <!-- Patient Status -->
                                @isset($patient->patient_refusals)
                                    @if ($patient->completed_at)
                                        <span class="text-success fw-semibold">Completed</span>
                                    @elseif ($patient->patient_refused_at)
                                        <span class="text-danger fw-semibold">Patient refused transport</span>
                                    @elseif ($patient->patient_refusals->count() > 0)
                                        <span class="text-danger fw-semibold">Refused by hospital</span>
                                    @else
                                        <span class="text-warning text-capitalize fw-semibold">Ongoing</span>
                                    @endif
                                @else
                                    @if ($patient->completed_at)
                                        <span class="text-success fw-semibold">Completed</span>
                                    @elseif ($patient->patient_refused_at)
                                        <span class="text-danger fw-semibold">Patient refused transport</span>
                                    @else
                                        <span class="text-warning text-capitalize fw-semibold">Ongoing</span>
                                    @endif
                                @endisset
                            </td>
                            <td>
                                <!-- Patient Concious? -->
                                @if($patient->patient_first_name || $patient->patient_mid_name || $patient->patient_last_name)
                                    <span class="text-success">Yes</span>
                                @else
                                    <span class="text-danger">No</span>
                                @endif
                            </td>
                            <td class="text-capitalize">
                                <!-- Patient Sex -->
                                @if($patient->sex)
                                    {{$patient->sex}}
                                @else
                                    <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                @endif  
                            </td>
                            <td>
                                <!-- Patient Age -->
                                @if($patient->age)
                                    @isset($patient->birthday)
                                        <span>{{\Carbon\Carbon::parse($patient->birthday)->diff(\Carbon\Carbon::now())->format('%y')}}</span>
                                    @else
                                        <span>{{$patient->age}}</span>
                                    @endisset
                                @else
                                    <small class="fst-italic text-lowercase text-secondary">(Not set)</small>
                                @endif
                            </td>
                            <td>
                                <!-- Caller -->
                                @if ($patient->caller_first_name)
                                    {{$patient->caller_first_name}} 
                                    {{$patient->caller_mid_name}} 
                                    {{$patient->caller_last_name}}
                                @else
                                    {{$patient->incident->caller_first_name}} 
                                    {{$patient->incident->caller_mid_name}} 
                                    {{$patient->incident->caller_last_name}}
                                @endif
                                <br>
                                <small>
                                    @if ($patient->caller_number)
                                        {{$patient->caller_number}}
                                    @else
                                        {{$patient->incident->caller_number}}
                                    @endif
                                </small>
                            </td>
                            <td>
                                <!-- Added -->
                                {{ \Carbon\Carbon::parse($patient->created_at)->format('M d, Y g:i:s A') }} <br>
                                <small>Added {{ \Carbon\Carbon::parse($patient->created_at)->diffForHumans() }}</small>
                            </td>
                            <td>
                                <a href="{{route('incident.show', $patient->incident_id)}}" class="btn btn-outline-primary btn-sm d-block mb-1">View IR</a>
                                <a href="{{route('pcr.show', $patient->id)}}" class="btn btn-primary btn-sm d-block">View PCR</a>
                            </td>
                        </tr>
                    @endforeach
                    <div class="d-flex">
                        {{ $patients->links('pagination::simple-bootstrap-5') }}
                    </div>
                </tbody>
            </table>
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
                    <h1 class="modal-title fs-5" id="searchModalLabel">Search Patients</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form method="POST" action="{{route('patient.search')}}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="search_name" class="col-md-4 col-form-label text-md-end">Name</label>
                            <div class="col-md-6">
                                <input id="search_name" type="text" class="form-control @error('search_name') is-invalid @enderror" name="search_name" 
                                    value="{{ old('search_name') }}" autocomplete="search_name" autofocus placeholder="Patient or Caller">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
                            <div class="col-md-6">
                                <select class="form-select text-capitalize" id="searchStatus" name="status" class="form-control @error('status') is-invalid @enderror" onchange="selectAll()">
                                    <option class="text-capitalize" value="all patients" >all patients</option>
                                    <option class="text-capitalize" value="ongoing" selected>ongoing</option>
                                    <option class="text-capitalize" value="completed" >completed</option>
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

    <div class="modal fade" id="reportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reportModalLabel">Show by Month/Year</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form method="POST" action="{{route('patient.search')}}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="search_month" class="col-md-4 col-form-label text-md-end">Date: </label>
                            <div class="col-md-6">
                                <input id="search_month" type="month" class="form-control @error('search_month') is-invalid @enderror" name="search_month" 
                                    value="{{ old('search_month') }}" autofocus required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="row mb-3">
                                <label for="month_year" class="col-md-4 col-form-label text-md-end">Search for:</label>

                                <div class="col-md-6 mt-1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="month_year" id="month_year1" value="year_month" checked>
                                        <label class="form-check-label" for="month_year1" style="text-transform: capitalize">
                                            year & month
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="month_year" id="month_year2" value="year_only">
                                        <label class="form-check-label" for="month_year2" style="text-transform: capitalize">
                                            year only
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <input type="hidden" id="reportQuery" name="reportQuery" value="true">

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
            if((x == 'all patients') || (x == 'completed')){
                document.getElementById('search_date').disabled = false;
                document.getElementById('search_date').required = true;
            }else{
                document.getElementById('search_date').disabled = true; 
                document.getElementById('search_date').required = false;
            }
        }
    </script>
@endpush