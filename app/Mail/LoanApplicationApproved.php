<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LoanApplication;

class LoanApplicationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $loan_application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(LoanApplication $loan_application)
    {
        $this->loan_application = $loan_application;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Loan Application Approved',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.loan_application_approved',
        );
    }
}
