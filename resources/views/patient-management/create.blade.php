@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3 fw-bold">Create Patient Management</h5>
            <div class="card">
                <div class="card-header">Patient Management</div>
                    
                <div class="card-body">
                <form method="POST" action="{{ route('management.store', $patient->id) }}">
                        @csrf

                        <div class="row">
                            <label for="airway_breathing" class="col-md-4 col-form-label text-md-end">Airway & Breathing</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="airway_breathing" id="airway_breathing1" value="open airway" autofocus{{(old('airway_breathing') == 'open airway') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway_breathing1" style="text-transform: capitalize">
                                        open airway
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="airway_breathing" id="airway_breathing2" value="suction"{{(old('airway_breathing') == 'suction') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway_breathing2" style="text-transform: capitalize">
                                        suction
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="airway_breathing" id="airway_breathing3" value="BGM"{{(old('airway_breathing') == 'BGM') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway_breathing3" style="text-transform: capitalize">
                                        BGM
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="airway_breathing" id="airway_breathing4" value="airway adjuncts"{{(old('airway_breathing') == 'airway adjuncts') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway_breathing4" style="text-transform: capitalize">
                                        airway adjuncts
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="airway_breathing" id="airway_breathing5" value="facemask"{{(old('airway_breathing') == 'facemask') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway_breathing5" style="text-transform: capitalize">
                                        facemask
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="airway_breathing" id="airway_breathing6" value="nasal cannula" {{(old('airway_breathing') == 'nasal cannula') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway_breathing6" style="text-transform: capitalize">
                                        nasal cannula
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="airway_breathing" id="airway_breathing7" value="NRB mask"{{(old('airway_breathing') == 'NRB mask') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="airway_breathing7" style="text-transform: capitalize">
                                        NRB mask
                                    </label>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <label for="circulation" class="col-md-4 col-form-label text-md-end">Circulation</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="circulation" id="circulation1" value="chest compression"{{(old('circulation') == 'chest compression') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="circulation1" style="text-transform: capitalize">
                                        chest compression
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="circulation" id="circulation2" value="defibrillation"{{(old('circulation') == 'defibrillation') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="circulation2" style="text-transform: capitalize">
                                        defibrillation
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="circulation" id="circulation3" value="bleeding control"{{(old('circulation') == 'bleeding control') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="circulation3" style="text-transform: capitalize">
                                        bleeding control
                                    </label>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <label for="wound_burn_care" class="col-md-4 col-form-label text-md-end">Wound/Burn Care</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="wound_burn_care" id="wound_burn_care1" value="cleaning & disinfecting"{{(old('wound_burn_care') == 'cleaning & disinfecting') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="wound_burn_care1" style="text-transform: capitalize">
                                        cleaning & disinfecting
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="wound_burn_care" id="wound_burn_care2" value="dressing & bandaging"{{(old('wound_burn_care') == 'dressing & bandaging') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="wound_burn_care2" style="text-transform: capitalize">
                                        dressing & bandaging
                                    </label>
                                </div>
                                <hr>
                            </div>
                        </div>


                        <div class="row">
                            <label for="immobilization" class="col-md-4 col-form-label text-md-end">Immobilization</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="immobilization" id="immobilization1" value="c-spine control"{{(old('immobilization') == 'c-spine control') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="immobilization1" style="text-transform: capitalize">
                                        c-spine control
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="immobilization" id="immobilization2" value="spineboard"{{(old('immobilization') == 'spineboard') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="immobilization2" style="text-transform: capitalize">
                                        spineboard
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="immobilization" id="immobilization3" value="KED"{{(old('immobilization') == 'KED') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="immobilization3" style="text-transform: capitalize">
                                        KED
                                    </label>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="others1" class="col-md-4 col-form-label text-md-end">Others</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="others1" id="others11" value="positioning" {{(old('others1') == 'positioning') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="others11" style="text-transform: capitalize">
                                        positioning
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="others1" id="others12" value="cold/warm compress"{{(old('others1') == 'cold/warm compress') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="others12" style="text-transform: capitalize">
                                        cold/warm compress
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <textarea id="others2" type="text" class="form-control @error('others2') is-invalid @enderror" name="others2"autocomplete="others2">{{ old('others2') }}</textarea>

                                @error('others2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="receiving_facility" class="col-md-4 col-form-label text-md-end">Receiving Facility</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="receiving_facility" id="receiving_facility1" value="hospital" checked{{(old('receiving_facility') == 'hospital') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="receiving_facility1" style="text-transform: capitalize">
                                        hospital
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="receiving_facility" id="receiving_facility2" value="clinic"{{(old('receiving_facility') == 'clinic') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="receiving_facility2" style="text-transform: capitalize">
                                        clinic
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="receiving_facility" id="receiving_facility3" value="home"{{(old('receiving_facility') == 'home') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="receiving_facility3" style="text-transform: capitalize">
                                        home
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="receiving_facility" id="receiving_facility4" value="terminal"{{(old('receiving_facility') == 'terminal') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="receiving_facility4" style="text-transform: capitalize">
                                        terminal
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="receiving_facility" id="receiving_facility5" value="institution"{{(old('receiving_facility') == 'institution') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="receiving_facility5" style="text-transform: capitalize">
                                        institution
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="facility_assigned" class="col-md-4 col-form-label text-md-end">Name of Facility</label>

                            <div class="col-md-6">
                                @if ($hospitals->count())
                                    <select class="form-select" aria-label="Default select example" name="facility_assigned" class="form-control @error('facility_assigned') is-invalid @enderror" required>
                                        <option class="text-center" value="" selected disabled>--- Select Hospital ---</option>
                                        @foreach ($hospitals as $hospital)
                                            <option class="text-capitalize" value="{{$hospital->id}}">{{$hospital->hospital_abbreviation . ' - '}}{{$hospital->hospital_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('facility_assigned')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @else
                                    <input type="text" class="form-control" name="" id="" disabled placeholder="No hospital available">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <label for="timings" class="col-md-4 col-form-label text-md-end">Timings</label>

                            <div class="col-md-6">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <td>Arrival</td>
                                            <td>Handover</td>
                                            <td>Clear</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><div class="input-group input-group-sm"><input type="text" class="form-control" name="arrival" value="{{ old('arrival') }}"></div></td>
                                            <td><div class="input-group input-group-sm"><input type="text" class="form-control" name="handover" value="{{ old('handover') }}"></div></td>
                                            <td><div class="input-group input-group-sm"><input type="text" class="form-control" name="clear" value="{{ old('clear') }}"></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="narrative" class="col-md-4 col-form-label text-md-end">Narrative</label>

                            <div class="col-md-6">
                                <textarea id="narrative" class="form-control @error('narrative') is-invalid @enderror" name="narrative" autocomplete="narrative" autofocus>{{ old('narrative') }}</textarea>

                                @error('narrative')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="receiving_provider" class="col-md-4 col-form-label text-md-end">Receiving Provider</label>

                            <div class="col-md-6">
                                <input id="receiving_provider" type="text" class="form-control @error('receiving_provider') is-invalid @enderror" name="receiving_provider" value="{{ old('receiving_provider') }}" required autocomplete="receiving_provider" autofocus>

                                @error('receiving_provider')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="provider_position" class="col-md-4 col-form-label text-md-end">Provider Position</label>

                            <div class="col-md-6">
                                <input id="provider_position" type="text" class="form-control @error('provider_position') is-invalid @enderror" name="provider_position" value="{{ old('provider_position') }}" autocomplete="provider_position" autofocus>

                                @error('provider_position')
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
                        
                        
                        <small class="text-danger">Reminder:Add Observations & Canvas</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection