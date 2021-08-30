<?php

namespace App\Services\SubscriptionServices;

use App\Dtos\StatusUpdateDTO;
use App\Models\Transaction;

class BaseSubscriptionService
{
    protected function insertTransactionRecord(StatusUpdateDTO $statusUpdateDTO, int $subscription_id): void
    {
        Transaction::create([
            'type' => $statusUpdateDTO->getTransactionType(),
            'raw_data' => $statusUpdateDTO->getRawTransaction(),
            'subscription_id' => $subscription_id,
        ]);
    }
}
