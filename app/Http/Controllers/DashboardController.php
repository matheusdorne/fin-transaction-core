<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService) {}

    public function __invoke(Request $request)
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => Auth::id()],
            ['balance' => 0]
        );

        $transactions = $this->transactionService->getWalletHistory($wallet);

        $users = User::where('id', '!=', Auth::id())->get();

        return Inertia::render('Dashboard', [
            'balance' => $wallet->balance,
            'users' => $users,
            'transactions' => $transactions,
            'myWalletId' => $wallet->id,
        ]);
    }
}
