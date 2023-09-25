<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanApplication>
 */
class LoanApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        return [
            'loan_amount' => '3000',
            'terms' => '3',
            'term_unit' => 'months',
            'monthly_payment' => '1000',
            'lender_id' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}
