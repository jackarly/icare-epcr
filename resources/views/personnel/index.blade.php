@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="text-capitalize">{{ ($status) ?? 'all personnel'}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('personnel') }}">All Personnel</a></li>
                            <li><a class="dropdown-item" href="{{ route('personnel', 'available') }}">Available</a></li>
                            <li><a class="dropdown-item" href="{{ route('personnel', 'assigned') }}">Assigned</a></li>
                            <!-- <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        </ul>
                    </ul>

                    <a href=" {{route('personnel.create')}} " class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Add Personnel</a>
                    
                    <button type="button" class="btn btn-outline-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <span><i class="fa-solid fa-magnifying-glass"></i></span>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    <div class="row justify-content-left">

        <!-- Show searched keywords -->
        @isset($searchKeyword)
            <span class="text-secondary fst-italic">Search results for "{{$searchKeyword}}"</span>
        @endisset

        @if ($personnels->count())
            @foreach ($personnels as $personnel)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('storage/default/avatar-default.png') }}" class="rounded-circle mx-auto d-block thumbnail" alt="default-avatar" height="100px" width="100px">
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <ul class="list-group list-group-flush custom-list">
                                        <li class="text-center"><span class="text-capitalize fs-5 fw-semibold">{{$personnel->personnel_first_name}} {{$personnel->personnel_last_name}}</span></li>
                                        <li class="">PERSONNEL{{$personnel->id}}<span class="fs-5">|</span>
                                            @if ($personnel->medicStatus)
                                                <span class="text-warning fw-semibold">Assigned</span>
                                            @else
                                                <span class="text-success fw-semibold">Available</span>
                                            @endif
                                            
                                        </li>
                                        <li class="text-secondary fw-semibold"><span class="text-capitalize">{{$personnel->personnel_type}}</span></li>
                                        <li class="name-space"><span>{{$personnel->contact}}</span></li>
                                        <li class="mt-2"><a href="{{route('personnel.show', $personnel->id)}}" class="btn btn-outline-primary btn-sm d-block">View Personnel</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
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
                    <h1 class="modal-title fs-5" id="searchModalLabel">Search Personnel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form method="POST" action="{{route('personnel.search')}}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="search_name" class="col-md-4 col-form-label text-md-end">Name</label>
                            <div class="col-md-6">
                                <input id="search_name" type="text" class="form-control @error('search_name') is-invalid @enderror" name="search_name" 
                                    value="{{ old('search_name') }}" autocomplete="search_name" autofocus>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
                            <div class="col-md-6">
                                <select class="form-select text-capitalize" id="searchStatus" name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option class="text-capitalize" value="all personnel" {{ $status == 'all personnel' ? 'selected' : ''}} >all personnel</option>
                                    <option class="text-capitalize" value="available" {{ $status == 'available' ? 'selected' : ''}} >available</option>
                                    <option class="text-capitalize" value="assigned" {{ $status == 'assigned' ? 'selected' : ''}} >assigned</option>
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