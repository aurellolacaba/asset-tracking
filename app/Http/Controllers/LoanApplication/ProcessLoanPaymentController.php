<?php

namespace App\Http\Controllers\LoanApplication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanApplication\ProcessLoanPaymentRequest as PaymentRequest;
use App\Models\LoanAmortizationSchedule as LoanSchedule;
use Illuminate\Support\Facades\Http;
use App\Services\Payment\Payment;
use App\Policies\LoanAmortizationPaymentPolicy;

class ProcessLoanPaymentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  App\Models\LoanAmortizationSchedule  $loan_schedule
     * @param  App\Models\ProcessLoanPaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoanSchedule $loan_schedule, PaymentRequest $request)
    {
        LoanAmortizationPaymentPolicy::process($loan_schedule);
        
        $payment = new Payment($request->payment_method);
        $payment->arguments($this->getArguments($loan_schedule));

        $redirect_url = $payment->pay();
        
        return response()->json([
            'message' => 'success',
            'data' => [
                'redirect_url' => $redirect_url
            ]
        ]);
    }

    private function getArguments(LoanSchedule $loan_schedule) {
        return [
            'amount' => $loan_schedule->scheduled_payment,
            'billing' => [
                'name' => $loan_schedule->loan->barrower->name,
                'email' => $loan_schedule->loan->barrower->email
            ],
            'metadata' => [
                'reference_id' => $loan_schedule->id
            ]
        ];
    }
}
