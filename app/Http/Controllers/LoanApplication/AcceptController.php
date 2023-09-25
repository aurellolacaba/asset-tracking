<?php

namespace App\Http\Controllers\LoanApplication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Enums\LoanApplicationStatus;
use App\Events\LoanReleased;

class AcceptController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoanApplication $loan_application)
    {
        if (auth()->id() != $loan_application->barrower_id) {
            return response()->json(['message' => 'Access Forbidden.'], 403);
        } 
        
        if ($loan_application->status->value != 'releasing') {
            return response()->json(['message' => 'Unable to process request'], 400);
        }

        $loan_application->update([
            'status' => LoanApplicationStatus::RELEASED,
            'release_date' => now()
        ]);

        event(new LoanReleased($loan_application));

        return response()->json([
            'message' => 'success',
            'data' => $loan_application
        ], 200);
    }
}
