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

    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @throws \Exception
     */
    public function make($provider_name): PaymentServiceInterface
    {
        $service = Arr::get($this->services, $provider_name);

        if ($service) {
            return $service;
        }

        $createMethod = $this->handlers[$provider_name];
        if (!method_exists($this, $createMethod)) {
            throw new \Exception("Provider $provider_name is not supported.");
        }

        $service = $this->{$createMethod}();
        $this->services[$provider_name] = $service;

        return $service;
    }

    private function createAppStoreServerNotificationsService(): AppStoreServerNotificationsService
    {
        $service = new AppStoreServerNotificationsService();

        return $service;
    }
}
