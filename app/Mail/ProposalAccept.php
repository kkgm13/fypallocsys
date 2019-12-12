<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalAccept extends Mailable
{
    use Queueable, SerializesModels;

    protected $allocation;
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
        return $this->markdown('emails.proposalaccepted')
            ->subject('A decision is made with your proposal')
            ->with(["allocation" => $this->allocation])
            ->replyTo($this->allocation->supervisor['email']);
    }
}
