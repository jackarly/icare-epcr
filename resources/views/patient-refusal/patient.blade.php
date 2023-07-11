@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if ($patient->patient_refused_at)
                <h4 class="text-center mb-3 fw-bold">Update Patient Refusal</h5>
            @else
                <h4 class="text-center mb-3 fw-bold">Create Patient Refusal</h5>
            @endif
            <div class="card">
                <div class="card-header">Patient Refusal</div>
                    
                <div class="card-body">
                    <form method="POST" action="{{ route('refusal.store', $patient->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <p class="mb-0" style="text-align: justify">I, the undersigned have been advised that the medical assistance on my behalf is necessary and that refusal of said medical assistance and/or transportation for further treatment may result in death, or imperil my health condition. Nevertheless, I refuse to accept treatment and/or transport and assume all risk and consequences of my decision and release the Philippine Red Cross from any liability arising from my refusal.</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="patient_refusal_witness" class="col-md-4 col-form-label text-md-end">Witness</label>

                            <div class="col-md-6">
                                <input id="patient_refusal_witness" type="text" class="form-control @error('patient_refusal_witness') is-invalid @enderror" name="patient_refusal_witness" value="{{ old('patient_refusal_witness') ?? $patient->patient_refusal_witness }}" required autocomplete="patient_refusal_witness" autofocus>

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