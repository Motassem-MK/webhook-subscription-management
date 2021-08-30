<?php

namespace App\Services\SubscriptionServices;

use App\Dtos\StatusUpdateDTO;

interface SubscriptionServiceInterface {
    public function create(StatusUpdateDTO $status_update_dto): void;

    public function update(StatusUpdateDTO $status_update_dto): void;

    public function cancel(StatusUpdateDTO $status_update_dto): void;
}
