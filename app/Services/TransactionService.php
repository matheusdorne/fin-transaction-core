<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;

class TransactionService
{
    public function getWalletHistory(Wallet $wallet, int $limit = 10)
    {
        return Transaction::with(['sender.user', 'receiver.user'])
            ->where(function ($query) use ($wallet) {
                $query->where('sender_wallet_id', $wallet->id)
                    ->orWhere('receiver_wallet_id', $wallet->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
