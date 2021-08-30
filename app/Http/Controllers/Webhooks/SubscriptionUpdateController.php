<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessSubscriptionUpdateMessage;
use App\Managers\Payment\PaymentManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SubscriptionUpdateController extends Controller
{
    public function __invoke(Request $request, string $provider): Response
    {
        ProcessSubscriptionUpdateMessage::dispatch($request->all(), $provider);

        return response()
            ->setStatusCode(200)
            ->send();
    }
}
