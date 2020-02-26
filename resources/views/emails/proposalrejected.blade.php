@component('mail::message')
# Proposal Rejected

Dear {{$proposal->student->firstName}}, 

This is to inform you that your proposal entitled, "{{$proposal->name}}" has unfortunately been <span class="font-weight-bold">rejected</span> by {{$proposal->supervisor->firstName.' '.$proposal->supervisor->lastName}} due to the following reason(s):

@component('mail::panel')
@if(is_null($reasoning)
No reason provided
@else
{{$reasoning}}
@endif
@endcomponent

This proposal is now deleted from your list of choices.

Kind regards,<br>
{{ config('app.name') }}
@endcomponent