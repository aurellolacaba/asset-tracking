<?php

namespace App\Data;

use App\Enums\LoanApplicationStatus;
use App\Http\Requests\LoanApplication\StoreLoanApplicationRequest;
use ReflectionClass;
use ReflectionProperty;

class StoreLoanApplicationData
{
    public function __construct(
        public $lender_id,
        public $barrower_id,
        public $loan_amount,
        public $terms,
        public $term_unit,
        public $monthly_payment,
        public $status,
        public $approved_by_lender,
        public $approved_by_barrower,
        public $created_by
    )
    {
        
    }

    public static function fromRequest(StoreLoanApplicationRequest $request): self
    {
        return new self(
            lender_id: $request->lender_id,
            barrower_id: auth()->id(),
            loan_amount: $request->loan_amount,
            terms: $request->terms,
            term_unit: $request->term_unit,
            monthly_payment: $request->monthly_payment,
            status: LoanApplicationStatus::PENDING,
            approved_by_lender: false,
            approved_by_barrower: true,
            created_by: auth()->id(),
        );
    }

    public function toArray(): array
    {
        $properties = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $propertyName = $property->getName();
            $properties[$propertyName] = $this->$propertyName;
        }

        return $properties;
    }
}