@extends('layouts.app')
@section('title')
@if(Auth::user()->role != "Student")
Staff Dashboard
@else
Student Dashboard
@endif
@endsection
@section('content')
<div class="container">
    @includeif('layouts.status')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">You are logged in, {{Auth::user()->firstName.' '.Auth::user()->lastName}}!</div>
                <div class="card-body">
                    <div class="w-100">
                        <div class="row">
                            <!-- Left Side -->
                            <div class="col-lg-6">
                                @if(Auth::user()->role != "Student")
                                    <h4 class="py-1 underline text-base">{{Auth::user()->role == "Supervisor" ? "My Topics" : "All Topics"}}</h4>
                                    @forelse($topics as $topic)
                                        <p><a href="{{route('topics.show', $topic)}}">{{$topic->name}}
                                        @if(Auth::user()->role === "Module Leader")
                                        <span>- {{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</span>
                                        @endif
                                        </a></p>
                                    @empty
                                        <p>No Topics Availiable</p>
                                    @endforelse
                                @else
                                    <h4 class="py-1 underline text-base">Your Topic Choices</h4>
                                    @if(!is_null(Auth::user()->allocation))
                                        <p>You have an allocation provided</p>
                                        <a href="{{route('allocations.index')}}" class="btn btn-secondary w-100">View Allocation</a>
                                    @elseif(Auth::user()->choices->count() > 0)
                                        @if(count(Auth::user()->choices) <=3)
                                            <p>You have {{count(Auth::user()->choices)}} topic(s) chosen for review.</p>
                                        @else 
                                            <p>You have the <span class="font-weight-bold">maximum</span> amount of topic choices.</p>
                                        @endif
                                        <div class="btn-group d-flex" role="group" aria-label="Choice Settings">
                                            @if(Auth::user()->choices->count() <= 3 || Auth::user()->choices->count() == 0)
                                                <a href="{{route('choices.mine')}}" class="btn btn-secondary w-100">View My Choices</a>
                                            @endif

                                            @if(Auth::user()->choices->count() <= 2)
                                                <a href="{{route('topics.index')}}" class="btn btn-info w-100">Find More Topics</a>
                                            @endif
                                        </div>
                                    @else
                                        <p>You have no chosen topics.</p>
                                        <a href="{{route('topics.index')}}" class="btn btn-secondary w-100">View Available Topics</a>
                                    @endif
                                @endif
                            </div>
                            <!-- Right Side -->
                            <div class="col-lg-6">
                                <h4 class="py-1 underline text-base">{{ Auth::user()->role != "Student" ? "Student Proposals" : "Your Proposals"}}</h4>
                                @if(Auth::user()->role != "Student")
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{Auth::user()->role != "Student" ?  "Student" : "Supervisor"}}</th>
                                                <th>Proposal</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(Auth::user()->proposals as $proposal)
                                                <tr>
                                                    <td>{{$proposal->student->firstName.' '.$proposal->student->lastName}}</td>
                                                    <td>{{$proposal->name}}</td>
                                                    <td>
                                                        <a href="{{route('proposals.show', $proposal)}}" class="btn btn-secondary w-100"><i class="fas fa-search"></i></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3">
                                                        <h5 class="text-center">No Proposals</h5>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <a href="{{route('proposals.index')}}" class="btn btn-secondary w-100">View All Proposals</a>
                                @else
                                    <p>You have made {{count(Auth::user()->proposalSent)}} proposal(s).</p>
                                    <a href="{{route('proposals.index')}}" class="btn btn-secondary w-100">View Proposal progress</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection