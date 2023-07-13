@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <h5 class="fw-semibold text-secondary">Hotline Numbers</h5>
                    </ul>

                    @if ((auth()->user()->user_type == 'comcen' || (auth()->user()->user_type == 'admin')))
                        <a href="{{ route('hotline.create') }}" class="btn btn-outline-secondary create-item"><i class="fa-solid fa-plus fa-2xs"></i> Add Hotline</a>
                    @endif
                    
                    <button type="button" class="btn btn-outline-secondary text-decoration-none" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <span><i class="fa-solid fa-magnifying-glass"></i></span>
                    </button>
                </div>
            </div>
        </nav>
    </div>
    <div class="row justify-content-left ps-3 pe-3">
        <div class="col-md-10 mx-auto">
            @isset($searchResults)
                <span class="text-secondary fst-italic">Search results for "{{$searchResults}}"</span>
            @endisset

            @if ($hotlines->count())
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Facility</th>
                        <th scope="col">Location</th>
                        <th scope="col">Contact</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotlines as $hotline)
                            <tr class="text-capitalize">
                                <td>{{$hotline->facility }}</td>
                                <td>{{$hotline->location}}</td>
                                <td>{{$hotline->contact}} <a href="{{ route('hotline.edit', $hotline->id) }}" class="btn btn-outline-success btn-sm custom-rounded-btn text-decoration-none float-end"><small>Update</small></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>   
                
                <div class="d-flex">
                    {{ $hotlines->links('pagination::simple-bootstrap-5') }}
                </div>  
                
            @else
                <div class="col-md-12 text-center">
                    <span class="text-secondary my-5">Nothing to show</span>
                </div>
            @endif    
        </div>    
    </div> 
    
    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="searchModalLabel">Search Hotline</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-0">
                    <form method="POST" action="{{route('hotline.search')}}">
                        @csrf
                        <div class="row mb-3">
                            <label for="keyword" class="col-md-4 col-form-label text-md-end">Facility/Location</label>
                            <div class="col-md-6">
                                <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword" 
                                    value="{{ old('keyword') }}" autocomplete="keyword" autofocus>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="order" class="col-md-4 col-form-label text-md-end">Order</label>
                            <div class="col-md-6">
                                <select class="form-select text-capitalize" name="order" class="form-control @error('order') is-invalid @enderror">
                                    <option class="text-capitalize" value="date added" selected>date added</option>
                                    <option class="text-capitalize" value="alpahbetical">alpahbetical</option>
                                </select>
                            </div>
                        </div>
                        
                        <input type="hidden" id="searchedQuery" name="searchedQuery" value="true">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection