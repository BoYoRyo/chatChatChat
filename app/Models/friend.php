<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class friend extends Model
{
    use HasFactory;

    // conversationテーブルと結合.
    public function conversation() {
        return $this->belongsTo(Conversation::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
