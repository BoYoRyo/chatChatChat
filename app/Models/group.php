<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class group extends Model
{
    use HasFactory;

    protected $primary_key = ['id'];
    
    protected $fillable = [
        'type',
        'name',
        'icon'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    // TODO const.phpにできれば移行したい
    const GROUP_TYPE = [
        '1対1' => 0,
        'グループ' => 1
    ];

    public function conversation() {
        return $this->hasMany(Conversation::class);
    }
    
    // public function member() {
    //     // グループテーブルが従
    //     // メンバーテーブルが主
    //     return $this->belongsTo(Member::class);
    // }

    // public function members() {
    //     // グループテーブルが主
    //     return $this->hasMany(Member::class);
    // }
}
