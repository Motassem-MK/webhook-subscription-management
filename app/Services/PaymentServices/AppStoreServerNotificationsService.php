<?php

namespace App\Services\PaymentServices;

use App\Dtos\StatusUpdateDTO;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Symfony\Component\HttpFoundation\Response;

class AppStoreServerNotificationsService implements PaymentServiceInterface
{
    const TYPE_NEW_PURCHASE = 'INITIAL_BUY';
    const TYPE_SUCCESSFUL_RENEW = 'DID_RENEW';
    const TYPE_FAILED_RENEW = 'DID_FAIL_TO_RENEW';
    const TYPE_CANCELLATION = 'CANCEL';

    const TYPES_MAP = [
        self::TYPE_NEW_PURCHASE => Transaction::TYPE_FIRST_PURCHASE,
        self::TYPE_SUCCESSFUL_RENEW => Transaction::TYPE_RENEWAL_SUCCESS,
        self::TYPE_FAILED_RENEW => Transaction::TYPE_RENEWAL_FAIL,
        self::TYPE_CANCELLATION => Transaction::TYPE_CANCELLATION,
    ];

    public function __construct(private array $config)
    {
    }

    public function handleCallback(array $parameters): StatusUpdateDTO
    {
        $transaction_id = $parameters['original_transaction_id'];

        return new StatusUpdateDTO(
            $transaction_id,
            Subscription::PAYMENT_SERVICE_APPSTORE,
            self::TYPES_MAP[$parameters['notification_type']],
            $parameters
        );
    }

    public function authenticate(Request $request): bool
    {
        $providedPassword = $request->get('password');
        $correctPassword = $this->config['webhook-password'];

        if ($providedPassword === $correctPassword) {
            return true;
        }

        return false;
    }

    public function respond(): IlluminateResponse
    {
        return response('', Response::HTTP_OK);
    }
}
