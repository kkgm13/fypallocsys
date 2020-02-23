<?php

namespace App\Mail;

use App\Allocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AllocationSelected extends Mailable
{
    use Queueable, SerializesModels;

    protected $allocation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Allocation $allocation)
    {
        $this->allocation = $allocation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.allocationsselected')
            ->subject('CS3010: And so it begins...')
            ->with([])
            ->replyTo($this->allocation->supervisor['email']);
    }
}
