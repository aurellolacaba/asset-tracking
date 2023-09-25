<?php

namespace App\Enums;

enum LoanApplicationStatus: string {
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case RELEASING = 'releasing';
    case RELEASED = 'released';
}