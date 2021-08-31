<?php

use App\Http\Controllers\Webhooks\SubscriptionUpdateController;
use App\Http\Middleware\AuthenticateSubscriptionNotifications;
use App\Models\Subscription;
use Illuminate\Support\Facades\Route;

Route::post('{provider}/subscription/notification', SubscriptionUpdateController::class)
    ->middleware(AuthenticateSubscriptionNotifications::class)
    ->where('provider', implode('|', Subscription::ALLOWED_PAYMENT_SERVICES));
