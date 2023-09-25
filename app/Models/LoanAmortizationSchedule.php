<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\LoanApplicationStatus;
use App\Models\LoanApplication;

class LoanAmortizationSchedule extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'loan_application_id',
        'date_of_payment',
        'beginning_balance',
        'scheduled_payment',
        'balance',
        'status',
    ];

    public function loan() {
        return $this->hasOne(LoanApplication::class, 'id', 'loan_application_id');
    }
}
