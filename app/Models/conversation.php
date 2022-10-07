<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversation extends Model
{
    use HasFactory;

    // groupテーブルと結合.
    public function group() {
        return $this->belongsToMany(Group::class);
    }
}
