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
                    <!-- If Auth User has created a choice based on th -->
                    <form action="{{route('choices.destroy', $topic)}}" method="post">
                        @method('delete')
                        @csrf                        
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="topic" id="topic" value="{{$topic}}">
                        <input class="btn btn-warning btn-block" type="submit" value="Unpick this Topic">
                    </form>
                @else
                    <form action="{{route('choices.store', $topic)}}" method="post">
                        @csrf
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="topic" id="topic" value="{{$topic}}">
                        <input class="btn btn-success btn-block" type="submit" value="Pick This Topic">
                    </form>
                @endif
            @else
                <a class="btn btn-info btn-block" >View Interested Students</a>
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
</div>
@endsection