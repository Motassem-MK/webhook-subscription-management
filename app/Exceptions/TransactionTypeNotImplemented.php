<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class TransactionTypeNotImplemented extends Exception
{
    protected $code = Response::HTTP_NOT_IMPLEMENTED;

    protected $message = 'Transaction code is not implemented';
}
