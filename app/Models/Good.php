<?php

namespace App\Models;

use App\Models\conversation as ModelsConversation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\conversation;

class Good extends Model
{
    use HasFactory;

    public function conversation(){
        return $this->hasOne(conversation::class);
    }
}
