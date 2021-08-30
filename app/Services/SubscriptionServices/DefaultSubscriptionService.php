<?php

namespace App\Services\SubscriptionServices;

use App\Dtos\StatusUpdateDTO;

class DefaultSubscriptionService implements SubscriptionServiceInterface {

    public function update(StatusUpdateDTO $status_update_dto): void
    {
        // TODO update subscription status
        // TODO save transaction
    }
}
