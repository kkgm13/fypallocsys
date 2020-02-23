@component('mail::message')

Dear {{$allocation->student->firstName}},

You have been officially assigned the following project topic:

@component('mail::panel')
Project Name: {{$allocation->topic->name}}<br>
@endcomponent

Your assigned supervisor will be {{$allocation->supervisor->firstName.' '. $allocation->supervisor->lastName}}.

Please start making contact with them – <i>you don’t need to wait until the start of term!</i> You can discuss the outline of the project and get some ideas for background reading that you may do over the summer.

Any questions, do get in touch (use e-mail, I may be working from home during much of August).

See you in the autumn!

Thanks,<br>
Megan Robertson
@endcomponent
