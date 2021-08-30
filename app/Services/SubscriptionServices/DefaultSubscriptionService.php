<?php

namespace App\Services\SubscriptionServices;

use App\Dtos\StatusUpdateDTO;
use App\Models\Subscription;

class DefaultSubscriptionService extends BaseSubscriptionService implements SubscriptionServiceInterface {
    public function create(StatusUpdateDTO $status_update_dto): void
    {
        $subscription = Subscription::create([
            'service' => $status_update_dto->getProvider(),
            'status' => $status_update_dto->getStatus(),
            'started_at' => $this->calculateStartsAt($status_update_dto),
            'expires_at' => $this->calculateExpiresAt($status_update_dto),
            'original_transaction_id' => $status_update_dto->getOriginalTransactionId(),
            'user_id' => 1 // TODO implement the logic of getting the user.
        ]);

        parent::insertTransactionRecord($status_update_dto, $subscription->id);
    }

    public function update(StatusUpdateDTO $status_update_dto): void
    {
        $subscription = Subscription::where(
            'original_transaction_id',
            $status_update_dto->getOriginalTransactionId()
        )->first();

        $subscription->update([
            'status' => $status_update_dto->getStatus(),
            'started_at' => $this->calculateStartsAt($status_update_dto, $subscription),
            'expires_at' => $this->calculateExpiresAt($status_update_dto, $subscription),
        ]);

        parent::insertTransactionRecord($status_update_dto, $subscription->id);
    }

    public function cancel(StatusUpdateDTO $status_update_dto): void
    {
        $subscription = Subscription::where(
            'original_transaction_id',
            $status_update_dto->getOriginalTransactionId()
        )->first();

        $subscription->update([
            'status' => $status_update_dto->getStatus(),
            'started_at' => $this->calculateStartsAt($status_update_dto, $subscription),
            'expires_at' => $this->calculateExpiresAt($status_update_dto, $subscription),
        ]);

        parent::insertTransactionRecord($status_update_dto, $subscription->id);
    }

    private function calculateStartsAt(StatusUpdateDTO $status_update_dto, Subscription $subscription = null): string
    {
        // TODO implement
        return 'NNN';
    }

    private function calculateExpiresAt(StatusUpdateDTO $status_update_dto, Subscription $subscription = null): string
    {
        // TODO implement
        return 'NNN';
    }
}
