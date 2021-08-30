<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Managers\Payment\PaymentManagerInterface;
use Illuminate\Http\Request;

class SubscriptionUpdateController extends Controller
{

    public function __invoke(Request $request, PaymentManagerInterface $payment_manager)
    {
        // TODO Get appropriate service through
        // TODO Dispatch a subscription update job
        // TODO Return success.
    }
}
