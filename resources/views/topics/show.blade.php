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
    <p class="pl-4">{!!$topic->description!!}</p>
    <!-- Final Year Conditions -->
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
    <br>
    <h4 class="py-3">Relevant Documents</h4>
    @forelse($topic->documents as $documents)
        @if($loop->first)
            <ul>
        @endif
            <li><a href="{{asset('/storage/graphics/Logo.png')}}">{{$document->fileName}}</a></li>
        @if($loop->last)
            </ul>
        @endif
    @empty
        <p class="pl-4">No Documents available</p>
    @endforelse
    <hr>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            @if(Auth::user()->role === "Student")
                @if(!is_null($topic->name))
                <a class="btn btn-success btn-block" data-toggle="modal" data-target="#reasoningModal">Pick this topic</a>
                @else
                <a class="btn btn-success btn-block">Unselect this topic</a>
                @endif
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
    <div class="modal fade" id="reasoningModal" tabindex="-1" role="dialog" aria-labelledby="reasoningModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Reasoning Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <input type="text" name="reasoning" id="reasoning">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection