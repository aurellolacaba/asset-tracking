<?php

namespace App\Listeners;

use App\Events\LoanRequestApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoanApplicationApproved;

class SendEmailNotificationToBarrower implements ShouldQueue
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
     * @param  \App\Events\LoanRequestApproved  $event
     * @return void
     */
    public function handle(LoanRequestApproved $event)
    {
        Mail::to($event->loan_application->barrower->email)
            ->send(new LoanApplicationApproved($event->loan_application));
    }
}
