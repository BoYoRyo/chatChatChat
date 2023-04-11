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

}
