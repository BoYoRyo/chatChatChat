<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Conversation;

class Member extends Model
{
    use HasFactory;
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function conversation() {
        return $this->hasOne(Conversation::class,'group_id','group_id')->latestOfMany('created_at');
    }
}
