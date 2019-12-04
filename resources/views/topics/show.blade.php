@extends('layouts.app')

@section('title')
{{$topic->name}}
@endsection

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session('status') }}
        </div>
    @endif
    <h1 class="text-center">{{$topic->name}}</h1>
    <p class="pt-2 text-center">Project Supervisor: <a href="mailto:{{$topic->supervisor->email}}">{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</a></p>
    <p class="pb-2 text-center font-italic">Suitable for CS Students <span class="font-weight-bolder">{{$topic->isMCApprove ? '& CS Multimedia Students' : $topic->isCBApprove ? '& CS Business Students' : $topic->isMCApprove && $topic->isCBApproved ? 'including Multimedia & Business students' : 'ONLY'}}</span></p>
    <hr>
    <h3 class="py-3">Topic Description</h3>
    <p class="pl-4">{{$topic->description}}</p>
    <div class="row">
        <div class="col-md-6">
            <h4 class="py-3">Topic Prequisites</h4>
            <p class="pl-4">
                @if(! is_null($topic->prequisites))
                    {{$topic->prequisites}}
                @else
                    No prequisites for this topic.
                @endif
            </p>
        </div>
        <div class="col-md-6">
            <h4 class="py-3">Topic Corequisites</h4>
            <p class="pl-4">
                @if(! is_null($topic->corequisites))
                    {{$topic->corequisites}}
                @else
                    No corequisites for this topic.
                @endif
            </p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            @if(Auth::user()->role === "Student")
                <a class="btn btn-success btn-block" href="#">Pick this topic</a>
            @else
                <a class="btn btn-info btn-block" href="#">View Interested Students</a>
            @endif
        </div>
        <div class="col-md-6 col-sm-12">
            @if(Auth::user()->role === "Student")
                <a class="btn btn-danger btn-block" href="{{route('home')}}">Back to Topics List</a>
            @else
                <a class="btn btn-warning btn-block" href="{{route('topics.edit', $topic)}}">Edit this topic</a>
            @endif
        </div>
    </div>
</div>
@endsection