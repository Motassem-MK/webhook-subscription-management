<?php

namespace App\Dtos;

use App\Models\Transaction;

class StatusUpdateDTO {
    private string $transaction_type;

    public function __construct(
        private string $transaction_id,
        private string $provider,
        private string $operation,
        private string $status,
        private array $raw_transaction,
    )
    {
    }

    public function setTransactionAsNewPurchase()
    {
        $this->transaction_type = Transaction::TYPE_FIRST_PURCHASE;
    }

    public function setTransactionAsSuccessfulRenew()
    {
        $this->transaction_type = Transaction::TYPE_RENEWAL_SUCCESS;
    }

    public function setTransactionAsFailedRenew()
    {
        $this->transaction_type = Transaction::TYPE_RENEWAL_FAIL;
    }

    public function setTransactionAsCancellation()
    {
        $this->transaction_type = Transaction::TYPE_CANCELLATION;
    }

    public function getOriginalTransactionId(): string
    {
        return $this->transaction_id;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function getTransactionType(): string
    {
        return $this->transaction_type;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getRawTransaction(): array
    {
        return $this->raw_transaction;
    }


}
