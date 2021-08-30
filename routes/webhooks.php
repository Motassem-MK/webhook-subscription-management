<?php

use App\Http\Controllers\Webhooks\SubscriptionUpdateController;
use Illuminate\Support\Facades\Route;

Route::post('{service}/subscription/notification', SubscriptionUpdateController::class);
