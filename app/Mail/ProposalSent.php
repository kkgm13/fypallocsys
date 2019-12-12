<?php

namespace App\Mail;

use App\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalSent extends Mailable
{
    use Queueable, SerializesModels;

    protected $proposal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.proposalsent')
            ->subject('A proposal has been submitted for your approval')
            ->with(['proposal' => $this->proposal,
                'url' => '/proposals/'.$this->proposal->id
                ]);
    }
}
