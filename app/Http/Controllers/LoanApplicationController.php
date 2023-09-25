<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoanApplication\StoreLoanApplicationRequest;
use App\Models\LoanApplication;
use App\Events\LoanApplicationCreated;
use App\Events\LoanRequestApproved;
use App\Enums\LoanApplicationStatus;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Response as HttpResponse;

class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanApplicationRequest $request)
    {
        $monthly_payment = $request->loan_amount / $request->terms;
        
        abort_if($monthly_payment != $request->monthly_payment, 400, "Invalid monthly payment");

        $loan_application = LoanApplication::create([
            "lender_id" => $request->lender_id,
            "barrower_id" => auth()->id(),
            "loan_amount" => $request->loan_amount,
            "terms" => $request->terms,
            "term_unit" => $request->term_unit,
            "monthly_payment" => $request->monthly_payment,
            "status" => LoanApplicationStatus::PENDING,
            "approved_by_lender" => false,
            "approved_by_barrower" => true,
            "created_by" => auth()->id(),
        ]);

        event(new LoanApplicationCreated($loan_application));

        return response()->json([
            'message' => 'success',
            'data' => $loan_application
        ], HttpResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

    private function onlyLender($auth_user) {
        if (auth()->user()->isNot($auth_user)) {
            throw new \App\Exceptions\AccessForbiddenException('bar');
        }
    }
}
