<?php

namespace App\Models;

use App\Models\conversation as ModelsConversation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\conversation;

class Good extends Model
{
    use HasFactory;

    protected $fillable = [
       'conversation_id',
       'user_id',
    ];


    public function conversation(){
        return $this->belongsTo(conversation::class);
    }
}
