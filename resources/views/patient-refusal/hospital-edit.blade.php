@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3 fw-bold">Update Hospital Refusal</h5>

            <div class="card">
                <div class="card-header">Hospital Refusal</div>
                    
                <div class="card-body">
                    <form method="POST" action="{{ route('refusal.hospital.update', $patientRefusal->id) }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="hospital_reasons" class="col-md-4 col-form-label text-md-end">Due to the following reasons:</label>

                            <div class="col-md-6">
                                <textarea id="hospital_reasons" type="text" class="form-control @error('hospital_reasons') is-invalid @enderror" name="hospital_reasons" required autocomplete="hospital_reasons" autofocus>{{ old('hospital_reasons') ?? $patientRefusal->hospital_reasons}} </textarea>

                                @error('hospital_reasons')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hospital_nurse_doctor" class="col-md-4 col-form-label text-md-end">Nurse/Physician on duty</label>

                            <div class="col-md-6">
                                <input id="hospital_nurse_doctor" type="text" class="form-control @error('hospital_nurse_doctor') is-invalid @enderror" name="hospital_nurse_doctor" value="{{ old('hospital_nurse_doctor') ?? $patientRefusal->hospital_nurse_doctor}}" required autocomplete="hospital_nurse_doctor" autofocus>

                                @error('patient_refusal_witness')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Update Refusal
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-1">
                        <div class="col-md-6 offset-md-4">
                            <form method="POST" action="{{route('refusal.hospital.destroy',  $patientRefusal->id)}}">
                                @csrf
                                @method('PUT')
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-danger">
                                        Remove Refusal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection