<?php

namespace App\Providers;

use App\Managers\Payment\PaymentManager;
use App\Managers\Payment\PaymentManagerInterface;
use App\Services\SubscriptionServices\DefaultSubscriptionService;
use App\Services\SubscriptionServices\SubscriptionServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentManagerInterface::class, function ($app) {
            return new PaymentManager($app);
        });

        $this->app->bind(SubscriptionServiceInterface::class, function($app) {
            return new DefaultSubscriptionService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
