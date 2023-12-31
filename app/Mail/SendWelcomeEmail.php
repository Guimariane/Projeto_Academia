<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    // public $type_plan;
    // public $limit_plan;


    public function __construct($name)
    {
        $this->name = $name;
        // $this->type_plan = $type_plan;
        // $this->limit_plan = $limit_plan;

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seu cadastro da FitTech foi concluído!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'email.welcomeEmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
