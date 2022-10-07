<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Conversation;
use App\Models\Friend;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => Str::random(10),
                'email' => Str::random(7).'@example.com',
                'password' => Hash::make('12345678'),
                'account_id' => Str::random(8),
                'icon' => 'default_icon' . random_int(1, 5) . '.png',
            ]);
        }

        for ($i = 0; $i < 9; $i++) {
            Friend::create([
                'user_id' => 1,
                'follow_id' => $i + 2,
            ]);
        }

        Group::create([
            'group_id' => 1,
            'user_id' => 1,
        ]);
        Group::create([
            'group_id' => 1,
            'user_id' => 2,
        ]);

        for ($i = 1; $i < 10; $i++) {
            Conversation::create([
                'user_id' => ($i % 2) + 1,
                'group_id' => 1,
                'comment' => Str::random(10),
            ]);
        }
    }
}
