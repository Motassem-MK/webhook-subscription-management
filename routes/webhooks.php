<?php

use App\Http\Controllers\Webhooks\SubscriptionUpdateController;
use Illuminate\Support\Facades\Route;

Route::post('{service}/status-update', SubscriptionUpdateController::class);
