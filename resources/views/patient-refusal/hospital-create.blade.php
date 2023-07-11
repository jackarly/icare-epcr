@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3 fw-bold">Create Hospital Refusal</h5>

            <div class="card">
                <div class="card-header">Hospital Refusal</div>
                    
                <div class="card-body">
                    <form method="POST" action="{{ route('refusal.hospital.store', $patient->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="hospital_reasons" class="col-md-4 col-form-label text-md-end">Due to the following reasons:</label>

                            <div class="col-md-6">
                                <textarea id="hospital_reasons" type="text" class="form-control @error('hospital_reasons') is-invalid @enderror" name="hospital_reasons" required autocomplete="hospital_reasons" autofocus>{{ old('hospital_reasons')}}</textarea>

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
                                <input id="hospital_nurse_doctor" type="text" class="form-control @error('hospital_nurse_doctor') is-invalid @enderror" name="hospital_nurse_doctor" value="{{ old('hospital_nurse_doctor')}}" required autocomplete="hospital_nurse_doctor" autofocus>

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
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection