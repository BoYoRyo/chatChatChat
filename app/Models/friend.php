<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class friend extends Model
{
    use HasFactory;
    
    protected $primary_key = ['id'];
    
    protected $fillable = [
        'user_id',
        'follow_id',
        'blocked'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    // TODO const.phpにできれば移行したい
    const BLOCK_FLAG = [
        '非ブロック' => 0,
        'ブロック' => 1
    ];

    /**
     * マイフレンドに登録する処理.
     *
     * @param  $id : ユーザーID.
     * @return void
     */
    public function insertFriend($id)
    {
        try
        {
            DB::beginTransaction();

            DB::table('friends')->insert([
            'user_id'    => auth()->user()->id,
            'follow_id'  => $id,
            'blocked'    => self::BLOCK_FLAG['非ブロック'],
            'created_at' => now()
            ]);

            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            // TODO 何か書かないといけなかったので調べてから追加
        };
    }

    /**
     * マイフレンドを取得する処理.
     *
     * @param  $id : ログインユーザーID
     * @return $friends : フレンド一覧
     */
    public function getMyFriend($id)
    {
        $friends = DB::table('friends')
        ->select(
            'users.id AS user_id',
            'users.name AS user_name',
            'users.icon AS user_icon',
            'users.introduction AS user_introduction',
        )
        ->join('users', 'users.id', '=', 'friends.follow_id')
        ->where('friends.user_id', auth()->user()->id)
        ->where('friends.blocked', self::BLOCK_FLAG['非ブロック'])
        ->whereNull('users.deleted_at')
        ;

        return $friends;
    }

    /**
     * フレンドをブロックする処理.
     *
     * @param  $id : ブロック対象となるユーザーのID.
     * @return void
     */
    public function updateBlockingFriend($id)
    {
        DB::table('friends')
        ->where('user_id', auth()->user()->id)
        ->where('follow_id', $id)
        ->update(['blocked' => self::BLOCK_FLAG['ブロック']])
        ;
    }

    /**
     * フレンドのブロックを解除する処理.
     *
     * @param  $id : ブロック対象となるユーザーのID.
     * @return void
     */
    public function updateCancelingBlockFriend($id)
    {
        DB::table('friends')
        ->where('user_id', auth()->user()->id)
        ->where('follow_id', $id)
        ->update(['blocked' => self::BLOCK_FLAG['非ブロック']])
        ;
    }

}
