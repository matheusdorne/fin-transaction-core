<?php

namespace Database\Factories;

use App\Enums\TransactionStatus;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_wallet_id' => Wallet::factory(),

            'receiver_wallet_id' => Wallet::factory(),

            'amount' => $this->faker->randomFloat(2, 1, 1000),

            'status' => TransactionStatus::COMPLETED,
        ];
    }
}
