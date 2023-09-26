<?php

namespace App\Http\Controllers;

use App\Data\StoreLoanApplicationData;
use App\Http\Requests\LoanApplication\StoreLoanApplicationRequest;
use App\Models\LoanApplication;
use App\Events\LoanApplicationCreated;
use App\Events\LoanRequestApproved;
use App\Enums\LoanApplicationStatus;
use App\Services\LoanApplicationService;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LoanApplicationController extends Controller
{

    public function __construct(
        private LoanApplicationService $loanApplicationService
    ){}

    public function store(StoreLoanApplicationRequest $request)
    {
        $loanApplicationData = StoreLoanApplicationData::fromRequest($request);
        $loan_application = $this->loanApplicationService->store($loanApplicationData);

        event(new LoanApplicationCreated($loan_application));

        return Response::jsonSuccess($loan_application, Response::HTTP_CREATED);
    }

    public function handleApproveLoanRequest(LoanApplication $loan_application){
        $this->onlyLender($loan_application->lender);

        if ($loan_application->approved_by_lender) {
            return response()->json(['message' => 'Unable to process request'], 400);
        }

        $loan_application->update([
            'approved_by_lender' => true,
            'status' => LoanApplicationStatus::APPROVED
        ]);

        event(new LoanRequestApproved($loan_application));

        return response()->json([
            'message' => 'success',
            'data' => $loan_application
        ]);
    }

    // private function onlyLender($auth_user) {
    //     if (auth()->user()->isNot($auth_user)) {
    //         throw new \App\Exceptions\AccessForbiddenException('bar');
    //     }
    // }
}
