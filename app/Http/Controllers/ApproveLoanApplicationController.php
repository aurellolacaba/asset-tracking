<?php

namespace App\Http\Controllers;

use App\Events\LoanRequestApproved;
use App\Models\LoanApplication;
use Illuminate\Http\Response;

class ApproveLoanApplicationController extends Controller
{
   
    public function __invoke(LoanApplication $loan_application)
    {
        $loan_application->approveByLender();

        event(new LoanRequestApproved($loan_application));

        return Response::jsonSuccess($loan_application);
    }
}
