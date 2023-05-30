@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3">Update Response Team</h4>
            <div class="card">
                <div class="card-header">Response Team</div>
                <div class="card-body">
                <form method="POST" action="{{ route('response.update', $response->id)}}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="ambulance" class="col-md-4 col-form-label text-md-end">Ambulance</label>

                            <div class="col-md-6">
                                @if ($ambulances->count())
                                    <select class="form-select" aria-label="Default select example" name="ambulance" class="form-control @error('ambulance') is-invalid @enderror" required>
                                        <option class="text-center" value="" selected disabled>--- Select Ambulance ---</option>
                                        @foreach ($ambulances as $ambulance)
                                            <option class="text-capitalize" value="{{$ambulance->id}}">{{$ambulance->plate_no}}</option>
                                        @endforeach
                                    </select>
                                    @error('ambulance')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @else
                                    <input type="text" class="form-control" name="" id="" disabled placeholder="No ambulance available">
                                @endif
                                

                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="medic1" class="col-md-4 col-form-label text-md-end">Medic 1</label>

                            <div class="col-md-6">
                                @if ($medics->count())
                                    <select class="form-select text-capitalize" aria-label="Default select example" name="medic1" class="form-control @error('medic1') is-invalid @enderror" required>
                                        <option class="text-center" value="" selected disabled>--- Select Medic ---</option>
                                        @foreach ($medics as $medic)
                                            <option class="text-capitalize" value="{{$medic->id}}">{{$medic->personnel_first_name}} {{$medic->personnel_last_name}}</option>
                                        @endforeach
                                    </select>

                                    @error('medic1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @else
                                    <input type="text" class="form-control" name="" id="" disabled placeholder="No medic available">
                                @endif
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="medic2" class="col-md-4 col-form-label text-md-end">Medic 2</label>

                            <div class="col-md-6">
                                @if ($medics->count() > 1)
                                    <select class="form-select text-capitalize" aria-label="Default select example" name="medic2" class="form-control @error('medic2') is-invalid @enderror" required>
                                        <option class="text-center" value="" selected disabled>--- Select Medic ---</option>
                                        @foreach ($medics as $medic)
                                            <option class="text-capitalize" value="{{$medic->id}}">{{$medic->personnel_first_name}} {{$medic->personnel_last_name}}</option>
                                        @endforeach
                                    </select>

                                    @error('medic2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                @else
                                    <input type="text" class="form-control" name="" id="" disabled placeholder="No medic available">
                                @endif
                                
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

<!-- @push('head')
    <script>
        $("#selectBox option[value='option1']").remove();
    </script>
@endpush -->