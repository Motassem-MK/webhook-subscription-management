<?php

namespace App\Http\Middleware;

use App\Managers\Payment\PaymentManagerInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateSubscriptionNotifications
{
    public function __construct(private PaymentManagerInterface $paymentManager)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $provider = $request->route('provider');

        $paymentService = $this->paymentManager->make($provider);

        if (!$paymentService->authenticate($request)) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
