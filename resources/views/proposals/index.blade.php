@extends('layouts.app')
@section('title')
@if(Auth::user()->role != "Student")
    Proposal Requests
@else 
    My Proposals
@endif
@endsection
@section('content')
<div class="container mx-auto px-4 w-full">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1 class="text-center">
        @if(Auth::user()->role != "Student")
            Proposal Requests
        @else 
            My Proposals
        @endif
    </h1>
    <p class="text-muted text-center font-italic">
        @if(Auth::user()->role != "Student")
            These are all the student's proposals which they have chosen you as their potential supervisor.
        @else 
            These are all your proposals to specific lecturers.<br>Please note that it may take a while for them to respond.
        @endif
    </p>
    <hr>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ Auth::user()->role != "Student" ? "Student" : "Chosen Supervisor"}}</th>
                            <th>Proposal Name</th>
                            <th>Proposal Description</th>
                            <th>Student's Reasoning</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposals as $proposal)
                            @if(Auth::user()->role != "Student")
                                <tr>
                            @else
                                <tr class="{{ !is_null($proposal->hasRejected) ? $proposal->hasRejected ? 'table-danger' : 'table-success' : '' }}">
                            @endif
                            <td>{{Auth::user()->role != "Student" ? 
                                $proposal->student->firstName.' '.$proposal->student->lastName : 
                                $proposal->supervisor->firstName.' '.$proposal->supervisor->lastName}}</td>
                            <td>{{$proposal->name}}</td>
                            <td>{{$proposal->description}}</td>
                            <td>{{$proposal->reasoning}}</td>
                            <td>
                                <div class="btn-group d-flex" role="group" aria-label="Proposal Settings">
                                    <a href="{{route('proposals.show', $proposal)}}" class="btn btn-secondary w-100"><i class="fas fa-search"></i></a>
                                    @if(Auth::user()->role != "Student")
                                        <a onclick="alert('In Development')" class="btn btn-info w-100"><i class="fas fa-plus"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="5">
                                @if(Auth::user()->role != "Student")
                                    <h4>No proposals to be looked at</h4>
                                @else
                                    <h4>You have no proposals.</h4>
                                    <p class="text-muted text-center font-italic">Got a topic proposal that you want to work on?</p>
                                    <a class="btn btn-danger" href="{{route('proposals.create')}}">Click Here to propose</a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection