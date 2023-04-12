<?php

namespace App\Models;

use Exception;
use App\Models\Good;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class conversation extends Model
{
    use HasFactory;

    protected $primary_key = ['id'];
    
    protected $fillable = [
        'user_id',
        'group_id',
        'comment',
        'good_id',
        'image'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * トークを投稿する処理.
     *
     * @param  $request : トーク内容
     * @return void
     */
    public function insertConversation($request)
    {
        try
        {
            DB::beginTransaction();
            
            if($request->image == null) {
                $image_name = null;
            } else {
                $originalName = $request->file('image')->getClientOriginalName();
                // 日時追加
                $image_name = date('Ymd_His').'_'.$originalName;
                $request->file('image')->move('storage/img',$image_name);
            }
            
            // トークを保存
            DB::table('conversations')->insert([
                'user_id'    => auth()->user()->id,
                'group_id'   => $request->group_id,
                'comment'    => $request->comment,
                'image'      => $image_name,
                'created_at' => now()
                ]);

            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            // TODO error投げて画面に表示.
        };
    }

    // 以下リファクタリング完了し次第削除
    public function group() {
        return $this->belongsTo(group::class);
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
