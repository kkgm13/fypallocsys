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
                        <div class="w-full p-6">
                            <p class="text-gray-700 py-2">
                                You are logged in, {{Auth::user()->firstName.' '.Auth::user()->lastName}}!
                            </p>
                            <hr class="py-2">
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
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Supervisor</th>
                                        <th scope="col">Topic Title</th>
                                        <th scope="col">Multimedia Suitable</th>
                                        <th scope="col">Business Suitable</th>
                                        <th scope="col">Views</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topics as $topic)
                                        <tr scope="row">
                                            <td>{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</td>
                                            <td>{{$topic->name}}</td>
                                            <td class="text-center"><i class="fas {{$topic->isMCApprove ? 'fa-check':'fa-times'}}"></i></td>
                                            <td class="text-center"><i class="fas {{$topic->isCBApprove ? 'fa-check':'fa-times'}}"></i></td>
                                            <td>858</td>
                                            <td>derp</td>
                                        </tr>
                                    @empty
                                        <tr scope="row"><td colspan="6"><h4 class="text-center">No topics avaliable</h4></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
