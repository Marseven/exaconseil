<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Policy;

class PolicyExpirationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $policies;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($policies)
    {
        $this->policies = $policies;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("contact@mebodorichard.com", env('APP_NAME'))
            ->subject('Notification de date d\'expiration de la police')
            ->markdown('emails.policy-expiration')
            ->with('policies', $this->policies);
    }
}
