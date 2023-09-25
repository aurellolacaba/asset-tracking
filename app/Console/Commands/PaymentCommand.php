<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Payment\Payment;

class PaymentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment {paymentMethod}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns payment method';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payment = new Payment($this->argument('paymentMethod'));
        $payment->arguments([
            'amount' => 100,
            'billing' => [
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ],
            'metadata' => [
                'reference_id' => 'd9f80740-38f0-11e8-b467-0ed5f89f718b'
            ]
        ]);

        $this->info($payment->pay());

        return Command::SUCCESS;
    }
}
