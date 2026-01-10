<?php

namespace App\Services;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;

class TransferService
{
    protected AuthorizationService $authorizer;

    public function __construct(AuthorizationService $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    public function transfer(int $senderId, int $receiverId, float $amount): Transaction
    {

        return DB::transaction(function () use ($senderId, $receiverId, $amount) {

            $senderWallet = Wallet::where('user_id', $senderId)->lockForUpdate()->firstOrFail();
            $receiverWallet = Wallet::where('user_id', $receiverId)->lockForUpdate()->firstOrFail();

            if ($senderWallet->balance < $amount) {
                throw new Exception('Insufficient balance.');
            }

            if (! $this->authorizer->authorize()) {
                throw new Exception('Transaction unauthorized.');
            }

            $senderWallet->decrement('balance', $amount);
            $receiverWallet->increment('balance', $amount);

            return Transaction::create([
                'sender_wallet_id' => $senderWallet->id,
                'receiver_wallet_id' => $receiverWallet->id,
                'amount' => $amount,
                'status' => TransactionStatus::COMPLETED,
            ]);
        });
    }
}
