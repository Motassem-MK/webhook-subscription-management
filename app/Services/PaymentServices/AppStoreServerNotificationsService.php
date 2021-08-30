<?php

namespace App\Services\PaymentServices;

use App\Dtos\StatusUpdateDTO;
use App\Models\Subscription;

class AppStoreServerNotificationsService implements PaymentServiceInterface
{
    const TYPE_NEW_PURCHASE = 'INITIAL_BUY';
    const TYPE_SUCCESSFUL_RENEW = 'DID_RENEW';
    const TYPE_FAILED_RENEW = 'DID_FAIL_TO_RENEW';
    const TYPE_CANCELLATION = 'CANCEL';

    public function handleCallback(array $parameters): StatusUpdateDTO
    {
        $transaction_id = $parameters['original_transaction_id'];

        $status_update_dto = new StatusUpdateDTO(
            $transaction_id,
            Subscription::PAYMENT_SERVICE_APPSTORE,
            $this->detectOperation($parameters['notification_type']),
            $this->detectStatus($parameters['notification_type']),
            $parameters
        );

        $this->setTransactionType($parameters['notification_type'], $status_update_dto);

        return $status_update_dto;
    }

    private function setTransactionType($type, StatusUpdateDTO $status_update_dto): void
    {
        $type_setters = [
            self::TYPE_NEW_PURCHASE => 'setTransactionAsNewPurchase',
            self::TYPE_SUCCESSFUL_RENEW => 'setTransactionAsSuccessfulRenew',
            self::TYPE_FAILED_RENEW => 'setTransactionAsFailedRenew',
            self::TYPE_CANCELLATION => 'setTransactionAsCancellation',
        ];

        $status_update_dto->{$type_setters[$type]}();
    }

    private function detectStatus($type): string
    {
        // TODO process current status, grace period, other factors

        if (in_array($type, [self::TYPE_CANCELLATION, self::TYPE_FAILED_RENEW])) {
            return Subscription::STATUS_INACTIVE;
        }

        return Subscription::STATUS_ACTIVE;
    }

    private function detectOperation($type): string
    {
        // TODO process current status, grace period, other factors

        if ($type == self::TYPE_NEW_PURCHASE) {
            return 'create';
        }

        if ($type == self::TYPE_SUCCESSFUL_RENEW) {
            return 'update';
        }

        return 'cancel';
    }
}
