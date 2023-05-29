@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <h4 class="text-center mb-3">Create Patient</h4>
            <div class="card">
                <div class="card-header">Patient Info</div>
                    
                <div class="card-body">
                <form method="POST" action="{{ route('patient.store', $incident->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="ppcr_color" class="col-md-4 col-form-label text-md-end" >PPCR Color</label>

                            <div class="col-md-6 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ppcr_color" id="ppcr_color1" value="red" autofocus>
                                    <label class="form-check-label" for="ppcr_color1" style="text-transform: capitalize">
                                        red
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ppcr_color" id="ppcr_color2" value="yellow">
                                    <label class="form-check-label" for="ppcr_color2" style="text-transform: capitalize">
                                        yellow
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ppcr_color" id="ppcr_color3" value="green">
                                    <label class="form-check-label" for="ppcr_color3" style="text-transform: capitalize">
                                        green
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ppcr_color" id="ppcr_color4" value="black">
                                    <label class="form-check-label" for="ppcr_color4" style="text-transform: capitalize">
                                        black
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="patient_name" class="col-md-4 col-form-label text-md-end">Patient Name</label>

                            <div class="col-md-2">
                                <input id="patient_first_name" type="text" class="form-control @error('patient_first_name') is-invalid @enderror" name="patient_first_name" value="{{ old('patient_first_name') }}" required autocomplete="patient_first_name" autofocus placeholder="First Name">
                                @error('patient_first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <input id="patient_mid_name" type="text" class="form-control @error('patient_mid_name') is-invalid @enderror" name="patient_mid_name" value="{{ old('patient_mid_name') }}" autocomplete="patient_mid_name" autofocus placeholder="Mid Name">
                                @error('patient_mid_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <input id="patient_last_name" type="text" class="form-control @error('patient_last_name') is-invalid @enderror" name="patient_last_name" value="{{ old('patient_last_name') }}" required autocomplete="patient_last_name" autofocus placeholder="Last Name">
                                @error('patient_last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="age" class="col-md-4 col-form-label text-md-end">Age</label>

                            <div class="col-md-6">
                                <input id="age" type="number" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="age" autofocus>

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birthday" class="col-md-4 col-form-label text-md-end">Birthday</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') }}"  autocomplete="birthday" autofocus>

                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sex" class="col-md-4 col-form-label text-md-end">Sex</label>

                            <div class="col-md-6 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="sex1" value="male">
                                    <label class="form-check-label" for="sex1" style="text-transform: capitalize">
                                        male
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="sex2" value="female">
                                    <label class="form-check-label" for="sex2" style="text-transform: capitalize">
                                        female
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_no" class="col-md-4 col-form-label text-md-end">Contact No</label>

                            <div class="col-md-6">
                                <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" required autocomplete="contact_no" autofocus>

                                @error('contact_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>

                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus></textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                        
                        <small class="text-danger">Incident ID: {{$incident->id}} </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection