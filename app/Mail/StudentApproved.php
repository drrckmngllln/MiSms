<?php

namespace App\Mail;

use App\Models\adddetails;
use App\Models\StudentApplicant;
use App\Models\StudentsAdmitted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $email;
    public function build()
    {
    }


    public function __construct($email)
    {
        //
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        $generalSetting = adddetails::first();
        return new Envelope(
            subject: 'Welcome to MEDICAL COLLEGES OF NORTHERN PHILIPPINES AND INTERNATIONAL SCHOOL
            OF ASIA AND THE PACIFIC ' . $generalSetting->email,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Roles.Super_Administrator.mailing.emailapproved',
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
