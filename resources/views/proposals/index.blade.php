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
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                        @if(Auth::user()->role != "Student")
                            Student
                        @else 
                            Appointed Supervisor
                        @endif
                        </th>
                        <th>Proposal Name</th>
                        <th>Proposal Description</th>
                        <th>Student's Reasoning</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        @forelse($proposals as $proposal)
                        <td></td>
                        @empty
                        <td class="text-center" colspan="5">
                            @if(Auth::user()->role != "Student")
                                <h4>No proposals requests</h4>
                            @else
                                <h4>You have no proposals.</h4>
                                <p class="text-muted text-center font-italic">Got a topic proposal that you want to work on?</p>
                                <a class="btn btn-danger" href="{{route('proposals.create')}}">Back to Topics List</a>
                            @endif
                        </td>
                        @endforelse
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection