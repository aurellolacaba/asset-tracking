<?php

namespace App\Http\Controllers\LoanApplication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Enums\LoanApplicationStatus;

class ReleaseController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoanApplication $loan_application)
    {
        if (auth()->user()->isNot($loan_application->lender)) {
            return response()->json(['message' => 'Access Forbidden.'], 403);
        } 
        
        if ($loan_application->status->value == 'releasing') {
            return response()->json(['message' => 'Unable to process request'], 400);
        }

        $loan_application->update([
            'status' => LoanApplicationStatus::RELEASING
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $loan_application
        ], 200);
    }
}
