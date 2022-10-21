<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class friend extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','follow_id','blocked'];

    public function user() {
        return $this->belongsTo(User::class,'follow_id','id');
    }
}
