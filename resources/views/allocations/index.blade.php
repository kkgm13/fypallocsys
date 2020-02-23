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
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <tr>
                        <th>Student Name</th>
                        <th>Topic Name</th>
                        <th>Supervisor Name</th>
                    </tr>
                    @forelse($allocation as $alloc)
                        <tr>
                            <td>{{$alloc->student->firstName.' '.$alloc->student->lastName}}</td>
                            <td>{{$alloc->topic->name}}</td>
                            <td>{{$alloc->supervisor->firstName.' '.$alloc->supervisor->lastName}}</td>
                        </tr>
                    @empty
                    <tr><td colspan="3"><h3 class="text-center">There are currently no official topic allocations.</h3></td></th>
                    @endforelse
                </table>

            </div>
            
        @else
            @include('allocations.studentview', ['allocation' => $allocation])
        @endif
    </div>
</div>
@endsection