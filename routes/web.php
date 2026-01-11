<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransferController;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $wallet = Wallet::firstOrCreate(
        ['user_id' => Auth::id()],
        ['balance' => 0]
    );

    $users = User::where('id', '!=', Auth::id())->get();

    return Inertia::render('Dashboard', [
        'balance' => $wallet->balance,
        'users' => $users,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/transfer', [TransferController::class, 'store'])->name('transfers.store');
});

require __DIR__.'/auth.php';
