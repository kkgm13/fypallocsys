@component('mail::message')
# A New Proposal Request 

You have a proposal request from {{$proposal->student->firstName.' '.$proposal->student->lastName}} (in {{$proposal->student->programme}}) entitled "{{$proposal->name}}"

Supervisor Selection Reasoning:<br>
{{$proposal->reasoning}}

Please login to learn more about the proposal and either accept or reject the proposal.
<!-- Check Button URL -->
@component('mail::button', ['url' => '/proposals/{{$proposal->id}}'])
Learn More
@endcomponent

@component('mail::panel')
Note that accepting a proposal DOES NOT guarantee the student will be allocated to this project. This is also dependent upon the supervisor's workload and the overall allocation of students to projects.
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
