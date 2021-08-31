<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionNotFound extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = 'Requested subscription was not found';
}
