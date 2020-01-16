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
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::user()->role != "Student")
                        <div class="w-full">
                            <p class="py-2">
                                You are logged in, {{Auth::user()->firstName.' '.Auth::user()->lastName}}!
                            </p>
                            <hr class="py-2">
                            <div class="row">
                                <div class="col-md-6">
                                    @if(Auth::user()->role == "Module Leader")
                                        <h4 class="py-1 underline text-lg">All Authorized Topics</h4>
                                    @else 
                                        <h4 class="py-1 underline text-base">Your Topics</h4>
                                    @endif
                                    @forelse($topics as $topic)
                                        <p class="py-2 hover:underline"><a href="{{route('topics.show', $topic)}}">{{$topic->name}}</a></p>
                                    @empty
                                        <p>No Topics Availiable</p>
                                    @endforelse
                                </div>
                                <div class="col-md-6">
                                    <h4 class="py-1 underline text-base">Student Proposals</h4>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(Auth::user()->proposals as $proposal)
                                                <tr>
                                                    <td>{{$proposal->student->firstName.' '.$proposal->student->lastName}}</td>
                                                    <td>{{$proposal->name}}</td>
                                                    <td>
                                                        <div class="btn-group d-flex" role="group" aria-label="Proposal Settings">
                                                            <a href="{{route('proposals.show', $proposal)}}" class="btn btn-secondary w-100"><i class="fas fa-search"></i></a>
                                                            <a onclick="alert('In Development')" class="btn btn-info w-100"><i class="fas fa-plus"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="3"><h5 class="text-center">No Proposals</h5></td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="w-full p-6">
                        <p class="text-gray-700 py-2">
                            You are logged in, {{Auth::user()->firstName.' '.Auth::user()->lastName}}!
                        </p>

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
