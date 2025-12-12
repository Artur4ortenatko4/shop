<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */


    protected $title;
    protected $description;

    /**
     * Create a new message instance.
     */
    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     */
    public function build(): NewsletterMail
    {
        return $this->subject('Новий лист розсилки')
            ->view('emails.newsletter')
            ->with([
                'title' => $this->title,
                'description' => $this->description,
            ]);
    }
}
