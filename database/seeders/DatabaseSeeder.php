<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Conversation;
use App\Models\Friend;
use App\Models\User;
use App\Models\Group;
use App\Models\Member;
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
                // 'name' => Str::random(10),
                'name' => "ユーザー" . $i + 1,
                'email' => Str::random(7).'@example.com',
                'password' => Hash::make('12345678'),
                'account_id' => Str::random(8),
                'icon' => 'default_icon' . random_int(1, 5) . '.png',
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Friend::create([
                'user_id' => 1,
                'follow_id' => $i + 2,
            ]);
        }

        Group::create([
            'type' => 0,
        ]);

        Member::create([
            'group_id' => 1,
            'user_id' => 1,
        ]);
        Member::create([
            'group_id' => 1,
            'user_id' => 2,
        ]);

        Group::create([
            'type' => 0,
        ]);

        Member::create([
            'group_id' => 2,
            'user_id' => 1,
        ]);
        Member::create([
            'group_id' => 2,
            'user_id' => 3,
        ]);

        Group::create([
            'type' => 0,
        ]);

        Member::create([
            'group_id' => 3,
            'user_id' => 1,
        ]);
        Member::create([
            'group_id' => 3,
            'user_id' => 4,
        ]);

        Group::create([
            'type' => 1,
            'name' => 'テストグループ',
            'icon' => 'default_group_icon' . random_int(1, 5) . '.png',
        ]);
        for ($i = 0; $i < 3; $i++) {
            Member::create([
                'group_id' => 4,
                'user_id' => $i + 1,
            ]);
        }
        Member::create([
            'group_id' => 4,
            'user_id' => 10,
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
