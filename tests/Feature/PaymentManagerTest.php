<?php

namespace Tests\Feature;

use App\Managers\Payment\PaymentManager;
use App\Models\Subscription;
use App\Services\PaymentServices\AppStoreServerNotificationsService;
use Tests\CreatesApplication;
use Tests\TestCase;

class PaymentManagerTest extends TestCase
{
    public function test_can_use_appstore_service()
    {
        $factory = new PaymentManager($this->app);
        $service = $factory->make(Subscription::PAYMENT_SERVICE_APPSTORE);
        $serviceClassName = get_class($service);

        $this->assertEquals(
            AppStoreServerNotificationsService::class,
            $serviceClassName
        );
    }
}
