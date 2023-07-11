@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center fw-bold mb-3">Create Incident Report</h4>
            <div class="card">
                <div class="card-header">Incident Report</div>
                    
                <div class="card-body">
                <form method="POST" action="{{ route('incident.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="nature_of_call" class="col-md-4 col-form-label text-md-end">Nature of Call</label>

                            <div class="col-md-6 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nature_of_call" id="nature_of_call1" value="emergency" autofocus>
                                    <label class="form-check-label" for="nature_of_call1">
                                        Emergency
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nature_of_call" id="nature_of_call2" value="non-emergency">
                                    <label class="form-check-label" for="nature_of_call2">
                                        Non-Emergency
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="incident_type" class="col-md-4 col-form-label text-md-end">Incident Type</label>

                            <div class="col-md-6 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="incident_type" id="incident_type1" value="medical">
                                    <label class="form-check-label" for="incident_type1">
                                        Medical
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="incident_type" id="incident_type2" value="trauma">
                                    <label class="form-check-label" for="incident_type2">
                                        Trauma
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="incident_location" class="col-md-4 col-form-label text-md-end">Incident Location</label>

                            <div class="col-md-6">
                                <textarea id="incident_location" class="form-control @error('incident_location') is-invalid @enderror" name="incident_location" value="{{ old('incident_location') }}" required autocomplete="incident_location" autofocus></textarea>

                                @error('incident_location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="area_type" class="col-md-4 col-form-label text-md-end">Area Type</label>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="area_type" id="area_type1" value="residential">
                                    <label class="form-check-label" for="area_type1">
                                        Residential
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="area_type" id="area_type2" value="commercial">
                                    <label class="form-check-label" for="area_type2">
                                        Commercial
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="area_type" id="area_type3" value="recreation">
                                    <label class="form-check-label" for="area_type3">
                                        Recreation
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="area_type" id="area_type4" value="road/street">
                                    <label class="form-check-label" for="area_type4">
                                        Road/Street
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="area_type" id="area_type5" value="other">
                                    <label class="form-check-label" for="area_type5">
                                        Other
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="caller_name" class="col-md-4 col-form-label text-md-end">Caller Name</label>

                            <div class="col-md-2">
                                <input id="caller_first_name" type="text" class="form-control @error('caller_first_name') is-invalid @enderror" name="caller_first_name" value="{{ old('caller_first_name') }}" required autocomplete="caller_first_name" autofocus placeholder="First Name">
                                @error('caller_first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <input id="caller_mid_name" type="text" class="form-control @error('caller_mid_name') is-invalid @enderror" name="caller_mid_name" value="{{ old('caller_mid_name') }}"autocomplete="caller_mid_name" autofocus placeholder="Mid Name">
                                @error('caller_mid_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <input id="caller_last_name" type="text" class="form-control @error('caller_last_name') is-invalid @enderror" name="caller_last_name" value="{{ old('caller_last_name') }}" required autocomplete="caller_last_name" autofocus placeholder="Last Name">
                                @error('caller_last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="caller_number" class="col-md-4 col-form-label text-md-end">Caller Number</label>

                            <div class="col-md-6">
                                <input id="caller_number" type="text" class="form-control @error('caller_number') is-invalid @enderror" name="caller_number" value="{{ old('caller_number') }}" required autocomplete="caller_number" autofocus>

                                @error('caller_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_of_persons_involved" class="col-md-4 col-form-label text-md-end">No. of Persons Involved</label>

                            <div class="col-md-6">
                                <select class="form-select text-capitalize" name="no_of_persons_involved" class="form-control @error('no_of_persons_involved') is-invalid @enderror">
                                    <option class="text-start" value="1" selected>1</option>
                                    @for ($i = 2; $i < 11; $i++)
                                        <option class="text-start" value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="incident_details" class="col-md-4 col-form-label text-md-end">Incident Details</label>
                            <div class="col-md-6">
                                <select class="form-select text-capitalize" id="incidentDetails" name="incident_details" class="form-control @error('incident_details') is-invalid @enderror" onchange="incidentOthers()"> 
                                    <option class="text-center" value="" selected >--- Select One ---</option>
                                    <option class="text-start" value="fire" >fire</option>
                                    <option class="text-start" value="injury" >injury</option>
                                    <option class="text-start" value="natural disaster" >natural disaster</option>
                                    <option class="text-start" value="traffic collision">traffic collision</option>
                                    <option class="text-start" value="others" >others</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <textarea id="other_incident_details" class="form-control @error('other_incident_details') is-invalid @enderror" name="other_incident_details" value="{{ old('other_incident_details') }}" autocomplete="other_incident_details" placeholder="Incident Details - Other" disabled></textarea>

                                @error('other_incident_details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="injuries_details" class="col-md-4 col-form-label text-md-end">Nature & Extent of Injuries</label>

                            <div class="col-md-6">
                                <select class="form-select text-capitalize" id="injuriesDetails" name="injuries_details" class="form-control @error('injuries_details') is-invalid @enderror" onchange="injuriesOthers()"> 
                                    <option class="text-center" value="" selected >--- Select One ---</option>
                                    <option class="text-start" value="minor" >minor</option>
                                    <option class="text-start" value="moderate" >moderate</option>
                                    <option class="text-start" value="critical" >critical</option>
                                    <option class="text-start" value="others" >others</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <textarea id="other_injuries_details" class="form-control @error('other_injuries_details') is-invalid @enderror" name="other_injuries_details" value="{{ old('other_injuries_details') }}" required autocomplete="other_injuries_details" placeholder="Injury Details - Other" disabled></textarea>

                                @error('other_injuries_details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-grid">
                                <button type="submit" class="btn btn-primary" name="saveBtn" value="saveOnly">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-2">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function incidentOthers() {
            var x = document.getElementById('incidentDetails').value;
            if((x == 'fire') || (x == 'injury') || (x == 'natural disaster') || (x == 'traffic collision')){
                document.getElementById('other_incident_details').disabled = true;
            }else{
                document.getElementById('other_incident_details').disabled = false;
            }
        }

        function injuriesOthers() {
            var x = document.getElementById('injuriesDetails').value;
            if((x == 'minor') || (x == 'moderate') || (x == 'critical')){
                document.getElementById('other_injuries_details').disabled = true;
            }else{
                document.getElementById('other_injuries_details').disabled = false;
            }
        }
    </script>
@endpush