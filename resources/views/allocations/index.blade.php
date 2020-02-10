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
        
        @else
            <div class="jumbotron px-3">
                <h4 class="text-center">Congratulations, you are allocated with the following:</h4>
                <h5 class="text-center">
                    @if(!is_null($allocation->topic))
                        {{$allocation->topic->name}}
                    @elseif(!is_null($allocation->proposal))
                        {{$allocation->proposal->name}}
                    @endif
                </h5>
            </div>
        @endif
    </div>
</div>
@endsection