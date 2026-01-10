<?php

namespace Tests\Feature;

use App\Enums\TransactionStatus;
use App\Models\User;
use App\Models\Wallet;
use App\Services\TransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TransferServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_transfer_money()
    {
        Http::fake([
            'https://util.devi.tools/*' => Http::response([
                'data' => ['authorization' => true],
            ], 200),
        ]);

        $sender = User::factory()->create();
        $payerWallet = Wallet::factory()->create([
            'user_id' => $sender->id,
            'balance' => 100.00,
        ]);

        $receiver = User::factory()->create();
        $payeeWallet = Wallet::factory()->create([
            'user_id' => $receiver->id,
            'balance' => 0.00,
        ]);

        $service = app(TransferService::class);
        $transaction = $service->transfer($sender->id, $receiver->id, 50.00);

        $this->assertEquals(50.00, $payerWallet->fresh()->balance);
        $this->assertEquals(50.00, $payeeWallet->fresh()->balance);

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'sender_wallet_id' => $payerWallet->id,
            'receiver_wallet_id' => $payeeWallet->id,
            'amount' => 50.00,
            'status' => TransactionStatus::COMPLETED->value,
        ]);
    }
}
