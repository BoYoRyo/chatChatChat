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
use App\Models\Read;
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
        $groups = Member::whereIn('group_id', Member::where('user_id', auth()->user()->id)->where('invisible',0)->pluck('group_id'))
            ->where('user_id', '!=', auth()->user()->id)
            ->where('blocked', 0)
            ->selectRaw('id')
            ->selectRaw('group_id')
            ->selectRaw('user_id')
            ->groupBy('group_id')
            ->orderBy('updated_at', 'DESC')
            ->get();


        ///////////未読機能///////////
        $groupIdList = Member::whereIn('group_id', Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', '!=', auth()->user()->id)
            ->selectRaw('group_id')
            ->groupBy('group_id')
            ->orderBy('updated_at', 'DESC')
            ->pluck('group_id')
            ->toArray();


        //トーク一覧の未読数配列
        $notReadCountList = array();
        //トーク一覧画面のグループidのみを抽出したもの
        $ParticipatedGroupIdList = $groupIdList;
        // dd($ParticipatedGroupIdList);

        foreach($ParticipatedGroupIdList as $id){
            //自分以外の投稿数
            $conversationCount = Conversation::where('group_id',$id)->where('user_id', '!=', Auth::id())->count();
            //既読数
            $readCount = Read::where('group_id',$id)->where('user_id',Auth::id())->count();
            //未読数
            $notReadCount = $conversationCount - $readCount;
            array_push($notReadCountList,$notReadCount);
        }
        // dd($notReadCountList);
        return view('talk.index', compact('groups','notReadCountList'));
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
        $member = Member::where('group_id',$groupId)->where('user_id',auth()->id())->first();
        $member->invisible = 0;
        $member->save();

        // $dialogUser = User::whereIn('id', Member::where('group_id', $groupId)->where('user_id', '!=', auth()->user()->id)->pluck('user_id'))->first();

        if($group->type == 0){
            $groupName = User::whereIn('id', Member::where('group_id', $groupId)->where('user_id', '!=', auth()->user()->id)->pluck('user_id'))->first();
        } else {
            $groupName = $group->name;
        }

        /////////いいね機能/////////
        //conversation配列のうち、goodsのuser_idで自分のuser_idが入っているものをピックアップ(good済み)
        //コメント一覧のうち、自分のコメント以外のcoversationのidを格納
        $commentIds = Conversation::where('group_id',$groupId)->pluck('id');
      
        //$goodListには自分がいいねをつけたconversationのidが格納→それをviewで条件分岐させて黄色くする
        $goodList = array();
        if(!$commentIds->isEmpty()){
            foreach($commentIds as $commentId){
                //$userIdsは値があれば既に配列→commentId5で実証済み
                $userIds = Good::where('conversation_id',$commentId)->pluck('user_id');

                $userIds = $userIds->toArray();
                //自分のidと同じものがあればそのconversation_idをgoodListに加える
                if(in_array(Auth::id(),$userIds,true)){
                    array_push($goodList,$commentId);
                }
            }
        }

        /////////未読機能/////////
         //自分以外の投稿数
         $conversationCount = Conversation::where('group_id',$id)->where('user_id', '!=', Auth::id())->count();
         //既読数
         $readCount = Read::where('group_id',$id)->where('user_id',Auth::id())->count();
         //未読数
         $notReadCount = $conversationCount - $readCount;
        //  dd($notReadCount);

         if($notReadCount > 0){

             $insertConversations = conversation::where('group_id',$id)
             ->where('user_id','!=',Auth::id())
             ->orderBy('created_at','desc')
             ->limit($notReadCount)
             ->get();
            //  dd($insertConversations);
             
             //未読があった分だけreadsテーブルに追加
             foreach($insertConversations as $conversation){
                 $newReadConversation = new Read();
                 $newReadConversation->create([
                     'conversation_id' => $conversation->id,
                     'group_id' => $conversation->group_id,
                     'user_id' => Auth::id(),
                    ]);
                    
                }
            }
        

        /////////既読機能/////////
        //グループid内の全ての既読数
        $readCountList = read::selectRaw('count(conversation_id)')
        ->where('group_id',$id)
        ->whereIn('conversation_id',conversation::where('group_id',$id)->orderBy('id')->pluck('id'))
        ->groupBy('conversation_id')
        ->orderBy('conversation_id','asc')
        ->pluck('count(conversation_id)')
        ->toArray();
                
        return view('talk.show', compact('group', 'groupName','goodList','readCountList','notReadCount'));
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
        $groupMember = Member::find($id);
        $authUser = Member::where('group_id',$groupMember->group_id)->where('user_id',Auth::id())->first();
        $authUser->invisible = 1;
        $authUser->save();

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
