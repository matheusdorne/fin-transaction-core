<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasUlids;

    protected $fillable = [
        'sender_wallet_id',
        'receiver_wallet_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
        'amount' => 'decimal:4',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'sender_wallet_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'receiver_wallet_id');
    }
}
