<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $test = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $test->wallet()->create([
            'balance' => 1000000.00,
        ]);

        $sender = User::factory()->create([
            'name' => 'Matheus Dornelles',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $sender->wallet()->create([
            'balance' => 1250.00,
        ]);

        $receiver = User::factory()->create([
            'name' => 'Linus Torvalds',
            'email' => 'linuxfather@yahoo.com',
            'password' => bcrypt('password'),
        ]);

        $receiver->wallet()->create([
            'balance' => 10.00,
        ]);

        User::factory(5)->create()->each(function ($user) {
            $user->wallet()->create(['balance' => 0]);
        });
    }
}
