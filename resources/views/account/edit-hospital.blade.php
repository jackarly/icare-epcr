@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="text-center mb-3">Update Hospital Account</h4>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Details</div>
                <div class="card-body">
                    @if (auth()->user()->id === $account->id )
                        <form method="POST" action="{{ route('account.update') }}">
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
                                <label for="hospital_name" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Name') }}</label>

                                <div class="col-md-6">
                                    <input id="hospital_name" type="text" class="form-control @error('hospital_name') is-invalid @enderror" name="hospital_name" value="{{ old('hospital_name') ?? $hospital->hospital_name }}" required autocomplete="hospital_name" autofocus>
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
                                    <input id="hospital_abbreviation" type="text" class="form-control @error('hospital_abbreviation') is-invalid @enderror" name="hospital_abbreviation" value="{{ old('hospital_abbreviation') ?? $hospital->hospital_abbreviation }}" required autocomplete="hospital_abbreviation" autofocus>
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
                                    <input id="hospital_address" type="text" class="form-control @error('hospital_address') is-invalid @enderror" name="hospital_address" value="{{ old('hospital_address') ?? $hospital->hospital_address }}" required autocomplete="hospital_address" autofocus>
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
                                    <input id="contact_1" type="text" class="form-control @error('contact_1') is-invalid @enderror" name="contact_1" value="{{ old('contact_1') ?? $hospital->contact_1 }}" required autocomplete="contact_1" autofocus>
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
                                    <input id="contact_2" type="text" class="form-control @error('contact_2') is-invalid @enderror" name="contact_2" value="{{ old('contact_2') ?? $hospital->contact_2 }}" autocomplete="contact_2" autofocus>
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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $hospital->email }}" required autocomplete="email">
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
                    @else
                        <form method="POST" action="{{ route('hospital.update', $account->id) }}">
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
                                <label for="hospital_name" class="col-md-4 col-form-label text-md-end">{{ __('Hospital Name') }}</label>

                                <div class="col-md-6">
                                    <input id="hospital_name" type="text" class="form-control @error('hospital_name') is-invalid @enderror" name="hospital_name" value="{{ old('hospital_name') ?? $hospital->hospital_name }}" required autocomplete="hospital_name" autofocus>
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
                                    <input id="hospital_abbreviation" type="text" class="form-control @error('hospital_abbreviation') is-invalid @enderror" name="hospital_abbreviation" value="{{ old('hospital_abbreviation') ?? $hospital->hospital_abbreviation }}" required autocomplete="hospital_abbreviation" autofocus>
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
                                    <input id="hospital_address" type="text" class="form-control @error('hospital_address') is-invalid @enderror" name="hospital_address" value="{{ old('hospital_address') ?? $hospital->hospital_address }}" required autocomplete="hospital_address" autofocus>
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
                                    <input id="contact_1" type="text" class="form-control @error('contact_1') is-invalid @enderror" name="contact_1" value="{{ old('contact_1') ?? $hospital->contact_1 }}" required autocomplete="contact_1" autofocus>
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
                                    <input id="contact_2" type="text" class="form-control @error('contact_2') is-invalid @enderror" name="contact_2" value="{{ old('contact_2') ?? $hospital->contact_2 }}" autocomplete="contact_2" autofocus>
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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $hospital->email }}" required autocomplete="email">
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
                    @endif

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

