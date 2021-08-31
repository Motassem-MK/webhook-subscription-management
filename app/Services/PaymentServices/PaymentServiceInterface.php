<?php

namespace App\Services\PaymentServices;

use App\Dtos\StatusUpdateDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface PaymentServiceInterface
{
    public function __construct(array $config);

    public function handleCallback(array $parameters): StatusUpdateDTO;

    public function authenticate(Request $request): bool;

    public function respond(): Response;
}
