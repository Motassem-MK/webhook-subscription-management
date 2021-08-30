<?php

namespace App\Jobs;

use App\Services\PaymentServices\PaymentServiceInterface;
use App\Services\SubscriptionServices\SubscriptionServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSubscriptionUpdateMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected array $args,
    )
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        PaymentServiceInterface $payment_service,
        SubscriptionServiceInterface $subscription_service,
    )
    {
        // TODO Get a status_update_dto from payment service
        // TODO Call subscription service to handle it.
    }
}
