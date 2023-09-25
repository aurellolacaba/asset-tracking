<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPayment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'loan_amortization_schedule_id',
        'status',
        'amount_paid',
        'paid_at',
        'payment_method',
        'service_payment_id',
    ];

    public function schedule() {
        return $this->hasOne(LoanAmortizationSchedule::class, 'id', 'loan_amortization_schedule_id');
    }
}
