<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $approvedAmount;
    public $paidAmount;
    public $remainingAmount;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $approvedAmount, $paidAmount, $remainingAmount)
    {
        $this->user = $user;
        $this->approvedAmount = $approvedAmount;
        $this->paidAmount = $paidAmount;
        $this->remainingAmount = $remainingAmount;
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
            subject: 'Payment Approved By Divine Travel'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Admin.email_template.payment_approval', // ✅ Blade email view
            with: [
                'user' => $this->user,
                'approvedAmount' => $this->approvedAmount,
                'paidAmount' => $this->paidAmount,
                'remainingAmount' => $this->remainingAmount,
            ]
        );
    }
}
