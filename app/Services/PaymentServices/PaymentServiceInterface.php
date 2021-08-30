<?php

namespace App\Services\PaymentServices;

use App\Dtos\StatusUpdateDTO;

interface PaymentServiceInterface {
    public function handleCallback(array $parameters): StatusUpdateDTO;
}
