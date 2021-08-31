<?php

namespace App\Jobs;

use App\Managers\Payment\PaymentManagerInterface;
use App\Services\SubscriptionServices\SubscriptionServiceAbstract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessSubscriptionUpdateMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected array $parameters,
        protected string $provider
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(PaymentManagerInterface $paymentManager, SubscriptionServiceAbstract $subscriptionService)
    {
        $payment_service = $paymentManager->make($this->provider);
        $statusUpdateDto = $payment_service->handleCallback($this->parameters);

        DB::beginTransaction();
        try {
            $subscriptionService->handleNotification($statusUpdateDto);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
