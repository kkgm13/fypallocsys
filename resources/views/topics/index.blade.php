@extends('layouts.app')
@section('title')
Topics List
@endsection

@section('content')
<div class="container-fluid">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1 class="text-center">
        @if(Auth::user()->role != "Student")
            Proposal Requests
        @else 
            My Proposals
        @endif
    </h1>
    <hr>
    <br>
    <div class="row px-5">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover ">
                <thead class="text-center">
                    <tr>
                        <th scope="col" rowspan="2">Supervisor</th>
                        <th scope="col"rowspan="2">Topic Title</th>
                        <th scope="col"rowspan="2">Topic Description</th>
                        <th colspan="2">Course Suitability</th>
                        <th scope="col"rowspan="2">Available Actions</th>
                    </tr>
                    <tr>
                        <th scope="col">Multimedia Students</th>
                        <th scope="col">Business Students</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topics as $topic)
                        <tr scope="row">
                            <td>{{$topic->supervisor->firstName.' '.$topic->supervisor->lastName}}</td>
                            <td>{{$topic->name}}</td>
                            <td>{{substr($topic->description, 0, 100)."..."}}</td>
                            <td class="text-center"><i class="fas {{$topic->isMCApprove ? 'fa-check':'fa-times'}}"></i></td>
                            <td class="text-center"><i class="fas {{$topic->isCBApprove ? 'fa-check':'fa-times'}}"></i></td>
                            <td>
                                <div class="btn-group d-flex" role="group" aria-label="Topic Settings">
                                    <a href="{{route('topics.show', $topic)}}" class="btn btn-secondary w-100"><i class="fas fa-search"></i></a>
                                    <a onclick="alert('In Development')" class="btn btn-info w-100"><i class="fas fa-plus"></i></a>
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
</div>
@endsection