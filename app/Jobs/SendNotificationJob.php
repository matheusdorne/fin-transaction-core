<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public Transaction $transaction) {}

    /**
     * Execute the job.
     */
    public function handle(NotificationService $notifier): void
    {
        $notifier->notify($this->transaction);
    }
}
