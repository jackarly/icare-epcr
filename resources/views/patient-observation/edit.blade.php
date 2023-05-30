@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3 fw-bold">Update Patient Observation</h5>
            <div class="card">
                <div class="card-header">Patient Observation</div>
                    
                <div class="card-body">
                    <form method="POST" action="{{ route('observation.update', $patient_observation->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="observations" class="col-md-4 col-form-label text-md-end">Observations</label>

                            <div class="col-md-6">
                                <textarea id="observations" class="form-control @error('observations') is-invalid @enderror" name="observations" required autocomplete="observations" autofocus>{{ old('observations') ?? $patient_observation->observations }}</textarea>

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
                                            <input class="form-check-input" type="checkbox" name ="wound" id="wound" value="1" {{($patient_observation->wound == 1) ? 'checked' : ''}}>
                                            <label class="form-check-label text-capitalize" for="wound">
                                                W wound
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="dislocation" id="dislocation" value="1" {{($patient_observation->dislocation == 1) ? 'checked' : ''}}>
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
                                            <input class="form-check-input" type="checkbox" name ="fracture" id="fracture" value="1" {{($patient_observation->fracture == 1) ? 'checked' : ''}}>
                                            <label class="form-check-label text-capitalize" for="fracture">
                                                f fracture
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="numbness" id="numbness" value="1" {{($patient_observation->numbness == 1) ? 'checked' : ''}}>
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
                                            <input class="form-check-input" type="checkbox" name ="swelling" id="swelling" value="1" {{($patient_observation->swelling == 1) ? 'checked' : ''}}>
                                            <label class="form-check-label text-capitalize" for="swelling">
                                                s swelling
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name ="rash" id="rash" value="1" {{($patient_observation->rash == 1) ? 'checked' : ''}}>
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
                                            <input class="form-check-input" type="checkbox" name ="burn" id="burn" value="1" {{($patient_observation->burn == 1) ? 'checked' : ''}}>
                                            <label class="form-check-label text-capitalize" for="burn">
                                                b burn <span class="fw-semibold">{{($patient_observation->burn_calculation != null) ? $patient_observation->burn_calculation . '%' : ''}}</span>
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
                                    <input class="form-check-input" type="radio" name="age_group" id="age_group1" value="adult" onchange='showAdult(this);' {{($patient_observation->age_group == 'adult') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="age_group1" style="text-transform: capitalize">
                                        adult
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="age_group" id="age_group2" value="pedia" onchange='showPedia(this);'{{($patient_observation->age_group == 'pedia') ? 'checked' : ''}}>
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

                        <div class="row" id="showAdultChart" style="display:{{($patient_observation->age_group == 'adult') ? 'blocked' : 'none'}}" >
                            <div class="col-md-6 offset-md-4">
                                <img src="{{ asset('/images/rule-9-adult.jpg') }}" alt="Rule 9 Adult" style="height: auto; width: 75%; object-fit: contain">
                            </div>
                        </div>

                        <div class="row" id="showPediaChart" style="display:{{($patient_observation->age_group == 'pedia') ? 'blocked' : 'none'}}" >
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
                                    <input class="form-check-input" type="radio" name="burn_classification" id="burn_classification1" value="critical" {{($patient_observation->burn_classification == 'critical') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="burn_classification1" style="text-transform: capitalize">
                                        critical
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="burn_classification" id="burn_classification2" value="moderate" {{($patient_observation->burn_classification == 'moderate') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="burn_classification2" style="text-transform: capitalize">
                                        moderate
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="burn_classification" id="burn_classification3" value="minor" {{($patient_observation->burn_classification == 'minor') ? 'checked' : ''}}>
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
    <!-- <script type="text/javascript">
        function EnableDisableTextBox(chkPassport) {
            var txtPassportNumber = document.getElementById("txtPassportNumber");
            txtPassportNumber.disabled = chkPassport.checked ? false : true;
            if (txtPassportNumber.disabled) {
                txtPassportNumber.value="";
            }
        }
    </script> -->

    <!-- <script type="text/javascript">
        var checkAll = document.getElementById("id_check_uncheck_all");
        checkAll.addEventListener("change", function() 
        {
            var checked = this.checked;
            var otherCheckboxes = document.querySelectorAll(".toggleable");
            [].forEach.call(otherCheckboxes, function(item) 
            {
                item.checked = checked;
            });
        });
    </script> -->

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
    </script>

    <!-- <script type="text/javascript">
        function disable() {
        document.querySelectorAll('.sample').forEach(element => element.disabled = true);
        }

        function enable() {
        document.querySelectorAll('.sample').forEach(element => element.disabled = false);
        }
    </script> -->
@endpush