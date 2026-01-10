<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case COMPLETED = 'COMPLETED';
    case FAILED = 'FAILED';
}
