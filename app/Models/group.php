<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;

    // groupテーブルと結合.
    public function user() {
        return $this->hasMany('App/Models/User');
    }

    // conversationテーブルと結合.
    public function conversation() {
        return $this->hasMany('App/Models/conversation');
    }
}
