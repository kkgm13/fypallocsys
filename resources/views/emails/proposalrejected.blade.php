@component('mail::message')
# Proposal Rejected

Dear {{$proposal->student->firstName}}, 

This is to inform you that your proposal entitled, "{{$proposal->name}}" has been rejected by {{$proposal->supervisor->firstName.''.$proposal->supervisor->lastName}} due to this reason:

@component('mail::panel')
{{$reasoning}}
@endcomponent

This proposal is now deleted from your list of choices.

Kind regards,<br>
{{ config('app.name') }}
@endcomponent
