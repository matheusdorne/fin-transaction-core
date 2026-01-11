<?php

namespace App\Http\Controllers;

use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function store(Request $request, TransferService $service)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $service->transfer(
            Auth::id(),
            $validated['receiver_id'],
            $validated['amount']
        );

        return redirect()->back();
    }
}
