<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LoanAmortizationSchedule;

class LoanAmortizationPaymentPolicy
{
    public static function process(LoanAmortizationSchedule $loan_schedule){
        if (auth()->id() != $loan_schedule->loan->barrower->id) {
            abort(403, 'Access Forbidden.');
        } 

        if ($loan_schedule->status != 'ready for payment') {
            abort(400, 'Unable to process request');
        }
    }
}
