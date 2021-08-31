<?php

namespace App\Dtos;

class StatusUpdateDTO
{
    public function __construct(
        private string $transactionId,
        private string $provider,
        private string $transactionType,
        private array $rawTransaction,
    ) {
    }

    public function getOriginalTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getRawTransaction(): array
    {
        return $this->rawTransaction;
    }
}
