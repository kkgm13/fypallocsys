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
    @if(Auth::user()->role == "Module Leader")
        <div class="row my-2">
            <div class="col">
                <div class="btn-group w-100" role="group" aria-label="Basic example">
                    <a class="btn btn-success" href="{{route('allocations.index')}}">See All Allocated</a>
                    <a class="btn btn-warning" href="">See All Unallocated Topics</a>
                    <a class="btn btn-danger" href="{{route('allocations.unallocated')}}">See All Unallocated Students</a>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        @if(Auth::user()->role != "Student")
            @if(Auth::user()->role == "Supervisor")
                @include('allocations.supervisorview', ['allocations' => $allocation])
            @elseif(Request::is('allocations/unallocated'))
                @include('allocations.unallocated', ['unallocStudents' => $unallocStudents, 'unallocTopics' => $unallocTopics])
            @else
                @include('allocations.moduleleaderview', ['allocation' => $allocation])
            @endif
        @else
            @include('allocations.studentview', ['allocation' => $allocation])
        @endif
    </div>
</div>
@endsection