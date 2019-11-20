@extends('layouts.app')
@section('title')
Create a New Topic
@endsection
@section('content')
<div class="container mx-auto px-4 w-full">
    <h1 class="text-4xl p-4 text-center">Create a Topic</h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('topics.store')}}" method="post" class="py-5">
        @csrf
        <fieldset>
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">Topic Name</label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" name="name" type="text" placeholder="Topic Name" value="{{ old('name') }}" >
            </div>
        </fieldset>
        <fieldset>
            <div class="flex flex-wrap">
                <div class="w-full lg:w-3/4 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="description">Topic Description</label>
                    <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="description" name="description" type="text" placeholder="Topic Description">{{ old('description') }}</textarea>
                </div>            
                <div class="w-full lg:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="prequisites">Topic Prequisites</label>
                    <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="prequisites" name="prequisites" type="text" placeholder="Topic Prequisites">{{ old('prequisites') }}</textarea>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="md:flex mx-5 mb-6">
                <label class=" block text-gray-500 font-bold">
                    <input class="mr-2 leading-tight" type="checkbox" name="isMCApprove" value="1">
                    <span for="isMCApprove" class="text-sm">Suitable for MC</span>
                </label>
            </div>
            <div class="md:flex mx-5 mb-6">
                <label class=" block text-gray-500 font-bold">
                    <input class="mr-2 leading-tight" type="checkbox" name="isCBApprove" value='1'>
                    <span for="isCBApprove" class="text-sm">Suitable for BC</span>
                </label>
            </div>
        </fieldset>
        @if(Auth::user()->role == "Module Leader")
        <fieldset>
            <div class="w-full px-5 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="supervisorID">
                    Appointed Supervisor
                </label>
                <div class="relative">
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="supervisorID" id="supervisorID">
                        @foreach($supervisors as $supervisor)
                            <option value="{{$supervisor->id}}">{{$supervisor->firstName." ". $supervisor->lastName}}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </fieldset>
        @endif
        <br>
        <hr class="py-2">
        <div class="flex flex-wrap">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="w-full md:w-1/2 px-2">
                <input type="submit" value="Create Topic" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
            </div>
            <div class="w-full md:w-1/2 px-2">
                <input type="reset" value="Reset" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
            </div>
        </div>
    </form>
</div>
@endsection