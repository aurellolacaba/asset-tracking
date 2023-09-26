<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\LoanApplicationStatus;
use Exception;

class LoanApplication extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'lender_id',
        'barrower_id',
        'loan_amount',
        'terms',
        'term_unit',
        'monthly_payment',
        'status',
        'release_date',
        'approved_by_lender',
        'approved_by_barrower',
        'created_by',
    ];

    protected $casts = [
        'approved_by_lender' => 'boolean',
        'approved_by_barrower' => 'boolean',
        'release_date' => 'date',
        'status' => LoanApplicationStatus::class
    ];

    public function lender() {
        return $this->hasOne(User::class, 'id', 'lender_id');
    }

    public function barrower() {
        return $this->hasOne(User::class, 'id', 'barrower_id');
    }

    public function approveByLender()
    {
        if (auth()->user()->isNot($this->lender)) {
            throw new \App\Exceptions\AccessForbiddenException();
        }

        if ($this->approved_by_lender) {
            throw new Exception('Unable to process request', 400);
        }

        return $this->update([
            'approved_by_lender' => true,
            'status' => LoanApplicationStatus::APPROVED
        ]);
    }
}
