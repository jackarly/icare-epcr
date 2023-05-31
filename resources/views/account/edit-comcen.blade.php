@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3">Update Comcen Account</h4>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Details</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comcen.update', $account->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
                            <div class="col-md-6" id="usernameContainer">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?? $account->username }}" required autocomplete="username" autofocus>
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



                        <div class="row mb-3">
                            <label for="Name" class="col-md-4 col-form-label text-md-end">{{ __('Comcen Staff') }}</label>

                            <div class="col-md-2">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') ?? $comcen->first_name}}" required autocomplete="first_name" autofocus placeholder="First Name">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <input id="mid_name" type="text" class="form-control @error('mid_name') is-invalid @enderror" name="mid_name" value="{{ old('mid_name') ?? $comcen->mid_name}}" required autocomplete="mid_name" autofocus placeholder="Mid Name">
                                @error('mid_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $comcen->last_name}}" required autocomplete="last_name" autofocus placeholder="Last Name">
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
                                <input id="contact_1" type="text" class="form-control @error('contact_1') is-invalid @enderror" name="contact_1" value="{{ old('contact_1') ?? $comcen->contact_1}}" required autocomplete="contact_1" autofocus>
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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $comcen->email}}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



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
                // document.getElementById('username').disabled = true;
                document.getElementById('password').disabled = true;
                document.getElementById('password-confirm').disabled = true;
                document.getElementById('defaultDetails').style.display = "block";
                document.getElementById('defaultUsernameContainer').style.display = "block";
                document.getElementById('usernameContainer').style.display = "none";
            }else{
                // document.getElementById('username').disabled = false;
                document.getElementById('password').disabled = false;
                document.getElementById('password-confirm').disabled = false;
                document.getElementById('defaultDetails').style.display = "none";
                document.getElementById('defaultUsernameContainer').style.display = "none"; 
                document.getElementById('usernameContainer').style.display = "block";       
            }
        }
    </script>
@endpush

