<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Group;

class Member extends Model
{
    use HasFactory;
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function users() {
        return $this->hasOne(User::class);
    }
    public function conversation() {
        return $this->hasOne(Conversation::class,'group_id','group_id')->latestOfMany('created_at');
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
