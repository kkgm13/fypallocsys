<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalReject extends Mailable
{
    use Queueable, SerializesModels;

    protected $reasoning,$proposal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.proposalrejected')
            ->subject('A decision is made with your proposal')
            ->with(['proposal' => $this->proposal, 'reasoning' => $this->reasoning])
            ;
    }
}
