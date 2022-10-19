<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\friend;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateRequest;
use App\Models\Member;
use App\Models\User;
use App\Models\Good;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TalkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // トーク一覧を表示
        // userIDで絞って、相手のIDでiconを持ってくる
        // ↓ログインユーザーのIDで絞ったグループIDだけでメンバーテーブルを検索（ログインユーザーIDを除外して）
        // SELECT * FROM members WHERE group_id IN (SELECT group_id FROM members WHERE user_id = 1) AND user_id != 1;
        $groups = Member::whereIn('group_id', Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', '!=', auth()->user()->id)
            ->selectRaw('id')
            ->selectRaw('group_id')
            ->selectRaw('user_id')
            ->selectRaw('invisible')
            ->groupBy('group_id')
            ->orderBy('updated_at', 'DESC')
            ->get();


        return view('talk.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        // 過去のトークがあるか検索(SQL発行回数一回ver.)
        // $group = Group::whereIn('id',Member::whereIn('user_id', Member::where('user_id',auth()->user()->id)->pluck('group_id'))
        // ->where('user_id', $id)
        // ->pluck('group_id'))
        // ->where('type','0')
        // ->first();

        // 過去のトークがあるか検索(SQL発行回数複数回ver.)
        $userGroupId = Member::where('user_id',auth()->user()->id)->get(['group_id']);
        $groupId = Member::whereIn('group_id', $userGroupId)->where('user_id', $id)->get(['group_id']);
        $group = Group::whereIn('id', $groupId)->where('type','0')->first();

        if($group != null) {
            return redirect()->route('talk.show',$group->id,);
        }

        // グループを生成
        $group = new Group();
        $group->type = 0;
        $group->save();

        // トークを開始した側
        $member = new Member();
        $member->group_id = $group->id;
        $member->user_id = auth()->user()->id;
        $member->save();

        // トークを開始された側
        $member = new Member();
        $member->group_id = $group->id;
        $member->user_id = $id;
        $member->save();

        return redirect()->route('talk.show', $group->id,);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 画像が添付された場合の処理
        
        $groupId = $id;
        $group = Group::find($groupId);
        
        // 非表示フラグを0（表示）にする処理
        $member = Member::where('group_id',$groupId)->whereNot('user_id',auth()->id())->first();
        $member->invisible = 0;
        $member->save();
        
        // $dialogUser = User::whereIn('id', Member::where('group_id', $groupId)->where('user_id', '!=', auth()->user()->id)->pluck('user_id'))->first();
        
        if($group->type == 0){
            $groupName = User::whereIn('id', Member::where('group_id', $groupId)->where('user_id', '!=', auth()->user()->id)->pluck('user_id'))->first();
        } else {
            $groupName = $group->name;
        }

        //グッドテーブルの該当ユーザーid
        // dd($group->conversation[0]->goods[0]->user_id);
        
        //conversation配列のうち、goodsのuser_idで自分のuser_idが入っているものをピックアップ(good済み)
        //該当グループのコメント一覧のうち、自分のコメント以外のcoversationのidを格納
        $commentIds = Conversation::where('group_id',$groupId)->where('user_id', '!=', auth()->user()->id)->pluck('id');
        // dd($commentIds);
        //1,3,5,7,9→ユーザー2のコメント一覧

        //コメント5番をいいねしたユーザーのid一覧が取れる（☆）
        // $userIds = Good::where('conversation_id',5)->pluck('user_id');
        // 変換前の方が綺麗に配列の形になっている気がする
        // dd($userIds);
        // $userIds = (array)$userIds;
        //→arryの中で1,2がとれてて、あんまり綺麗な配列ではない？
        // dd($userIds);

            // in_arrayは正しく動作した(◆)
            // $hello = "hello";
            // $array = [1,2,3,4,5];
            // dd($array);
            // if(in_array(Auth::id(),$array,true)){
            //     dd($hello);
            // }

        //コメント5にいいねしたユーザ一覧が配列にある時だけ$gooded配列に格納する処理の実験(※)
        // $gooded = array();
        // $userIds = Good::where('conversation_id',5)->pluck('user_id');
        
        // $userIdsArray = $userIds->toArray();
        // dd($userIdsArray);
        // $userIds = (array)$userIds;
        // dd($userIds[0]);
        // if(in_array(Auth::id(),$userIdsArray,true)){
            // array_push($gooded,$commentId);
        //     array_push($gooded,1);
        // }
        // dd($gooded);

        //$goodedには自分がいいねをつけたconversationのidが格納→それをviewで条件分岐させて黄色くする
        $gooded = array();
        if(!$commentIds->isEmpty()){
            foreach($commentIds as $commentId){
                //$userIdsは値があれば既に配列→commentId5で実証済み
                $userIds = Good::where('conversation_id',$commentId)->pluck('user_id');
                
                //$userIdsを配列に変換できることは上で実証できた（☆）
                $userIds = $userIds->toArray();
                // dd($userIds);
                //→foreachの中だから確認できない
                
                //自分のidとusetIdsが一致した時だけgoodedに追加
                //なぜかここが効かない、条件がfalseになる
                //◆よりin_arrayが正しいことがわかる→$userIdsかforeachが悪い
                if(in_array(Auth::id(),$userIds,true)){
                    // array_push($gooded,$commentId);
                    array_push($gooded,$commentId);
                }
               
            }
                
        }
       
        return view('talk.show', compact('group', 'groupName','gooded'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        // トークを非表示にするよう表示フラグを変更
        $member = Member::find($id);
        $member->invisible = 1;
        $member->save();

        return redirect()->route('talk.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
