<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\LoanApplicationCreated;
use App\Listeners\SendEmailNotificationToLender;
use App\Events\LoanRequestApproved;
use App\Listeners\SendEmailNotificationToBarrower;
use App\Events\LoanReleased;
use App\Listeners\CreateAmortizationSchedule;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LoanApplicationCreated::class => [
            SendEmailNotificationToLender::class,
        ],
        LoanRequestApproved::class => [
            SendEmailNotificationToBarrower::class,
        ],
        LoanReleased::class => [
            CreateAmortizationSchedule::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
