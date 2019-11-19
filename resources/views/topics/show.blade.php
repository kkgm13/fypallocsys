@extends('layouts.app')

@section('title')
{{$topic->name}}
@endsection

@section('content')
<div class="container mx-auto px-4 w-full">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <h1 class="text-4xl p-4 text-center">{{$topic->name}}</h1>
    <hr/>
    <p>Supervisor: <a href="mailto:{{$topic->supervisor->email}}">{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</a></p>
    <h6 class="py-3 text-md">Topic Description</h6>
    <p class="p-4">{{$topic->description}}</p>
    <h3 class="text-lg py-3">Topic Prequisites</h3>
    <p class="p-4">{{$topic->prequisites}}</p>
    <p>Suitable for MC: <span>{{$topic->isMCApprove ? 'Yes' : 'No'}}</span></p>
    <p>Suitable for BC: <span>{{$topic->isCBApprove ? 'Yes' : 'No'}}</span></p>
    <hr class="py-2">
    <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 px-2">
            @if(Auth::user()->role === "Student")
                <a class="w-full text-lg font-bold bg-blue-500 text-white text-center rounded-lg px-6 py-3 block hover:bg-blue-700" href="#">Pick this topic</a>
            @else
                <a class="w-full text-lg font-bold bg-blue-500 text-white text-center rounded-lg px-6 py-3 block hover:bg-blue-700" href="#">View Interested Students</a>
            @endif
        </div>
        <div class="w-full md:w-1/2 px-2">
            @if(Auth::user()->role === "Student")
                <a class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" href="{{route('home')}}">Back to Topics List</a>
            @else
                <a class="w-full text-lg font-bold bg-red-500 text-white text-center rounded-lg px-6 py-3 block hover:bg-red-700" href="{{route('topics.edit', $topic)}}">Edit Topic</a>
            @endif
        </div>
    </div>
</div>
@endsection