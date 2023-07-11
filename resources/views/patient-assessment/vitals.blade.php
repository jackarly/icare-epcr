@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-6">
            <h4 class="text-center mb-3 fw-bold">Update Patient Assessment</h5>
            <div class="card">
                <div class="card-header">Vital Signs</div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="text-secondary text-center">
                                <th scope="col" style="width:16%">Action</th>
                                <th scope="col" style="width:14%">Time</th>
                                <th scope="col" style="width:14%">B/P</th>
                                <th scope="col" style="width:14%">HR</th>
                                <th scope="col" style="width:14%">RR</th>
                                <th scope="col" style="width:14%">O2 Sat</th>
                                <th scope="col" style="width:14%">Glucose</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-secondary text-center">
                                <td style="width:16%">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary btn-sm custom-rounded-btn" data-bs-toggle="modal" data-bs-target="#vitals1Modal">
                                            <span>Update row</span>
                                        </button>
                                    </div>
                                </td>
                                <td style="width:14%">
                                    <!-- Set default value to preserve cell height -->
                                    @if ($patient_assessment->vital_time1)
                                        <small>{{$patient_assessment->vital_time1}}</small>
                                    @else
                                        <small class="fst-italic text-light">(not set)</small>
                                    @endif
                                </td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_bp1}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_hr1}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_rr1}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_o2sat1}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_glucose1}}</small></td>
                            </tr>
                            <tr class="text-secondary text-center">
                                <td style="width:16%">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary btn-sm custom-rounded-btn" data-bs-toggle="modal" data-bs-target="#vitals2Modal">
                                            <span>Update row</span>
                                        </button>
                                    </div>
                                </td>
                                <td style="width:14%">
                                    <!-- Set default value to preserve cell height -->
                                    @if ($patient_assessment->vital_time2)
                                        <small>{{$patient_assessment->vital_time2}}</small>
                                    @else
                                        <small class="fst-italic text-light">(not set)</small>
                                    @endif
                                </td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_bp2}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_hr2}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_rr2}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_o2sat2}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_glucose2}}</small></td>
                            </tr>
                            <tr class="text-secondary text-center">
                                <td style="width:16%">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary btn-sm custom-rounded-btn" data-bs-toggle="modal" data-bs-target="#vitals3Modal">
                                            <span>Update row</span>
                                        </button>
                                    </div>
                                </td>
                                <td style="width:14%">
                                    <!-- Set default value to preserve cell height -->
                                    @if ($patient_assessment->vital_time3)
                                    <small>{{$patient_assessment->vital_time3}}</small>
                                    @else
                                        <small class="fst-italic text-light">(not set)</small>
                                    @endif
                                </td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_bp3}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_hr3}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_rr3}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_o2sat3}}</small></td>
                                <td style="width:14%"><small>{{$patient_assessment->vital_glucose3}}</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{route('pcr.show', $patient_assessment->patient_id)}}" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-arrow-left"></i> Go Back
                </a>
            </div>
        </div>
    </div>

    <!-- Modal can only be accessed by user_type comcen or admin -->
    @if ( (auth()->user()->user_type == 'ambulance') ||(auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
        <div class="modal fade" id="vitals1Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vitals1ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="vitals1ModalLabel">Vital Signs 1</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form method="POST" action="{{ route('assessment.vitals.update', $patient_assessment->id)}}">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <label for="vital_bp1" class="col-md-4 col-form-label text-md-end">B/P</label>
                                <div class="col-md-6">
                                    <input id="vital_bp1" type="text" class="form-control @error('vital_bp1') is-invalid @enderror" name="vital_bp1" 
                                        value="{{ old('vital_bp1') ?? $patient_assessment->vital_bp1 }}" autocomplete="vital_bp1" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_hr1" class="col-md-4 col-form-label text-md-end">HR</label>
                                <div class="col-md-6">
                                    <input id="vital_hr1" type="text" class="form-control @error('vital_hr1') is-invalid @enderror" name="vital_hr1" 
                                        value="{{ old('vital_hr1') ?? $patient_assessment->vital_hr1 }}" autocomplete="vital_hr1" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_rr1" class="col-md-4 col-form-label text-md-end">RR</label>
                                <div class="col-md-6">
                                    <input id="vital_rr1" type="text" class="form-control @error('vital_rr1') is-invalid @enderror" name="vital_rr1" 
                                        value="{{ old('vital_rr1') ?? $patient_assessment->vital_rr1 }}" autocomplete="vital_rr1" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_o2sat1" class="col-md-4 col-form-label text-md-end">O2 Sat</label>
                                <div class="col-md-6">
                                    <input id="vital_o2sat1" type="text" class="form-control @error('vital_o2sat1') is-invalid @enderror" name="vital_o2sat1" 
                                        value="{{ old('vital_o2sat1') ?? $patient_assessment->vital_o2sat1 }}" autocomplete="vital_o2sat1" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_glucose1" class="col-md-4 col-form-label text-md-end">Glucose</label>
                                <div class="col-md-6">
                                    <input id="vital_glucose1" type="text" class="form-control @error('vital_glucose1') is-invalid @enderror" name="vital_glucose1" 
                                        value="{{ old('vital_glucose1') ?? $patient_assessment->vital_glucose1 }}" autocomplete="vital_glucose1" autofocus>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="vitals_row" name="vitals_row" value="vitals1">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Modal can only be accessed by user_type comcen or admin -->
    @if ( (auth()->user()->user_type == 'ambulance') ||(auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
        <div class="modal fade" id="vitals2Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vitals2ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="vitals2ModalLabel">Vital Signs 2</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form method="POST" action="{{ route('assessment.vitals.update', $patient_assessment->id)}}">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <label for="vital_bp2" class="col-md-4 col-form-label text-md-end">B/P</label>
                                <div class="col-md-6">
                                    <input id="vital_bp2" type="text" class="form-control @error('vital_bp2') is-invalid @enderror" name="vital_bp2" 
                                        value="{{ old('vital_bp2') ?? $patient_assessment->vital_bp2 }}" autocomplete="vital_bp2" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_hr2" class="col-md-4 col-form-label text-md-end">HR</label>
                                <div class="col-md-6">
                                    <input id="vital_hr2" type="text" class="form-control @error('vital_hr2') is-invalid @enderror" name="vital_hr2" 
                                        value="{{ old('vital_hr2') ?? $patient_assessment->vital_hr2 }}" autocomplete="vital_hr2" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_rr2" class="col-md-4 col-form-label text-md-end">RR</label>
                                <div class="col-md-6">
                                    <input id="vital_rr2" type="text" class="form-control @error('vital_rr2') is-invalid @enderror" name="vital_rr2" 
                                        value="{{ old('vital_rr2') ?? $patient_assessment->vital_rr2 }}" autocomplete="vital_rr2" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_o2sat2" class="col-md-4 col-form-label text-md-end">O2 Sat</label>
                                <div class="col-md-6">
                                    <input id="vital_o2sat2" type="text" class="form-control @error('vital_o2sat2') is-invalid @enderror" name="vital_o2sat2" 
                                        value="{{ old('vital_o2sat2') ?? $patient_assessment->vital_o2sat2 }}" autocomplete="vital_o2sat2" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_glucose2" class="col-md-4 col-form-label text-md-end">Glucose</label>
                                <div class="col-md-6">
                                    <input id="vital_glucose2" type="text" class="form-control @error('vital_glucose2') is-invalid @enderror" name="vital_glucose2" 
                                        value="{{ old('vital_glucose2') ?? $patient_assessment->vital_glucose2 }}" autocomplete="vital_glucose2" autofocus>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="vitals_row" name="vitals_row" value="vitals2">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Modal can only be accessed by user_type comcen or admin -->
    @if ( (auth()->user()->user_type == 'ambulance') ||(auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
        <div class="modal fade" id="vitals3Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vitals3ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="vitals3ModalLabel">Vital Signs 3</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form method="POST" action="{{ route('assessment.vitals.update', $patient_assessment->id)}}">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <label for="vital_bp3" class="col-md-4 col-form-label text-md-end">B/P</label>
                                <div class="col-md-6">
                                    <input id="vital_bp3" type="text" class="form-control @error('vital_bp3') is-invalid @enderror" name="vital_bp3" 
                                        value="{{ old('vital_bp3') ?? $patient_assessment->vital_bp3 }}" autocomplete="vital_bp3" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_hr3" class="col-md-4 col-form-label text-md-end">HR</label>
                                <div class="col-md-6">
                                    <input id="vital_hr3" type="text" class="form-control @error('vital_hr3') is-invalid @enderror" name="vital_hr3" 
                                        value="{{ old('vital_hr3') ?? $patient_assessment->vital_hr3 }}" autocomplete="vital_hr3" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_rr3" class="col-md-4 col-form-label text-md-end">RR</label>
                                <div class="col-md-6">
                                    <input id="vital_rr3" type="text" class="form-control @error('vital_rr3') is-invalid @enderror" name="vital_rr3" 
                                        value="{{ old('vital_rr3') ?? $patient_assessment->vital_rr3 }}" autocomplete="vital_rr3" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_o2sat3" class="col-md-4 col-form-label text-md-end">O2 Sat</label>
                                <div class="col-md-6">
                                    <input id="vital_o2sat3" type="text" class="form-control @error('vital_o2sat3') is-invalid @enderror" name="vital_o2sat3" 
                                        value="{{ old('vital_o2sat3') ?? $patient_assessment->vital_o2sat3 }}" autocomplete="vital_o2sat3" autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="vital_glucose3" class="col-md-4 col-form-label text-md-end">Glucose</label>
                                <div class="col-md-6">
                                    <input id="vital_glucose3" type="text" class="form-control @error('vital_glucose3') is-invalid @enderror" name="vital_glucose3" 
                                        value="{{ old('vital_glucose3') ?? $patient_assessment->vital_glucose3 }}" autocomplete="vital_glucose3" autofocus>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="vitals_row" name="vitals_row" value="vitals3">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection