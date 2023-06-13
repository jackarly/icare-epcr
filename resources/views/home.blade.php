@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="fw-semibold">Dashboard</h4>
            <div class="card bg-transparent border border-0">
                <!-- Show different dashboard based on user_type -->
                @if (auth()->user()->user_type == 'hospital')
                    @include('inc.dashboard-hospital')
                @elseif (auth()->user()->user_type == 'ambulance')
                    @include('inc.dashboard-ambulance')
                @elseif ( (auth()->user()->user_type == 'comcen') || (auth()->user()->user_type == 'admin') )
                    @include('inc.dashboard-admin')
                @else
                    <span class="fst-italic">Nothing to show</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
