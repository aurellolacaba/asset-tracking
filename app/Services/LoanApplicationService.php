<?php 

namespace App\Services;

use App\Data\StoreLoanApplicationData;
use App\Models\LoanApplication;

class LoanApplicationService
{
    public function store(StoreLoanApplicationData $data)
    {
        return LoanApplication::create($data->toArray());
    }
}