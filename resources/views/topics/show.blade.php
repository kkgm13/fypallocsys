@extend('layouts.app')

@section('title')
{{$topic->name}}
@endsection
<div class="container mx-auto px-4 w-full">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <h1 class="text-4xl p-4 text-center">Edit {{$topic->name}}</h1>
    <hr>
    <p>Supervisor: <a href="mailto:{{$topic->supervisorID->email}}">{{$topic->supervisorID->name}}</a></p>
    <h6 class="text-md p-4">Topic Description</h6>
    <p>{{$topic->description}}</p>
    <h3 class="text-lg p-2">Topic Prequisites</h3>
    <p>{{$topic->prequisites}}</p>
    <p>Suitable for MC: <span>{{$topic->isMCApprove ? Yes : No}}</span></p>
    <p>Suitable for BC: <span>{{$topic->isCBApprove ? Yes : No}}</span></p>
    <hr>
    <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 px-2">
            @if(Auth::user()->role === "Student")
                <a class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" href="#">Select Topic</a>
            @else
                <a class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" href="#">View Interested Students</a>
            @endif
        </div>
        <div class="w-full md:w-1/2 px-2">
            @if(Auth::user()->role === "Student")
                <a class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" href="{{route('home')}}">Back to Topics List</a>
            @else
                <a class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" href="{{route('topics.edit', $topics)}}">Edit Topic</a>
            @endif
        </div>
    </div>
</div>
@section('content')
@endsection