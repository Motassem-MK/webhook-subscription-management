<?php

namespace App\Managers\Payment;

use App\Models\Subscription;
use App\Services\PaymentServices\AppStoreServerNotificationsService;
use App\Services\PaymentServices\PaymentServiceInterface;
use Illuminate\Support\Arr;

class PaymentManager implements PaymentManagerInterface
{
    private $services = [];

    private $handlers = [
        Subscription::PAYMENT_SERVICE_APPSTORE => 'createAppStoreServerNotificationsService',
    ];

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @throws \Exception
     */
    public function make($providerName): PaymentServiceInterface
    {
        $service = Arr::get($this->services, $providerName);

        if ($service) {
            return $service;
        }

        $createMethod = $this->handlers[$providerName];
        if (!method_exists($this, $createMethod)) {
            throw new \Exception("Provider $providerName is not supported.");
        }

        $service = $this->{$createMethod}();
        $this->services[$providerName] = $service;

        return $service;
    }

    private function createAppStoreServerNotificationsService(): AppStoreServerNotificationsService
    {
        $serviceConfig = $this->app['config']['services.apple.subscription-notification'];
        $service = new AppStoreServerNotificationsService($serviceConfig);

        return $service;
    }
}
