<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Member::class);
    }
}
