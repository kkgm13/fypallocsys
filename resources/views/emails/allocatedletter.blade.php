@component('mail::message')
# And so it begins...

Dear {{$allocation->student->firstName.' '.$allocation->student->lastName}},

You have been assigned the {{is_null($allocation->topic) ? '[Proposal] project: '.$allocation->proposal->name : 'project: '.$allocation->topic->name}}

Your assigned supervisor will be {{$allocation->supervisor->firstName.' '.$allocation->supervisor->lastName}}.

Please make contact with them – you don’t need to wait until the start of term! You can discuss the outline of the project and get some ideas for background reading that you may do over the summer.

Any questions, do get in touch (use e-mail, I may be working from home during much of August).

See you in the autumn! <br>
Megan
@endcomponent
