<?php

namespace App\Jobs;

use App\Managers\Payment\PaymentManagerInterface;
use App\Services\SubscriptionServices\SubscriptionServiceInterface;
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
        protected array  $parameters,
        protected string $provider
    )
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(PaymentManagerInterface $payment_manager, SubscriptionServiceInterface $subscription_service)
    {
        $payment_service = $payment_manager->make($this->provider);
        $status_update_dto = $payment_service->handleCallback($this->parameters);
        $operation = $status_update_dto->getOperation();

        DB::beginTransaction();
        try {
            $subscription_service->{$operation}($status_update_dto);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
