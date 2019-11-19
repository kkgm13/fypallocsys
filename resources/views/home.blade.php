@extends('layouts.app')
@section('title')
    @if(Auth::user()->role != "Student")
        Staff Dashboard
    @else
        Dashboard
    @endif
@endsection

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">
            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if(Auth::user()->role != "Student")
            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0 text-2xl text-center">
                    Dashboard
                </div>

                <div class="w-full p-6">
                    <p class="text-gray-700 py-2">
                        You are logged in, {{Auth::user()->firstName.' '.Auth::user()->lastName}}!
                    </p>
                    <hr class="py-2">
                    @if(Auth::user()->role == "Module Leader")
                        <h4 class="py-1 underline text-lg">All Authorized Topics</h4>
                    @else 
                        <h4 class="py-1 underline text-base">Your Topics</h4>
                    @endif
                    @forelse($topics as $topic)
                        <p class="py-2 hover:underline"><a href="{{route('topics.show', $topic)}}">{{$topic->name}}</a></p>
                    @empty
                        <p>No Topics Availiable</p>
                    @endforelse
                </div>
            </div>
            @else
            <table class="table-fixed">
                <thead>
                    <tr>
                    <th class="w-1/2 px-4 py-2">Title</th>
                    <th class="w-1/4 px-4 py-2">Author</th>
                    <th class="w-1/4 px-4 py-2">Views</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td class="border px-4 py-2">Intro to CSS</td>
                    <td class="border px-4 py-2">Adam</td>
                    <td class="border px-4 py-2">858</td>
                    </tr>
                    <tr class="bg-gray-100">
                    <td class="border px-4 py-2">A Long and Winding Tour of the History of UI Frameworks and Tools and the Impact on Design</td>
                    <td class="border px-4 py-2">Adam</td>
                    <td class="border px-4 py-2">112</td>
                    </tr>
                    <tr>
                    <td class="border px-4 py-2">Into to JavaScript</td>
                    <td class="border px-4 py-2">Chris</td>
                    <td class="border px-4 py-2">1,280</td>
                    </tr>
                </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
