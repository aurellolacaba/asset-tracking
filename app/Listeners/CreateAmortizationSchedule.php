<?php

namespace App\Listeners;

use App\Events\LoanReleased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LoanAmortizationSchedule;

class CreateAmortizationSchedule
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
     * @param  \App\Events\LoanReleased  $event
     * @return void
     */
    public function handle(LoanReleased $event)
    {   
        $loan_application = $event->loan_application;

        $date_of_payment = $loan_application->release_date->addDays(30);
        $beginning_balance = $loan_application->loan_amount;
        $balance = $loan_application->loan_amount - $loan_application->monthly_payment;

        for ($i=0; $i < $loan_application->terms; $i++) { 
            LoanAmortizationSchedule::create([
                'loan_application_id' => $loan_application->id,
                'date_of_payment' => $date_of_payment->format('Y-m-d'),
                'beginning_balance' => $beginning_balance,
                'scheduled_payment' => $loan_application->monthly_payment,
                'balance' => $balance,
                'status' => 'pending'
            ]);

            $date_of_payment = $date_of_payment->addDays(30);
            $beginning_balance = $balance;
            $balance = $balance - $loan_application->monthly_payment;
        }
    }
}
