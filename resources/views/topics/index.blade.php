@extends('layouts.app')
@section('title')
Topics List
@endsection

@section('content')
<div class="container">
    @include('layouts.status')
    <h1 class="text-center">
        @if(Auth::user()->role == "Student")
            Avaliable Topics
        @else 
            My Topics
        @endif
    </h1>
    <hr>
    <!-- <div class="container"> -->
        <div class="row px-3 px-lg-1">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered table-hover ">
                    <thead class="text-center">
                        <tr>
                            <th scope="col" rowspan="2">Supervisor</th>
                            <th scope="col"rowspan="2">Topic Title</th>
                            <th scope="col"rowspan="2">Topic Description</th>
                            <th colspan="2">Course Suitability</th>
                            <th scope="col"rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th scope="col">Multimedia</th>
                            <th scope="col">Business</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topics as $topic)
                            <tr scope="row">
                                <td>{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</td>
                                <td>{{$topic->name}}</td>
                                <td>{{strip_tags(substr($topic->description, 0, 100)."..."))}}</td>
                                <td class="text-center"><i class="fas {{$topic->isMCApprove ? 'fa-check':'fa-times'}}"></i></td>
                                <td class="text-center"><i class="fas {{$topic->isCBApprove ? 'fa-check':'fa-times'}}"></i></td>
                                <td>
                                    <div class="btn-group d-flex" role="group" aria-label="Topic Settings">
                                        <a href="{{route('topics.show', $topic)}}" class="btn btn-secondary w-100"><i class="fas fa-search"></i></a>
                                        @if(! in_array($topic->id, Auth::user()->choices->pluck('topicID')->toArray()))
                                            <!-- <form action="{{route('choices.store', $topic)}}" method="post">
                                                @csrf
                                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                                <input type="hidden" name="topic" id="topic" value="{{$topic}}">
                                                <input class="btn btn-success btn-block fas fa-plus" type="submit" value="+">
                                            </form> -->
                                            <a href="{{route('choices.store', $topic)}}" class="btn btn-success w-100"><i class="fas fa-plus"></i></a>
                                        @else
                                            <!-- <form action="{{route('choices.destroy', $topic)}}" method="post">
                                                @method('delete')
                                                @csrf                        
                                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                                <input type="hidden" name="topic" id="topic" value="{{$topic}}">
                                                <input class="btn btn-warning btn-block fa fas-minus" type="submit" value="">
                                            </form> -->
                                            <a href="{{route('choices.destroy', $topic)}}" class="btn btn-warning"><i class="fas fa-minus"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr scope="row"><td colspan="6"><h4 class="text-center">No topics avaliable</h4></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    <!-- </div> -->
</div>
@endsection