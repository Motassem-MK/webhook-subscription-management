<?php

namespace App\Services\PaymentServices;

use App\Dtos\StatusUpdateDTO;

class AppStoreServerNotificationsService implements PaymentServiceInterface
{

    public function handleCallback(array $parameters): StatusUpdateDTO
    {
        // TODO: Implement handleCallback() method.
        $status_update_dto = new StatusUpdateDTO(null, null, null, null);

        return $status_update_dto;
    }
}
