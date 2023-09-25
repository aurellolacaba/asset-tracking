<?php

namespace App\Services\Payment\Strategies;

use App\Services\Payment\Interfaces\PaymentMethod;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class Paypal implements PaymentMethod {
    public function pay(array $args) {

        $order = Http::withToken($this->accessToken())
            ->withBody(json_encode($this->bodyParams($args)), 'application/json')
            ->post($this->baseUrl() . '/v2/checkout/orders');

        return $this->getApproveLink($order['links']);

    }

    private function accessToken(){
        $authorization = Http::withBasicAuth(
            config('services.paypal.client_id'),
            config('services.paypal.client_secret')
        )
        ->asForm()
        ->post($this->baseUrl() . '/v1/oauth2/token', [
            'grant_type' => 'client_credentials'
        ]);

        return $authorization['access_token'];
    }

    private function bodyParams($args){
        $amount = $args['amount'];
        $reference_id = $args['metadata']['reference_id'];

        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $reference_id,
                    'amount' => [
                        'currency_code' => 'PHP',
                        'value' => $amount
                    ]
                ]
            ],
            'application_context' => [
                'return_url' => config('app.url') . '/paypal/callback',
                'cancel_url' => config('app.url') . '/paypal/cancel'
            ]
        ];
    }

    private function getApproveLink($links) {
        $approve_link = '';

        foreach ($links as $key => $link) {
            if ($link['rel'] == 'approve') $approve_link = $link['href'];
        }

        return $approve_link;
    }

    private function baseUrl(){
        $environment_lookup = [
            'local' => 'https://api-m.sandbox.paypal.com',
            'production' => 'https://api-m.paypal.com'
        ];

        return $environment_lookup[config('app.env')];
    }
}