@component('mail::message')
# Proposal Accepted

Dear {{$allocation->student->firstName}}, 

This is to inform you that your proposal, entitled, "{{$allocation->proposal->name}}" has been accepted by the supervisor, "{{$allocation->supervisor->firstName.' '.$allocation->supervisor->lastName}}".

This has now been added to your list of choices.


If necessary, please email your supervisor for any further information or queries.

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
