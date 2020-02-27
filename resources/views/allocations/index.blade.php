@extends('layouts.app')
@section('title')
@if(Auth::user()->role === "Module Leader")
All Allocations
@else 
My Allocation
@endif
@endsection
@section('content')
<div class="container">
    <h1 class="text-center">{{Auth::user()->role === "Module Leader" ? "All Allocations" : "My Allocation"}}</h1>
    <hr>
    <div class="row">
        @if(Auth::user()->role != "Student")
            @if(Auth::user()->role == "Supervisor")
                @include('allocations.supervisorview', ['allocations' => $allocation])
            @else
                @include('allocations.moduleleaderview', ['allocation' => $allocation])
            @endif
        @else
            @include('allocations.studentview', ['allocation' => $allocation])
        @endif
    </div>
</div>
@endsection