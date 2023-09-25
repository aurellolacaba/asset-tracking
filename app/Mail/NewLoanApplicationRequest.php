<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LoanApplication;

class NewLoanApplicationRequest extends Mailable
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
            subject: 'New Loan Application Request',
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
            view: 'emails.new_loan_application_request',
        );
    }
}
