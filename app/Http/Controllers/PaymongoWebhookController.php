<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\LoanPayment;
use Carbon\Carbon;

class PaymongoWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $payload = $request->data;
        $type = $payload['attributes']['type'];
        $source = $payload['attributes']['data'];

        if ($type == 'source.chargeable') {
            $amount = $source['attributes']['amount'];
            $source_id = $source['id'];
            $description = "GCash Payment";
            $body_params = [
                'data' => [
                    'attributes' => [
                        'amount' => $amount,
                        'source' => [
                            'id' => $source_id,
                            'type' => 'source'
                        ],
                        'currency' => 'PHP',
                        'description' => $description
                    ]
                ]
            ];

            $response = Http::withBasicAuth(config('services.paymongo.private_key'), '')
                ->timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->withBody(json_encode($body_params), 'application/json')
                ->post('https://api.paymongo.com/v1/payments');

            Log::info($response);

        }

        if ($type == 'payment.paid') {

            $payment = LoanPayment::create([
                'loan_amortization_schedule_id' => $source['attributes']['metadata']['reference_id'],
                'status' => $source['attributes']['status'],
                'amount_paid' => $source['attributes']['amount'] / 100,
                'paid_at' => Carbon::createFromTimestamp($source['attributes']['paid_at'])->toDateTimeString(),
                'payment_method' => $source['attributes']['source']['type'],
                'service_payment_id' => $source['id']
            ]);

            $payment->schedule->update([
                'status' => $source['attributes']['status']
            ]);

        }

    }
}
