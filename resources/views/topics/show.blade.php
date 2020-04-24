@extends('layouts.app')
@section('title')
{{$topic->name}}
@endsection
@section('content')
<div class="container">
    @includeif('layouts.status')
    <h1 class="text-center">{{$topic->name}}</h1>
    <p class="pt-2 text-center">Project Supervisor: <a href="" data-toggle="modal" data-target="#supervisor-bio">{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</a> <i class="fas fa-search"></i></p>
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
    @if(Auth::user()->role == "Student" && is_null(Auth::user()->allocation))
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
                    <a href="{{route('choices.destroy', $topic)}}" class="btn btn-warning btn-block mb-2">Unpick this Topic</a>
                @else
                    <!-- <form action="{{route('choices.store', $topic)}}" method="post">
                        @csrf
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <input type="hidden" name="topic" id="topic" value="{{$topic}}">
                        <input class="btn btn-success btn-block" type="submit" value="Pick This Topic">
                    </form> -->
                    <a href="{{route('choices.store', $topic)}}" class="btn btn-success btn-block mb-2">Pick This Topic</a>
                @endif
            @else
                <a class="btn btn-info btn-block mb-2" data-toggle="modal" data-target="#interestedList">View Interested Students</a>
            @endif
        </div>
        <div class="col-md-6 col-sm-12">
            @if(Auth::user()->role === "Student")
                <a class="btn btn-danger btn-block mb-2" href="{{route('topics.index')}}">Back to Topics List</a>
            @else
                <a class="btn btn-warning btn-block mb-2" href="{{route('topics.edit', $topic)}}">Edit this topic</a>
            @endif
        </div>
    </div>
    @endif
    @if(Auth::user()->role != "Student")
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
                    <form action="{{route('topics.allocate', $topic)}}" method="post" onsubmit="return confirm('By officially allocating this student, you, the topic supervisor, are happy with having this student for this topic and also be their assigned personal tutor during the student\'s final year.')">
                        @csrf
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <table class="table table-borderless">
                            @forelse($topic->interested as $student)
                            <tr scope="row">
                                <td>
                                    <span class="font-weight-bold">{{$student->firstName.' '.$student->lastName}}</span><br><span class="pl-3">SUN ID: {{$student->sun}}</span>
                                </td>
                                <td>
                                    <input type="hidden" name="user" id="user" value="{{$student}}">
                                    <input class="mb-3 btn btn-success float-right" type="submit" value="Allocate">
                                </td>
                            </tr>
                            @empty
                                <td>
                                    <h6>No Students</h6>
                                </td>
                            @endforelse
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="modal fade" id="supervisor-bio" tabindex="-1" role="dialog" aria-labelledby="supervisor-bio" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">Supervisor Bio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</h3>
                    <p><a href="mailto:{{$topic->supervisor->email}}"><i class="fas fa-envelope"></i></a> Questions? Email Me</p>
                    <hr>
                    <p>{{strip_tags($topic->supervisor->bio)}}</p>
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