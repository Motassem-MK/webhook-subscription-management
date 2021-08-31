<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\Transaction;
use App\Services\PaymentServices\AppStoreServerNotificationsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppStoreSubscriptionUpdateTest extends TestCase
{
    use RefreshDatabase;

    private string $endpoint = '/webhooks/apple/subscription/notification';
    private string $subscriptionsTableName = 'subscriptions';
    private string $transactionsTableName = 'transactions';

    public function test_should_refuse_unauthenticated_calls()
    {
        $payload = [
            'password' => 'wrong_password',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertUnauthorized();
    }

    public function test_should_refuse_calls_for_unsupported_services()
    {
        $payload = [
            'password' => 'P@ssw0rd',
        ];

        $response = $this->postJson('/webhooks/SpaceX/subscription/notification', $payload);

        $response->assertNotFound();
    }

    public function test_new_purchase()
    {
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_NEW_PURCHASE,
            'original_transaction_id' => 'NNN',
            'password' => 'P@ssw0rd',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        $this->assertDatabaseCount($this->subscriptionsTableName, 1);
        $this->assertDatabaseHas($this->subscriptionsTableName, [
            'original_transaction_id' => $payload['original_transaction_id']
        ]);
        $this->assertDatabaseCount($this->transactionsTableName, 1);
        $this->assertDatabaseHas($this->transactionsTableName, [
            'type' => Transaction::TYPE_FIRST_PURCHASE
        ]);
    }

    public function test_successful_renewal()
    {
        $subscription = Subscription::factory()
            ->create(['status' => Subscription::STATUS_INACTIVE])
            ->first();
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_SUCCESSFUL_RENEW,
            'original_transaction_id' => $subscription->original_transaction_id,
            'password' => 'P@ssw0rd',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        $this->assertDatabaseCount($this->subscriptionsTableName, 1);
        $this->assertDatabaseHas($this->subscriptionsTableName, [
            'status' => Subscription::STATUS_ACTIVE,
        ]);
        $this->assertDatabaseCount($this->transactionsTableName, 1);
        $this->assertDatabaseHas($this->transactionsTableName, [
            'type' => Transaction::TYPE_RENEWAL_SUCCESS,
        ]);
    }

    public function test_unsuccessful_renewal()
    {
        $subscription = Subscription::factory()->create()->first();
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_FAILED_RENEW,
            'original_transaction_id' => $subscription->original_transaction_id,
            'password' => 'P@ssw0rd',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        $this->assertDatabaseCount($this->subscriptionsTableName, 1);
        $this->assertDatabaseHas($this->subscriptionsTableName, [
            'status' => Subscription::STATUS_INACTIVE,
        ]);
        $this->assertDatabaseCount($this->transactionsTableName, 1);
        $this->assertDatabaseHas($this->transactionsTableName, [
            'type' => Transaction::TYPE_RENEWAL_FAIL,
        ]);
    }

    public function test_cancel_subscription()
    {
        $subscription = Subscription::factory()->create()->first();
        $payload = [
            'notification_type' => AppStoreServerNotificationsService::TYPE_CANCELLATION,
            'original_transaction_id' => $subscription->original_transaction_id,
            'password' => 'P@ssw0rd',
        ];

        $response = $this->postJson($this->endpoint, $payload);

        $response->assertOk();
        $this->assertDatabaseCount($this->subscriptionsTableName, 1);
        $this->assertDatabaseHas($this->subscriptionsTableName, [
            'status' => Subscription::STATUS_INACTIVE,
        ]);
        $this->assertDatabaseCount($this->transactionsTableName, 1);
        $this->assertDatabaseHas($this->transactionsTableName, [
            'type' => Transaction::TYPE_CANCELLATION,
        ]);
    }
}
