@extends('layouts.app')
@section('title')
@if(Auth::user()->role === "Module Leader")
@if(Request::is('allocations/unallocated/topics'))
Unallocated Topics
@elseif(Request::is('allocations/unallocated/students'))
Unallocated Students
@else
All Allocations
@endif
@else 
My Allocation
@endif
@endsection
@section('content')
<div class="container">
    <h1 class="text-center">
    @if(Auth::user()->role === "Module Leader")
        @if(Request::is('allocations/unallocated/topics'))
        Unallocated Topics
        @elseif(Request::is('allocations/unallocated/students'))
        Unallocated Students
        @else
        All Allocations
        @endif
    @else 
    My Allocation
    @endif
    </h1>
    <hr>
    @if(Auth::user()->role == "Module Leader")
        <div class="row my-2">
            <div class="col">
                <div class="btn-group w-100" role="group" aria-label="Basic example">
                    <a class="btn btn-success" href="{{route('allocations.index')}}">See All Allocated</a>
                    <a class="btn btn-warning" href="{{route('allocations.unallocatedTopic')}}">See All Unallocated Topics</a>
                    <a class="btn btn-danger" href="{{route('allocations.unallocatedStudent')}}">See All Unallocated Students</a>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        @if(Auth::user()->role == "Student")
            @if(!is_null(Auth::user()->allocation))
                @include('allocations.studentview', ['allocation' => $allocation])
            @else
                <div class="col">
                    <h2 class="text-center">You have no allocations as of yet.</h2>
                    <p class="text-muted text-center font-italic">Choose a <a href="{{route('topics.index')}}">supervisor-provided topic</a> or <a href="{{route('proposals.create')}}">propose your own topic</a>.</p>
                    
                </div>
            @endif                
        @elseif(Auth::user()->role == "Supervisor")
            @include('allocations.supervisorview', ['allocations' => $allocation])
        @else
            @if(Request::is('allocations/unallocated/topics'))
                @include('allocations.unallocatedTopic', ['unallocTopics' => $unallocTopics])
            @elseif(Request::is('allocations/unallocated/students'))
                @include('allocations.unallocatedStudent', ['unallocStudents' => $unallocStudents])
            @else
                @include('allocations.moduleleaderview', ['allocation' => $allocation])
            @endif
        @endif
    </div>
</div>
@endsection