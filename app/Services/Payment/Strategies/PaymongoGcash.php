<?php

namespace App\Services\Payment\Strategies;

use App\Services\Payment\Interfaces\PaymentMethod;
use Illuminate\Support\Facades\Http;

class PaymongoGcash implements PaymentMethod {
    public function pay(array $args){

        $amount = $args['amount'] * 100;
        $billers_name = $args['billing']['name'];
        $billers_email = $args['billing']['email'];
        $reference_id = $args['metadata']['reference_id'];

        $body_params = [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'type' => 'gcash',
                    'currency' => 'PHP',
                    'redirect' => [
                        'success' => 'http://localhost:8000/gcash/success',
                        'failed' => 'http://localhost:8000/gcash/failed'
                    ],
                    'billing' => [
                        'name' => $billers_name,
                        'email' => $billers_email
                    ],
                    'metadata' => [
                        'reference_id' => $reference_id
                    ]
                ]
            ]
        ];
        
        $response = Http::withBasicAuth(config('services.paymongo.public_key'), '')
            ->timeout(30)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->withBody(json_encode($body_params), 'application/json')
            ->post('https://api.paymongo.com/v1/sources');

        return $response['data']['attributes']['redirect']['checkout_url'];
    }
}