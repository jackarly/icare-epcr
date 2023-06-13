@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3">Create User</h4>
            <div class="card mb-3">
                <div class="card-header">{{ __('User Type') }}</div>
                <div class="card-body">

                    <!-- Show if user_type == Admin -->
                    @if ( auth()->user()->user_type == 'admin' )
                        <div class="row">
                            <div class="col-md-3 my-1">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('account.create', 'ambulance') }}" class="btn btn-{{ ($user_type=='ambulance') ? '' : 'outline-'}}primary">Ambulance</a>
                                </div>
                            </div>
                            <div class="col-md-3 my-1">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('account.create', 'hospital') }}" class="btn btn-{{ ($user_type=='hospital') ? '' : 'outline-'}}primary">Hospital</a>
                                </div>
                            </div>
                            <div class="col-md-3 my-1">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('account.create', 'comcen') }}" class="btn btn-{{ ($user_type=='comcen') ? '' : 'outline-'}}primary">ComCen</a>
                                </div>
                            </div>
                            <div class="col-md-3 my-1">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('account.create', 'admin') }}" class="btn btn-{{ ($user_type=='admin') ? '' : 'outline-'}}primary">Admin</a>
                                </div>
                            </div>
                            
                        </div>
                    @else
                    <!-- Show if user_type == Comcen -->
                        <div class="row">
                            <div class="col-md-6 my-1">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('account.create', 'ambulance') }}" class="btn btn-{{ ($user_type=='ambulance') ? '' : 'outline-'}}primary">Ambulance</a>
                                </div>
                            </div>
                            <div class="col-md-6 my-1">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('account.create', 'hospital') }}" class="btn btn-{{ ($user_type=='hospital') ? '' : 'outline-'}}primary">Hospital</a>
                                </div>
                            </div>
                            
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Details</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('account.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                            <div class="col-md-6" id="usernameContainer">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <input class="form-check-input" type="checkbox" name="default_user" onchange='defaultUser(this);' value="true" id="id_default_user">
                                <label class="form-check-label" for="flexCheckDefault">
                                Set Username as password
                                </label>
                            </div>
                        </div>
                        <hr>

                        <!-- Show form based on chosen user_type -->
                        @switch($user_type)
                            @case('ambulance')
                                <div class="row mb-3">
                                    <label for="plate_no" class="col-md-4 col-form-label text-md-end">{{ __('Ambulance Plate #') }}</label>

                                    <div class="col-md-6">
                                        <input id="plate_no" type="text" class="form-control @error('plate_no') is-invalid @enderror" name="plate_no" value="{{ old('plate_no') }}" required autocomplete="plate_no" autofocus>
                                        @error('plate_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @break

                            @case('hospital')
                                <div class="row mb-3">
                                    <label for="hospital_name" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="hospital_name" type="text" class="form-control @error('hospital_name') is-invalid @enderror" name="hospital_name" value="{{ old('hospital_name') }}" required autocomplete="hospital_name" autofocus>
                                        @error('hospital_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="hospital_abbreviation" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Abbreviation') }}</label>

                                    <div class="col-md-6">
                                        <input id="hospital_abbreviation" type="text" class="form-control @error('hospital_abbreviation') is-invalid @enderror" name="hospital_abbreviation" value="{{ old('hospital_abbreviation') }}" required autocomplete="hospital_abbreviation" autofocus>
                                        @error('hospital_abbreviation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="hospital_address" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="hospital_address" type="text" class="form-control @error('hospital_address') is-invalid @enderror" name="hospital_address" value="{{ old('hospital_address') }}" required autocomplete="hospital_address" autofocus>
                                        @error('hospital_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="contact_1" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Contact 1') }}</label>

                                    <div class="col-md-6">
                                        <input id="contact_1" type="text" class="form-control @error('contact_1') is-invalid @enderror" name="contact_1" value="{{ old('contact_1') }}" required autocomplete="contact_1" autofocus>
                                        @error('contact_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="contact_2" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Contact 2') }}</label>

                                    <div class="col-md-6">
                                        <input id="contact_2" type="text" class="form-control @error('contact_2') is-invalid @enderror" name="contact_2" value="{{ old('contact_2') }}" autocomplete="contact_2" autofocus>
                                        @error('contact_2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @break

                            @case('comcen')
                                <div class="row mb-3">
                                    <label for="Name" class="col-md-4 col-form-label text-md-end">{{ __('Comcen Staff') }}</label>

                                    <div class="col-md-2">
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="First Name">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input id="mid_name" type="text" class="form-control @error('mid_name') is-invalid @enderror" name="mid_name" value="{{ old('mid_name') }}"  autocomplete="mid_name" autofocus placeholder="Mid Name">
                                        @error('mid_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Last Name">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="contact_1" class="col-md-4 col-form-label text-md-end">{{ __('Contact') }}</label>

                                    <div class="col-md-6">
                                        <input id="contact_1" type="text" class="form-control @error('contact_1') is-invalid @enderror" name="contact_1" value="{{ old('contact_1') }}" required autocomplete="contact_1" autofocus>
                                        @error('contact_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @break
                                
                            @case('admin')
                                <div class="row mb-3">
                                    <label for="Name" class="col-md-4 col-form-label text-md-end">{{ __('Admin') }}</label>

                                    <div class="col-md-2">
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="First Name">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <input id="mid_name" type="text" class="form-control @error('mid_name') is-invalid @enderror" name="mid_name" value="{{ old('mid_name') }}"  autocomplete="mid_name" autofocus placeholder="Mid Name">
                                        @error('mid_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Last Name">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="contact_1" class="col-md-4 col-form-label text-md-end">{{ __('Contact') }}</label>

                                    <div class="col-md-6">
                                        <input id="contact_1" type="text" class="form-control @error('contact_1') is-invalid @enderror" name="contact_1" value="{{ old('contact_1') }}" required autocomplete="contact_1" autofocus>
                                        @error('contact_1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @break

                            @default
                                <span>Something went wrong, please try again</span>
                        @endswitch

                        <input type="hidden" id="user_type" name="user_type" value="{{$user_type}}">

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4 d-grid gap-2 ">
                                <button type="submit" class="btn btn-primary">
                                    Save
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
        function defaultUser(x) {
            if(x.checked == true){
                document.getElementById('password').disabled = true;
                document.getElementById('password-confirm').disabled = true;
                document.getElementById('defaultDetails').style.display = "block";
                document.getElementById('defaultUsernameContainer').style.display = "block";
                document.getElementById('usernameContainer').style.display = "none";
            }else{
                document.getElementById('password').disabled = false;
                document.getElementById('password-confirm').disabled = false;
                document.getElementById('defaultDetails').style.display = "none";
                document.getElementById('defaultUsernameContainer').style.display = "none"; 
                document.getElementById('usernameContainer').style.display = "block";       
            }
        }
    </script>
@endpush

