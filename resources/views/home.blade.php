@extends('layouts.app')
@section('title')
@if(Auth::user()->role != "Student")
Staff Dashboard
@else
Dashboard
@endif
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">You are logged in, {{Auth::user()->firstName.' '.Auth::user()->lastName}}!</div>

                <div class="card-body">
                    @includeif('layouts.status')
                    <div class="w-100">
                        <div class="row">
                            <div class="col-md-6">
                                @if(Auth::user()->role != "Student")
                                    <h4 class="py-1 underline text-base">Your Topics</h4>
                                    @forelse($topics as $topic)
                                        <p class="py-2"><a href="{{route('topics.show', $topic)}}">{{$topic->name}}</a></p>
                                    @empty
                                        <p>No Topics Availiable</p>
                                    @endforelse
                                @else
                                    <h4 class="py-1 underline text-base">Your Topic Choices</h4>
                                    @forelse(Auth::user()->choices as $choice)
                                    @empty
                                        <p>You have no chosen topics.</p>
                                        <a href="{{route('topics.index')}}" class="btn btn-secondary w-100">View Available Topics</a>
                                @endforelse
                                @endif
                            </div>
                            <div class="col-md-6">
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
                                @else
                                    <p>You have made {{count(Auth::user()->proposalSent)}} proposal(s).</p>
                                    <a href="{{route('proposals.index')}}" class="btn btn-secondary w-100">View Proposal progress</a>
                                    @forelse(Auth::user()->proposalSent as $proposal)
                                        <!-- <tr class="{{ !is_null($proposal->hasRejected) ? $proposal->hasRejected ? 'table-danger' : 'table-success' : '' }}">
                                            <td>{{$proposal->supervisor->firstName.' '.$proposal->supervisor->lastName}}</td>
                                            <td>{{$proposal->name}}</td>
                                            <td>
                                                <div class="btn-group d-flex" role="group" aria-label="Proposal Settings">
                                                    <a href="{{route('proposals.show', $proposal)}}" class="btn btn-secondary w-100"><i class="fas fa-search"></i></a>
                                                    <a onclick="alert('In Development')" class="btn btn-info w-100"><i class="fas fa-plus"></i></a>
                                                </div>
                                            </td>
                                        </tr> -->
                                    @empty
                                        <!-- <tr>
                                            <td colspan="3">
                                                <h5 class="text-center">No Proposals</h5>
                                            </td>
                                        </tr> -->
                                    @endforelse
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection