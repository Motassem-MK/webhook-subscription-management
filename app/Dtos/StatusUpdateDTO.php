<?php

namespace App\Dtos;

class StatusUpdateDTO {
    public function __construct(
        private string $status,
        private string $starts_at,
        private string $expires_at,
        private string $raw_transaction,
    )
    {
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStartsAt(): string
    {
        return $this->starts_at;
    }

    public function getExpiresAt(): string
    {
        return $this->expires_at;
    }

    public function getRawTransaction(): string
    {
        return $this->raw_transaction;
    }


}
