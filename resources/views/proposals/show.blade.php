@extends('layouts.app')
@section('title')
{{$proposal->name}}
@endsection
@section('content')
<div class="container">
    @include('layouts.status')
    @if(Auth::user()->role === "Student")
        @if(!is_null($proposal->hasRejected) && $proposal->hasRead == 1)
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Decision:</strong>{{$proposal->hasRejected ? " Proposal is Rejected." : "Proposal is Approved."}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @endif
    <h1 class="text-center">{{$proposal->name}}</h1>
    <p class="pt-2 text-center">Proposal Owner: <a href="mailto:{{$proposal->student->email}}">{{$proposal->student->firstName.' '.$proposal->student->lastName}}</a></p>
    <p class="pt-2 text-center"></p>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <h3>Proposal Description</h3>
            <p class="pl-4">{!!$proposal->description!!}</p>
        </div>
        <div class="col-md-5">
            <h3>Proposal Reasoning</h3>
            <p class="pl-4">{!!$proposal->reasoning!!}</p>
        </div>
    </div>
    <hr>
    @if(Auth::id() === $proposal->supervisorID || Auth::user()->role === "Module Leader")
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <form action="{{route('proposals.decision', $proposal)}}" method="post">
                @csrf
                <input type="hidden" id="decision" name="decision" value="accepted">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                <input class="btn btn-success btn-block" type="submit" value="Accept Proposal">
            </form>
        </div>
        <div class="col-md-6 col-sm-12">
            <form action="{{route('proposals.decision', $proposal)}}" method="post">
                @csrf
                <input type="hidden" id="decision" name="decision" value="rejected">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                <input class="btn btn-danger btn-block" type="submit" value="Reject Proposal">
            </form>
            <!-- <a class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectingProposal">Reject Proposal</a> -->
        </div>
    </div>
    @endif
    @if(Auth::user()->role != "Student")
    <div class="modal fade" id="rejectProposal" tabindex="-1" role="dialog" aria-labelledby="rejectProposalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reasoning Section</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" name="reasoning" id="reasoning" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Reject Proposal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection