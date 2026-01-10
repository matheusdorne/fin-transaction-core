<?php

namespace App\Services;

use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    private const URL = 'https://util.devi.tools/api/v1/notify';

    public function notify(Transaction $transaction): void
    {
        $response = Http::timeout(2)->post(self::URL, [
            'transaction_id' => $transaction->id,
            'amount' => $transaction->amount,
        ]);

        if ($response->failed()) {
            throw new Exception('Notification service unavailable');
        }
    }
}
