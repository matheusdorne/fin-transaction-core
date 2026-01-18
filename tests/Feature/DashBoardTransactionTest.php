<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashBoardTransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_dashboard_display_transaction_history(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $myWallet = Wallet::factory()->create(['user_id' => $user->id]);
        $otherWallet = Wallet::factory()->create(['user_id' => $otherUser->id]);

        $t1 = Transaction::factory()->create([
            'sender_wallet_id' => $myWallet->id,
            'receiver_wallet_id' => $otherWallet->id,
            'amount' => 100,
        ]);

        $t2 = Transaction::factory()->create([
            'sender_wallet_id' => $otherWallet->id,
            'receiver_wallet_id' => $myWallet->id,
            'amount' => 50,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200)
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard')
                ->has('transctions', 2)
                ->where('transactions.0.amount', 50)
                ->where('transactions.1.amount', 100)
            );
    }
}
