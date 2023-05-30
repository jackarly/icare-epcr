@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3">Update Medic</h4>
            <div class="card">
                <div class="card-header">Medic</div>
                    
                <div class="card-body">
                <form method="POST" action="{{ route('personnel.update', $personnel->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="personnel_name" class="col-md-4 col-form-label text-md-end">Medic Name</label>

                            <div class="col-md-2">
                                <input id="personnel_first_name" type="text" class="form-control @error('personnel_first_name') is-invalid @enderror" name="personnel_first_name" value="{{ old('personnel_first_name') ?? $personnel->personnel_first_name }}" required autocomplete="personnel_first_name" autofocus placeholder="First Name">
                                @error('personnel_first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <input id="personnel_mid_name" type="text" class="form-control @error('personnel_mid_name') is-invalid @enderror" name="personnel_mid_name" value="{{ old('personnel_mid_name') ?? $personnel->personnel_mid_name }}" required autocomplete="personnel_mid_name" autofocus placeholder="Mid Name">
                                @error('personnel_mid_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <input id="personnel_last_name" type="text" class="form-control @error('personnel_last_name') is-invalid @enderror" name="personnel_last_name" value="{{ old('personnel_last_name') ?? $personnel->personnel_last_name }}" required autocomplete="personnel_last_name" autofocus placeholder="Last Name">
                                @error('personnel_last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="contact" class="col-md-4 col-form-label text-md-end">Contact</label>

                            <div class="col-md-6">
                                <input id="contact" type="number" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') ?? $personnel->contact }}" required autocomplete="contact" autofocus>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birthday" class="col-md-4 col-form-label text-md-end">Birthday</label>

                            <div class="col-md-6">
                                <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') ?? $personnel->birthday }}" required autocomplete="birthday" autofocus>

                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sex" class="col-md-4 col-form-label text-md-end">Sex</label>

                            <div class="col-md-6 mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="sex1" value="male" {{($personnel->sex == 'male') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="sex1" style="text-transform: capitalize">
                                        male
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sex" id="sex2" value="female" {{($personnel->sex == 'female') ? 'checked' : ''}}>
                                    <label class="form-check-label" for="sex2" style="text-transform: capitalize">
                                        female
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="personnel_other" class="col-md-4 col-form-label text-md-end">Additional Info</label>

                            <div class="col-md-6">
                                <textarea id="personnel_other" class="form-control @error('personnel_other') is-invalid @enderror" name="personnel_other" autocomplete="personnel_other" autofocus>{{ old('personnel_other') ?? $personnel->personnel_other  }}</textarea>

                                @error('personnel_other')
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