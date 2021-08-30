<?php

namespace Tests\Feature;

use App\Jobs\ProcessSubscriptionUpdateMessage;
use App\Services\PaymentServices\AppStoreServerNotificationsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AppStoreSubscriptionUpdateTest extends TestCase
{
    use RefreshDatabase;

    private string $endpoint = '/webhooks/apple/subscription/notification';
    private string $subscriptions_table_name = 'subscriptions';
    private string $transactions_table_name = 'transactions';

    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake();
    }

    public function test_new_purchase()
    {
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_NEW_PURCHASE,
            'latest_receipt' => 'NNN',
            'original_transaction_id' => 'NNN',
            'password' => 'NNN',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        Queue::assertPushed(ProcessSubscriptionUpdateMessage::class);
    }

    public function test_successful_renewal()
    {
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_SUCCESSFUL_RENEW,
            'latest_receipt' => 'NNN',
            'original_transaction_id' => 'NNN',
            'password' => 'NNN',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        Queue::assertPushed(ProcessSubscriptionUpdateMessage::class);
    }

    public function test_unsuccessful_renewal()
    {
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_FAILED_RENEW,
            'latest_receipt' => 'NNN',
            'original_transaction_id' => 'NNN',
            'password' => 'NNN',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        Queue::assertPushed(ProcessSubscriptionUpdateMessage::class);
    }

    public function test_cancel_subscription()
    {
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_CANCELLATION,
            'latest_receipt' => 'NNN',
            'original_transaction_id' => 'NNN',
            'password' => 'NNN',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        Queue::assertPushed(ProcessSubscriptionUpdateMessage::class);
    }
}
