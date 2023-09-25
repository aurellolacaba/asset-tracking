<?php

namespace App\Listeners;

use App\Events\LoanApplicationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewLoanApplicationRequest;

class SendEmailNotificationToLender implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LoanApplicationCreated  $event
     * @return void
     */
    public function handle(LoanApplicationCreated $event)
    {
        Mail::to($event->loan_application->lender->email)
            ->send(new NewLoanApplicationRequest($event->loan_application));
    }
}
