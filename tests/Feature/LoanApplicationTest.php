<?php

namespace Tests\Feature;

use App\Enums\LoanApplicationStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\LoanApplication;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoanApplicationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_loan_request_requires_a_lender_id()
    {
        $barrower = User::factory()->create();
        $attributes = LoanApplication::factory()->raw(['lender_id' => NULL]);

        $this->actingAs($barrower)
            ->postJson('/api/v1/loan-applications', $attributes)
            ->assertStatus(422)
            ->assertInvalid([
                'lender_id' => 'The lender id field is required.'
            ]);
    }

    public function test_lender_id_must_be_a_valid_user_uuid()
    {
        $barrower = User::factory()->create();
        $invalid_lender_id = fake()->uuid();
        $attributes = LoanApplication::factory()->raw(['lender_id' => $invalid_lender_id]);

        $this->actingAs($barrower)
            ->postJson('/api/v1/loan-applications', $attributes)
            ->assertStatus(422)
            ->assertInvalid([
                'lender_id' => 'The selected lender id is invalid.'
            ]);
    }

    public function test_monthly_payment_should_be_valid()
    {
        $barrower = User::factory()->create();
        $attributes = LoanApplication::factory()->raw(['monthly_payment' => '3000']);

        $this->actingAs($barrower)
            ->postJson('/api/v1/loan-applications', $attributes)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertInvalid([
                'monthly_payment' => 'Invalid monthly payment.'
            ]);
    }

    public function test_barrower_can_apply_for_loan()
    {
        $barrower = User::factory()->create();
        $loan_application = LoanApplication::factory()->raw([
            'barrower_id' => $barrower->id,
            'created_by' => $barrower->id
        ]);

        $this->actingAs($barrower)
            ->post('/api/v1/loan-applications', $loan_application)
            ->assertStatus(201);
        
        $this->assertDatabaseHas('loan_applications', $loan_application);
    }

    /** @test */
    public function lender_should_be_able_to_approve_loans()
    {
        $lender = User::factory()->create();
        $loan_application = LoanApplication::factory()->create([
            'lender_id' => $lender->id
        ]);

        $this->actingAs($lender)
            ->patchJson("/api/v1/loan-applications/{$loan_application->id}/approve")
            ->assertStatus(200);

        $this->assertEquals(LoanApplicationStatus::APPROVED, $loan_application->fresh()->status);
    } 
}
