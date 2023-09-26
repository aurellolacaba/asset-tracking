<?php

namespace App\Http\Requests\LoanApplication;

use App\Rules\MonthlyPaymentValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoanApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'lender_id' => [
                'required',
                'exists:users,id',
                'uuid'
            ],
            'loan_amount' => [
                'required',
                'numeric',
                'max:1000000',
                'min:1000'
            ],
            'terms' => [
                'required',
                'numeric',
                'max:64',
                'min:3'
            ],
            'term_unit' => [
                'required',
                'in:days,months,years'
            ],
            'monthly_payment' => [
                'required',
                'numeric',
                new MonthlyPaymentValidation
            ]
        ];
    }
}
