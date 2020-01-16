@extends('layouts.app')
@section('title')
{{$proposal->name}}
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
    <h1 class="text-center">{{$proposal->name}}</h1>
    <p class="pt-2 text-center">Proposal Owner: <a href="mailto:{{$proposal->student->email}}">{{$proposal->student->firstName.' '.$proposal->student->lastName}}</a></p>
    <hr>
    <div class="row">
        <div class="col-md-7">
            <h3>Proposal Description</h3>
            <p class="pl-4">{!!$proposal->description!!}</p>
        </div>
        <div class="col-md-5">
            <h3>Reason to do the proposal</h3>
            <p class="pl-4">{!!$proposal->reasoning!!}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <a href="" class="btn btn-success btn-block">Accept Proposal</a>
        </div>
        <div class="col-md-6 col-sm-12">
        <a href="" class="btn btn-danger btn-block">Reject Proposal</a>
        </div>
    </div>
</div>
@endsection