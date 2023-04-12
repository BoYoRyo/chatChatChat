<?php

namespace App\Models;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    // TODO const.phpにできれば移行したい
    const BLOCK_FLAG = [
        '非ブロック' => 0,
        'ブロック' => 1
    ];

    /**
     * ブロックしたフレンドのblockフラグを非ブロックからブロックへと変更する処理.
     *
     * @param $group_id : グループID
     * @param $user_id : ブロック対象となるユーザーのID.
     * @return void
     */
    public function updateBlockingFriend($group_id, $user_id)
    {
        // ブロックしたフレンドの取得.
        DB::table('members')
        ->where('group_id', $group_id)
        ->where('user_id', $user_id)
        ->update(['blocked' => self::BLOCK_FLAG['ブロック']])
        ;
        
    }

    /**
     * ブロックしたフレンドをブロック解除する処理.
     *
     * @param $group_id : グループID
     * @param $user_id : ブロック解除したいユーザーのID.
     * @return void
     */
    public function updateCancelingBlockFriend($group_id, $user_id)
    {
        // ブロックしたフレンドの取得.
        DB::table('members')
        ->where('group_id', $group_id)
        ->where('user_id', $user_id)
        ->update(['blocked' => self::BLOCK_FLAG['非ブロック']])
        ;
        
    }

    /**
     * そのグループに所属するmember全員のupdated_atを更新.
     *
     * @param $group_id : グループID
     * @return void
     */
    public function updateDatetime($group_id)
    {
        DB::table('members')
        ->where('group_id', $group_id)
        ->update(['updated_at' => now(),'invisible' => 0 ]);
        
    }

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
