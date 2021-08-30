<?php

namespace Tests\Unit;

use App\Managers\Payment\PaymentManager;
use App\Models\Subscription;
use App\Services\PaymentServices\AppStoreServerNotificationsService;
use PHPUnit\Framework\TestCase;

class PaymentManagerTest extends TestCase
{
    public function test_can_use_appstore_service()
    {
        $factory = new PaymentManager();
        $service = $factory->make(Subscription::PAYMENT_SERVICE_APPSTORE);
        $service_class_name = get_class($service);

        $this->assertEquals(
            AppStoreServerNotificationsService::class,
            $service_class_name
        );
    }
}
