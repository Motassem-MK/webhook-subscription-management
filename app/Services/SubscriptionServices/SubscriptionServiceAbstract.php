<?php

namespace App\Services\SubscriptionServices;

use App\Dtos\StatusUpdateDTO;
use App\Models\Subscription;
use App\Models\Transaction;

abstract class SubscriptionServiceAbstract
{
    abstract public function handleNotification(StatusUpdateDTO $statusUpdateDTO): Subscription;

    abstract public function create(): Subscription;

    abstract public function update(): Subscription;

    abstract public function cancel(): Subscription;

    protected function insertTransactionRecord(StatusUpdateDTO $statusUpdateDTO, int $subscription_id): void
    {
        Transaction::create([
            'type' => $statusUpdateDTO->getTransactionType(),
            'raw_data' => $statusUpdateDTO->getRawTransaction(),
            'subscription_id' => $subscription_id,
        ]);
    }
}
