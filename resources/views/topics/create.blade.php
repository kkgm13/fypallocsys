@extends('layouts.app')
@section('title')
Create a New Topic
@endsection
@section('content')
<div class="container mx-auto px-4 w-full">
    <h1 class="text-center py-1">Create a Topic</h1>
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul style="margin:0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('topics.store')}}" method="post" class="py-1" enctype="multipart/form-data">
        <hr>
        @csrf
        <fieldset>
            <div class="form-group">
                <label for="name">Topic Name</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Topic Name" value="{{old('name')}}">
                <small id="nameHelp" class="form-text text-muted">This will be checked against the database for duplicate topics.</small>
            </div>
        </fieldset>
        <fieldset>
            <!-- <div class="row"> -->
                <!-- <div class="col-12"> -->
                    <div class="form-group">
                        <label for="description">Topic Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Topic Description">{{ old('description') }}</textarea>
                    </div>
                <!-- </div> -->
                <!-- <div class="col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label for="skillset">Skills Set</label>
                        <textarea class="form-control" id="skillset" name="skillset" rows="3" placeholder="Topic Skillsets">{{ old('skillset', "<ul></ul>") }}</textarea>
                    </div>
                </div> -->
            <!-- </div> -->

            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label for="prequisites">Topic Prequisites</label>
                        <textarea class="form-control" id="prequisites" name="prequisites" aria-describedby="prequisitesHelp" rows="3" placeholder="Topic prequisites">{{ old('prequisites') }}</textarea>
                        <small id="prequisitesHelp" class="form-text text-muted">If required, please provide module prequisites needed for this module.</small>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label for="corequisites">Topic Corequisites</label>
                        <textarea class="form-control" id="corequisites" name="corequisites" aria-describedby="coquisitesHelp" placeholder="Topic Corequisites" rows="3">{{ old('corequisites') }}</textarea>
                        <small id="coquisitesHelp" class="form-text text-muted">If necessary, please provide all module corequisites needed during student's final year.</small>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <div class="row">
                <div class="col-md-6">
                    <label>Topic Suitablity</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="isMCApprove" name="isMCApprove">
                        <label class="form-check-label" for="isMCApprove">Suitable for Multimedia Students</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="isCBApprove" name="isCBApprove">
                        <label class="form-check-label" for="isCBApprove">Suitable for Business Students</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="topicDocuments[]">Related Topic Documents</label>
                        <input type="file" class="form-control-file" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf" id="topicDocuments[]" name="topicDocuments[]" aria-describedby="topicDocuments" multiple>
                        <small id="topicDocuments" class="form-text text-muted">If required, upload relevant files and images. Images will be resized when necessary.</small>
                    </div>
                </div>
            </div>
        </fieldset>
        @if(Auth::user()->role == "Module Leader")
        <fieldset>
            <div class="form-group">
                <label for="supervisorID">Appointed Supervisor</label>
                <select class="form-control" id="supervisorID" name="supervisorID">
                    @foreach($supervisors as $supervisor)
                        <option value="{{$supervisor->id}}">{{$supervisor->firstName." ". $supervisor->lastName}}</option>
                    @endforeach
                </select>
            </div>
            <!-- <div class="form-group">
                <label for="supervisorID">Secondary Assessor Supervisor</label>
                <select class="form-control" id="supervisorID" name="supervisorID" disabled>
                    @foreach($supervisors as $supervisor)
                        <option value="{{$supervisor->id}}">{{$supervisor->firstName." ". $supervisor->lastName}}</option>
                    @endforeach
                </select>
            </div> -->
        </fieldset>
        @endif
        <hr>
        <div class="row">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="col-md-6 col-sm-12 py-1">
                <input type="submit" value="Create Topic" class="btn btn-success btn-block">
            </div>
            <div class="col-md-6 col-sm-12 py-1">
                <input type="reset" value="Reset" class="btn btn-danger btn-block">
            </div>
        </div>
    </form>
</div>
@endsection