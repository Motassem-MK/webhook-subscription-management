<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startedAt = $this->faker->dateTimeThisYear;
        $expiresAt = $startedAt->add(new \DateInterval('P1Y'));

        return [
            'service' => Subscription::PAYMENT_SERVICE_APPSTORE,
            'status' => Subscription::STATUS_ACTIVE,
            'started_at' => $startedAt,
            'expires_at' => $expiresAt,
            'user_id' => User::factory(),
            'original_transaction_id' => $this->faker->randomNumber(4),
        ];
    }
}
