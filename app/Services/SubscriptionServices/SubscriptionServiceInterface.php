<?php

namespace App\Services\SubscriptionServices;

use App\Dtos\StatusUpdateDTO;

interface SubscriptionServiceInterface {
    public function update(StatusUpdateDTO $status_update_dto): void;
}
