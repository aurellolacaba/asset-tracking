<?php

namespace Tests\Unit;

use App\Enums\LoanApplicationStatus;
use App\Models\LoanApplication;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoanTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_loan_should_be_approvable()
    {
        $lender = User::factory()->create();
        $loan_application = LoanApplication::factory()->create([
            'lender_id' => $lender->id
        ]);

        Auth::login($lender);

        $loan_application->approveByLender();

        $this->assertEquals(LoanApplicationStatus::APPROVED, $loan_application->fresh()->status);
    }
}
