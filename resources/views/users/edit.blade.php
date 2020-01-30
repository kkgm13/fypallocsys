@extends('layouts.app')
@section('title')
Edit Profile
@endsection
@section('content')
<div class="container mx-auto">
    <h1 class="text-center py-1">Edit Profile</h1>
    <hr>
    <form action="{{route('users.update', $user)}}" method="post" class="py-1">
        @csrf
        {{method_field('PATCH')}}
        <div class="row">
            <div class="col-lg-4">
                <fieldset >
                    <legend>Aston University Information</legend>
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input class="form-control" type="text" name="firstName" id="firstName" readonly aria-describedby="nameHelp" placeholder="Topic Name" value="{{old('firstName', $user->firstName)}}">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input class="form-control" type="text" name="lastName" id="lastName" readonly disabledaria-describedby="nameHelp" placeholder="Topic Name" value="{{old('lastName', $user->lastName)}}">
                    </div>
                    <div class="form-group">
                        <label for="email">Aston Email</label>
                        <input class="form-control" type="email" name="email" id="email" readonly disabledaria-describedby="nameHelp" placeholder="Topic Name" value="{{old('email', $user->email)}}">
                    </div>
                </fieldset>
            </div>
            <div class="col-lg-8">
                <fieldset>
                    <legend>Topic Allocation System Information</legend>
                    <div class="form-group">
                        <label for="bio">Topic bio</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="description" name="bio" rows="3" placeholder="Topic bio">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </fieldset>
            </div>
        </div>   
        <hr>
        <div class="row">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="col-md-6 col-sm-12">
                <input type="submit" value="Update Profile" class="btn btn-success btn-block">
            </div>
            <div class="col-md-6 col-sm-12">
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