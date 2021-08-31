<?php

namespace App\Services\SubscriptionServices;

use App\Dtos\StatusUpdateDTO;
use App\Exceptions\SubscriptionNotFound;
use App\Exceptions\TransactionTypeNotImplemented;
use App\Models\Subscription;
use App\Models\Transaction;

class DefaultSubscriptionService extends SubscriptionServiceAbstract
{
    private StatusUpdateDTO $statusUpdateDTO;

    /**
     * @throws \Exception
     */
    public function handleNotification(StatusUpdateDTO $statusUpdateDTO): Subscription
    {
        $this->statusUpdateDTO = $statusUpdateDTO;

        $isFirstPurchase = $this->statusUpdateDTO->getTransactionType() === Transaction::TYPE_FIRST_PURCHASE;
        if ($isFirstPurchase) {
            return $this->create();
        }

        $isUpdate = $this->statusUpdateDTO->getTransactionType() === Transaction::TYPE_RENEWAL_SUCCESS;
        if ($isUpdate) {
            return $this->update();
        }

        $isCancellation = in_array($this->statusUpdateDTO->getTransactionType(), [
            Transaction::TYPE_CANCELLATION,
            Transaction::TYPE_RENEWAL_FAIL
        ]);
        if ($isCancellation) {
            return $this->cancel();
        }

        throw new TransactionTypeNotImplemented();
    }

    public function create(): Subscription
    {
        $subscription = Subscription::create([
            'service' => $this->statusUpdateDTO->getProvider(),
            'status' => Subscription::STATUS_ACTIVE,
            'started_at' => $this->calculateStartsAt(),
            'expires_at' => $this->calculateExpiresAt(),
            'original_transaction_id' => $this->statusUpdateDTO->getOriginalTransactionId(),
            'user_id' => 1 // TODO implement the logic of getting the user.
        ]);

        $this->insertTransactionRecord($this->statusUpdateDTO, $subscription->id);

        return $subscription;
    }

    /**
     * @throws SubscriptionNotFound
     */
    public function update(): Subscription
    {
        $subscription = Subscription::where(
            'original_transaction_id',
            $this->statusUpdateDTO->getOriginalTransactionId()
        )->first();

        if (!$subscription) {
            throw new SubscriptionNotFound();
        }

        $subscription->update([
            'status' => Subscription::STATUS_ACTIVE,
            'expires_at' => $this->calculateExpiresAt($subscription),
        ]);

        $this->insertTransactionRecord($this->statusUpdateDTO, $subscription->id);

        return $subscription;
    }

    /**
     * @throws SubscriptionNotFound
     */
    public function cancel(): Subscription
    {
        $subscription = Subscription::where(
            'original_transaction_id',
            $this->statusUpdateDTO->getOriginalTransactionId()
        )->first();

        if (!$subscription) {
            throw new SubscriptionNotFound();
        }

        $subscription->update([
            'status' => Subscription::STATUS_INACTIVE,
        ]);

        $this->insertTransactionRecord($this->statusUpdateDTO, $subscription->id);

        return $subscription;
    }

    private function calculateStartsAt(Subscription $subscription = null): string
    {
        // I assume that all new/renewed transactions will start the new period immediately, correct this if not.
        return now();
    }

    private function calculateExpiresAt(Subscription $subscription = null): string
    {
        // TODO implement serious logic
        return now()->addYear();
    }
}
