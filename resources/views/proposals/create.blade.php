@extends('layouts.app')
@section('title')
Create a Proposal
@endsection
@section('content')
<div class="container mx-auto px-4 w-full">
    <h1 class="text-center py-1">Create your proposal</h1>
    <p class="text-muted text-center font-italic">Got a topic you want to propose to a lecturer? Fill this out and the lecturer will review the proposal's suitability<br>Please note that some lectuers will not reply instantly, due to academic or personal commitments.</p>
    @includeWhen($errors->any(), 'layouts.form-alerts')
    <form action="{{route('proposals.store')}}" method="post" class="py-1" enctype="multipart/form-data" onsubmit="return confirm('By continuing, you will be sending your proposal to your selected supervisor. You will no longer have the ability to edit this proposal once sent')">
        <hr>
        @csrf
        <fieldset>
            <div class="form-group">
                <label for="name">Proposal Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" aria-describedby="nameHelp" placeholder="Proposal Name" value="{{old('name')}}">
                <!-- <small id="nameHelp" class="form-text text-muted">This will be checked against the database for duplicate Proposals.</small> -->
            </div>
        </fieldset>
        <fieldset>
            <div class="form-group">
                <label for="description">Proposal Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Proposal Description">{{ old('description') }}</textarea>
            </div>
        </fieldset> 
        <fieldset>
            <div class="form-group">
                <label for="supervisorID">Preferred Supervisor</label>
                <select class="form-control @error('supervisorID') is-invalid @enderror" id="supervisorID" name="supervisorID">
                    <option value="" selected disabled>Please select a Supervisor</option>
                    @foreach($supervisors as $supervisor)
                        <option value="{{$supervisor->id}}">{{$supervisor->firstName." ". $supervisor->lastName}}</option>
                    @endforeach
                </select>
            </div>
        </fieldset>
        <fieldset>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="prequisites">Proposal Prequisites</label>
                        <textarea class="form-control" id="prequisites" name="prequisites" aria-describedby="coquisitesHelp" placeholder="Proposal prequisites" rows="3">{{old('prequisites')}}</textarea>
                        <small id="coquisitesHelp" class="form-text text-muted">If necessary, please provide any corequisite module codes / support type needed during your final year.</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="reasoning">Supervior Reasoning</label>
                        <textarea class="form-control @error('reasoning') is-invalid @enderror" id="reasoning" name="reasoning" rows="3" aria-describedby="reasoningHelp" placeholder="Supervisor Reasoning">{{ old('reasoning') }}</textarea>
                        <small id="reasoningHelp" class="form-text text-muted">In 100 words or less, please state why you have chosen this supervisor for your proposal.</small>
                    </div>
                </div>
            </div>
        </fieldset>
        <hr>
        <div class="row">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="col-md-6 col-sm-12 py-1">
                <input type="submit" value="Create & Send Proposal" class="btn btn-success btn-block">
            </div>
            <div class="col-md-6 col-sm-12 py-1">
                <input type="reset" value="Reset" class="btn btn-danger btn-block">
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{asset('js/tinymce-options.js')}}"></script>
@endsection