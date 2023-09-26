<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MonthlyPaymentValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $monthly_payment = request()->input('loan_amount') / request()->input('terms');
        
        return $monthly_payment == $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid monthly payment.';
    }
}
