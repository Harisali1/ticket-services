<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgencyApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $agency;
    public $loginUrl;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $agency)
    {
        $this->user = $user;
        $this->agency = $agency;
        $this->loginUrl = route('login');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
       return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(
                'noreply@divinetravel.it',
                'Divine Travel'
            ),
            subject: 'Welcome to Divine Travel'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Admin.email_template.agency_approval', // ✅ Blade email view
            with: [
                'user' => $this->user,
                'agency' => $this->agency,
                'loginUrl' => $this->loginUrl,
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
