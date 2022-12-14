<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\Good;

class conversation extends Model
{
    use HasFactory;

    // groupテーブルと結合.
    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function member() {
        return $this->belongsTo(Member::class,'group_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function goods(){
        return $this->hasMany(Good::class);
    }
}
