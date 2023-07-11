@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3 fw-bold">Create Patient Observation</h5>
            <div class="card">
                <div class="card-header">Patient Observation</div>
                    
                <div class="card-body">
                    <form method="POST" action="{{ route('observation.store', $patient->id) }}">
                        @csrf

                        <div class="row mb-1">
                            <label for="observations" class="col-md-4 col-form-label text-md-end">Observations</label>
                            <div class="col-md-6">
                                <select class="form-select text-capitalize" id="selection_observations" name="selection_observations" class="form-control" onchange="PopulateObservations()">
                                    <option class="text-center" value="">--- Select Multiple ---</option>
                                    <option class="text-start" value="swelling of ">swelling of (PART OF BODY)</option>
                                    <option class="text-start" value="bleeding in ">bleeding in (PART OF BODY)</option>
                                    <option class="text-start" value="difficulty in ">difficulty in (MOVEMENTS)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <textarea id="observations" class="form-control @error('observations') is-invalid @enderror mt-1" name="observations" required autocomplete="observations" autofocus>{{ old('observations') }}</textarea>

                                @error('observations')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="wound" id="wound" value="1" >
                                            <label class="form-check-label text-capitalize" for="wound">
                                                W wound
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="dislocation" id="dislocation" value="1" >
                                            <label class="form-check-label text-capitalize" for="dislocation">
                                                d dislocation
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="fracture" id="fracture" value="1" >
                                            <label class="form-check-label text-capitalize" for="fracture">
                                                f fracture
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="numbness" id="numbness" value="1" >
                                            <label class="form-check-label text-capitalize" for="numbness">
                                                n numbness
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="swelling" id="swelling" value="1" >
                                            <label class="form-check-label text-capitalize" for="swelling">
                                                s swelling
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="rash" id="rash" value="1" >
                                            <label class="form-check-label text-capitalize" for="rash">
                                                r rash
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="burn" id="burn" value="1" >
                                            <label class="form-check-label text-capitalize" for="burn">
                                                b burn
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="age_group" class="col-md-4 col-form-label text-md-end">Age Group</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="age_group" id="age_group1" value="adult" onchange='showAdult(this);' checked>
                                    <label class="form-check-label" for="age_group1" style="text-transform: capitalize">
                                        adult
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="age_group" id="age_group2" value="pedia" onchange='showPedia(this);'>
                                    <label class="form-check-label" for="age_group2" style="text-transform: capitalize">
                                        pedia
                                    </label>
                                </div>

                                @error('burn_classification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row" id="showAdultChart" style="display:block">
                            <div class="col-md-6 offset-md-4">
                                <img src="{{ asset('/images/rule-9-adult.jpg') }}" alt="Rule 9 Adult" style="height: auto; width: 75%; object-fit: contain">
                            </div>
                        </div>

                        <div class="row" id="showPediaChart" style="display:none">
                            <div class="col-md-6 offset-md-4">
                                <img src="{{ asset('/images/rule-9-pedia.png') }}" alt="Rule 9 Pedia" style="height: auto; width: 75%; object-fit: contain">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <span>Back</span>
                                            <hr class="mt-0">
                                            <ul class="list-group list-group-flush custom-list">
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="back_head" id="back_head" value="true" >
                                                        <label class="form-check-label text-capitalize" for="back_head">
                                                            head
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="back_left_arm" id="back_left_arm" value="true" >
                                                        <label class="form-check-label text-capitalize" for="back_left_arm">
                                                            left arm
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="back_right_arm" id="back_right_arm" value="true" >
                                                        <label class="form-check-label text-capitalize" for="back_right_arm">
                                                            right arm
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="back_torso" id="back_torso" value="true" >
                                                        <label class="form-check-label text-capitalize" for="back_torso">
                                                            torso
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="back_left_leg" id="back_left_leg" value="true" >
                                                        <label class="form-check-label text-capitalize" for="back_left_leg">
                                                            left leg
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="back_right_leg" id="back_right_leg" value="true" >
                                                        <label class="form-check-label text-capitalize" for="back_right_leg">
                                                            right leg
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <span>Front</span>
                                            <hr class="mt-0">
                                            <ul class="list-group list-group-flush custom-list">
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="front_head" id="front_head" value="true" >
                                                        <label class="form-check-label text-capitalize" for="front_head">
                                                            head
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="front_left_arm" id="front_left_arm" value="true" >
                                                        <label class="form-check-label text-capitalize" for="front_left_arm">
                                                            left arm
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="front_right_arm" id="front_right_arm" value="true" >
                                                        <label class="form-check-label text-capitalize" for="front_right_arm">
                                                            right arm
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="front_torso" id="front_torso" value="true" >
                                                        <label class="form-check-label text-capitalize" for="front_torso">
                                                            torso
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="front_left_leg" id="front_left_leg" value="true" >
                                                        <label class="form-check-label text-capitalize" for="front_left_leg">
                                                            left leg
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="front_right_leg" id="front_right_leg" value="true" >
                                                        <label class="form-check-label text-capitalize" for="front_right_leg">
                                                            right leg
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name ="front_genitalia" id="front_genitalia" value="true" >
                                                        <label class="form-check-label text-capitalize" for="front_genitalia">
                                                            genitalia
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="burn_classification" class="col-md-4 col-form-label text-md-end">Burn Classification</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="burn_classification" id="burn_classification1" value="critical">
                                    <label class="form-check-label" for="burn_classification1" style="text-transform: capitalize">
                                        critical
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="burn_classification" id="burn_classification2" value="moderate">
                                    <label class="form-check-label" for="burn_classification2" style="text-transform: capitalize">
                                        moderate
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="burn_classification" id="burn_classification3" value="minor">
                                    <label class="form-check-label" for="burn_classification3" style="text-transform: capitalize">
                                        minor
                                    </label>
                                </div>
                                

                                @error('burn_classification')
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


@push('scripts')
    <script type="text/javascript">
        function showAdult(x) {
            if(x.checked == true){
                document.getElementById('showAdultChart').style.display = "block";
                document.getElementById('showPediaChart').style.display = "none";
            }
        }

        function showPedia(x) {
            if(x.checked == true){
                document.getElementById('showAdultChart').style.display = "none";
                document.getElementById('showPediaChart').style.display = "block"; 
            }
        }

        function PopulateObservations() {
            var dropdown = document.getElementById("selection_observations");
            var field = document.getElementById("observations");
            if ( field.value == "" ){
                field.value = dropdown.value;   
            }else{
                field.value += ", " + dropdown.value;
            }
        }
    </script>
@endpush