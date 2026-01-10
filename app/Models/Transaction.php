<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasUlids;

    protected $fillable = [
        'sender_wallet_id',
        'receiver_wallet_id',
        'amount',
        'status',
    ];
}
