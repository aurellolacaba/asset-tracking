<?php  

namespace App\Services\Payment\Interfaces;

interface PaymentMethod {
    public function pay(array $args);
}