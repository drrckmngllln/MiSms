<?php

namespace App\Mail;

use App\Models\adddetails as ModelsAdddetails;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddDetails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $email;
    private ModelsAdddetails $name;

    public function __construct($name)
    {
        //
        $this->email = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $generalSetting = ModelsAdddetails::first();
        return new Envelope(
            subject: 'MEDICAL COLLEGES OF NORTHERN PHILIPPINES AND INTERNATIONAL SCHOOL
            OF ASIA AND THE PACIFIC ',
            // with: [
            //     'name' => $this->room,
            // ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Roles.Super_Administrator.mailing.emailapproved',
            with: [
                'name' => $this->name->room,
            ]
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