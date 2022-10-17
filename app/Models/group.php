<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class group extends Model
{
    use HasFactory;

    // // userテーブルと結合.
    // public function user() {
    //     return $this->hasMany(User::class);
    // }

    // conversationテーブルと結合.
    public function conversation() {
        return $this->hasMany(Conversation::class);
    }

    public function member() {
        // グループテーブルが従
        // メンバーテーブルが主
        return $this->belongsTo(Member::class);
    }

    public function members() {
        // グループテーブルが主
        return $this->hasMany(Member::class);
    }
}
