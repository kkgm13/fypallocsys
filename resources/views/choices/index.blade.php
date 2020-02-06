@extends('layouts.app')
@section('title')
Topics Interested
@endsection
@section('content')
<div class="container mx-auto px-4 w-full">
    <h1 class="text-center">My Topic Choices</h1>
    <hr>
    <div class="row px-3">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead class="">
                    <tr>
                        <th>Topic Name</th>
                        <th>Supervisor</th>
                        <th class="d-none d-md-block d-lg-none">Topic Description</th>
                        <th>Your Ranking</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($choices as $choice)
                    <tr>
                        <td>{{$choice->topic->name}}</td>
                        <td>{{$choice['topic']->supervisor->firstName.' '.$choice['topic']->supervisor->lastName}}</td>
                        <td class="d-none d-md-block d-lg-none">{{substr($choice->topic->description, 0, 90)."..."}}</td>
                        <td>{{$choice->ranking}}</td>
                        <td>
                            <div class="btn-group d-flex" role="group" aria-label="Choice Settings">
                                <a href="{{route('topics.show', $choice->topic)}}" class="btn btn-secondary"><i class="fas fa-search"></i></a>
                                <a href="{{route('topics.destroy', $choice->topic)}}" class="btn btn-danger"><i class="fas fa-times"></i></a>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group-vertical d-flex">
                                @if(!$loop->first)
                                <a onclick="alert('In Development')" class="btn btn-info"><i class="fas fa-caret-up"></i></a>
                                @endif
                                @if(!$loop->last)
                                <a onclick="alert('In Development')" class="btn btn-info"><i class="fas fa-caret-down"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4">
                            <h5>You have not yet chosen any topics.</h5>
                            <div class="btn-group d-flex" role="group" aria-label="Choice Settings">
                                <a href="{{route('topics.index')}}" class="btn btn-secondary w-100">View Available Topics</a>
                                <a href="{{route('proposals.create')}}" class="btn btn-secondary w-100">Create a Proposal</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection