@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-capitalize">{{ ($user_type) ?? 'all users'}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('account.overview') }}">All Users</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.overview', 'ambulance') }}">Ambulance</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.overview', 'hospital') }}">Hospital</a></li>
                            
                            <!-- Show only for user_type = Admin  -->
                            @if ( auth()->user()->user_type == 'admin' )
                                <li><a class="dropdown-item" href="{{ route('account.overview', 'comcen') }}">ComCen</a></li>
                                <li><a class="dropdown-item" href="{{ route('account.overview', 'admin') }}">Admin</a></li>
                            @endif
                        </ul>
                    </ul>

                    
                    <a href=" {{route('account.create' ,$user_type)}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Create User</a>
                    <button type="button" class="btn btn-outline-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <span><i class="fa-solid fa-magnifying-glass"></i></span>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">
        @if ($accounts->count())
            @foreach ($accounts as $account)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center"><span class="fs-5 fw-bold">{{ $account->username }}</span></li>
                                        <li class="text-capitalize">USER{{ $account->id }} 
                                            <span class="fs-5">|</span> 
                                            <span class="text-success fw-semibold">{{ $account->user_type }}</span>
                                        <li class="account-name">

                                            <!-- Show details based on user_type -->
                                            @switch($account->user_type)
                                                @case('ambulance')
                                                    <span class="text-uppercase">
                                                        @if ($account->plate_no)                                                        
                                                            {{$account->plate_no}}
                                                        @else
                                                            {{$account->user_ambulance->plate_no}}
                                                        @endif
                                                    </span>
                                                    @break

                                                @case('hospital')
                                                    <span class="text-capitalize">
                                                        @if ($account->hospital_name)
                                                            {{$account->hospital_name}} <small>({{$account->hospital_abbreviation}})</small>                                                         
                                                        @else
                                                            {{$account->user_hospital->hospital_name}} <small>({{$account->user_hospital->hospital_abbreviation}})</small>
                                                        @endif
                                                    </span>
                                                    @break

                                                @case('comcen')
                                                    <span class="text-capitalize">
                                                        @if ($account->comcen_first_name)
                                                            {{$account->comcen_first_name}} {{$account->comcen_last_name}}
                                                        @else
                                                            {{$account->user_comcen->first_name}} {{$account->user_comcen->last_name}}
                                                        @endif
                                                    </span>
                                                    @break
                                                    
                                                @case('admin')
                                                    <span class="text-capitalize">
                                                        @if ($account->first_name)
                                                            {{$account->first_name}} {{$account->last_name}}
                                                        @else
                                                            {{$account->user_admin->first_name}} {{$account->user_admin->last_name}}
                                                        @endif
                                                    </span>
                                                    @break

                                                @default
                                                    Something went wrong, please try again
                                            @endswitch
                                        </li>    
                                        <li class="mt-2"><a href="{{ route('account.show', $account->id) }}" class="btn btn-outline-primary btn-sm d-block">View User</a></li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            @endforeach
            <div class="d-flex">
                {{ $accounts->links('pagination::simple-bootstrap-5') }}
            </div>
        @else
            <hr>
            <div class="col-md-12 text-center">
                <span class="text-secondary my-5">Nothing to show</span>
            </div>
        @endif        
    </div>

    <!-- Modal -->
    <div class="modal fade" id="searchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="searchModalLabel">Search Account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form method="POST" action="{{route('account.search')}}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="search_name" class="col-md-4 col-form-label text-md-end">Name</label>
                            <div class="col-md-6">
                                <input id="search_name" type="text" class="form-control @error('search_name') is-invalid @enderror" name="search_name" 
                                    value="{{ old('search_name') }}" autocomplete="search_name" autofocus>
                                <small class="text-secondary fst-italic">*Name, Username, Plate No, or Facility</small>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">User Type</label>
                            <div class="col-md-6">
                                <select class="form-select text-capitalize" id="searchStatus" name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option class="text-capitalize" value="all users" {{ $user_type == 'all users' ? 'selected' : ''}} >all users</option>
                                    <option class="text-capitalize" value="ambulance" {{ $user_type == 'ambulance' ? 'selected' : ''}} >ambulance</option>
                                    <option class="text-capitalize" value="hospital" {{ $user_type == 'hospital' ? 'selected' : ''}} >hospital</option>
                                    
                                    
                                    <!-- Show only for user_type = Admin  -->
                                    @if ( auth()->user()->user_type == 'admin' )
                                        <option class="text-capitalize" value="comcen" {{ $user_type == 'comcen' ? 'selected' : ''}} >comcen</option>
                                        <option class="text-capitalize" value="admin" {{ $user_type == 'admin' ? 'selected' : ''}} >admin</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="searchedQuery" name="searchedQuery" value="true">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection