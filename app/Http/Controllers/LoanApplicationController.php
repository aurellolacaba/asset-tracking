<?php

namespace App\Http\Controllers;

use App\Data\StoreLoanApplicationData;
use App\Http\Requests\LoanApplication\StoreLoanApplicationRequest;
use App\Events\LoanApplicationCreated;
use App\Services\LoanApplicationService;
use Illuminate\Http\Response;

class LoanApplicationController extends Controller
{

    public function __construct(
        private LoanApplicationService $loanApplicationService
    ){}

    public function index(){
        $user = auth()->user();
        $loan_application = $user->loans()->with('barrower', 'lender')->simplePaginate();

        return Response::jsonSuccess($loan_application);
    }

    public function store(StoreLoanApplicationRequest $request)
    {
        $loanApplicationData = StoreLoanApplicationData::fromRequest($request);
        $loan_application = $this->loanApplicationService->store($loanApplicationData);

        event(new LoanApplicationCreated($loan_application));

        return Response::jsonSuccess($loan_application, Response::HTTP_CREATED);
    }
}
