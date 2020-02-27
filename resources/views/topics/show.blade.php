@extends('layouts.app')
@section('title')
{{$topic->name}}
@endsection
@section('content')
<div class="container">
    @includeif('layouts.status')
    <h1 class="text-center">{{$topic->name}}</h1>
    <p class="pt-2 text-center">Project Supervisor: <a href="mailto:{{$topic->supervisor->email}}">{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</a></p>
    <p class="pb-2 text-center font-italic">Suitable for CS Students <span class="font-weight-bolder">{{$topic->isMCApprove ? '& CS Multimedia Students' : $topic->isCBApprove ? '& CS Business Students' : $topic->isMCApprove && $topic->isCBApproved ? 'including Multimedia & Business students' : 'ONLY'}}</span></p>
    <hr>
    <h3 class="py-3">Topic Description</h3>
    <p class="pl-4">{!!$topic->description!!}</p>
    <div class="row">
        <div class="col-md-6">
            <h4 class="py-3">Topic Prequisites <sup><i class="fa fa-info-circle" title="These are courses you should have completed to do this topic."></i></sup></h4>
            <p class="pl-4">
                @if(! is_null($topic->prequisites))
                    {{$topic->prequisites}}
                @else
                    No prequisites for this topic.
                @endif
            </p>
        </div>
        <div class="col-md-6">
            <h4 class="py-3">Topic Corequisites <sup><i class="fa fa-info-circle" title="The modules below should be taken along side during your final year to do this topic."></i></sup></h4>
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
    <h4 class="py-1">Relevant Documents</h4>
    @forelse($topic->documents as $document)
        @if($loop->first)
            <ul>
        @endif
            <li><a href="{{asset('/storage/graphics/'.$document->fileName)}}">{{$document->fileName}}</a></li>
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
                @if(in_array(Auth::id(), $choices))
                    <!-- <form action="{{route('choices.destroy', $topic)}}" method="post">
                        @method('delete')
                        @csrf                        
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="topic" id="topic" value="{{$topic}}">
                        <input class="btn btn-warning btn-block" type="submit" value="Unpick this Topic">
                    </form> -->
                    <a href="{{route('choices.destroy', $topic)}}" class="btn btn-warning btn-block">Unpick this Topic</a>
                @else
                    <!-- <form action="{{route('choices.store', $topic)}}" method="post">
                        @csrf
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="topic" id="topic" value="{{$topic}}">
                        <input class="btn btn-success btn-block" type="submit" value="Pick This Topic">
                    </form> -->
                    <a href="{{route('choices.store', $topic)}}" class="btn btn-success btn-block">Pick This Topic</a>
                @endif
            @else
                <a class="btn btn-info btn-block" data-toggle="modal" data-target="#interestedList">View Interested Students</a>
            @endif
        </div>
        <div class="col-md-6 col-sm-12">
            @if(Auth::user()->role === "Student")
                <a class="btn btn-danger btn-block" href="{{route('topics.index')}}">Back to Topics List</a>
            @else
                <a class="btn btn-warning btn-block" href="{{route('topics.edit', $topic)}}">Edit this topic</a>
            @endif
        </div>
    </div>
    @if(AUth::user()->role != "Student")
    <div class="modal fade" id="interestedList" tabindex="-1" role="dialog" aria-labelledby="interestedList" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">Interested Students</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @forelse($topic->interested as $student)
                        <p class="mb-1"><span class="font-weight-bold">{{$student->firstName.' '.$student->lastName}}</span><br><span class="pl-3">SUN ID: {{$student->sun}}</span></p>
                        <a class="mb-3 btn btn-success w-100" href="#">Select Student</a>
                    @empty
                        <h6>No Students</h6>
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection