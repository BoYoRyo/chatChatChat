<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friend extends Model
{
    use HasFactory;

    // conversationテーブルと結合.
    public function conversation() {
        return $this->belongsTo('App\Models\Conversation');
    }
}
