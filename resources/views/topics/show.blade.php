@extends('layouts.app')

@section('title')
{{$topic->name}}
@endsection

@section('content')
<div class="container mx-auto px-4 w-full">
    @if(session()->has('message'))
        <div class="bg-green-100 border border-greeen-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="font-bold">{{ucfirst(session()->get('status'))}}!</span>
            <span class="text-sm">{{ session()->get('message') }}</span>
        </div>
    @endif
    <h1 class="text-4xl p-4 text-center">{{$topic->name}}</h1>
    <p class="py-2 text-center">Project Supervisor: <a href="mailto:{{$topic->supervisor->email}}">{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</a></p>
    <hr class="py-1">
    <h6 class="py-3 text-lg font-semibold">Topic Description</h6>
    <p class="p-4 text-base">{{$topic->description}}</p>
    <h3 class="text-lg py-3 font-semibold">Topic Prequisites</h3>
    <p class="p-4 text-base">
        @if(! is_null($topic->prequisites))
            {{$topic->prequisites}}
        @else
            No prequisites availiable.
        @endif
    </p>
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