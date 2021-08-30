<?php

namespace App\Managers\Payment;

use App\Services\PaymentServices\PaymentServiceInterface;

interface PaymentManagerInterface {
    public function make($provider_name): PaymentServiceInterface;
}
