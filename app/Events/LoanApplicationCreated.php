<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\LoanApplication;

class LoanApplicationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loan_application;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LoanApplication $loan_application)
    {
        $this->loan_application = $loan_application;
    }
}
