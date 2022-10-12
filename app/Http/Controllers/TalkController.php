<?php

namespace App\Http\Controllers;

use App\Models\conversation;
use Illuminate\Http\Request;
use App\Models\group;
use App\Models\friend;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateRequest;
use App\Models\Member;
use App\Models\User;

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
        $groups = Member::
            whereIn('group_id',Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', '!=', auth()->user()->id)
            ->get();
        return view('talk.index', compact('groups'));

            // こんばせーしょんも結合したい
            // $latestComment = Conversation::where('group_id', $groups->group_id)->groupBy('group_id')->limit(1)->get();
            // dd($latestComment);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // // トーク開始画面を表示
        // $friends = Friend::where('user_id', auth()->user()->id)->get();
        // return view('talk.create', compact('friends'));
        // // ->with('group',$group)
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        // 過去のトークがあるか検索
        $group = Group::
        whereIn('id',Member::whereIn('user_id', Member::where('user_id',auth()->user()->id)->pluck('group_id'))
        ->where('user_id', $id)
        ->pluck('group_id'))
        ->where('type','0')
        ->first();

        if($group != null) {
            return redirect()->route('talk.show',compact('group'));
        }

        $dialogUser = User::find($id);

        // グループを生成
        $newGroup = new Group();
        $newGroup->type = 0;
        $newGroup->save();
        
        // トークを開始した側
        $member = new Member();
        $member->group_id = $newGroup->id;
        $member->user_id = auth()->user()->id;
        $member->save();

        // トークを開始された側
        $member2 = new Member();
        $member2->group_id = $newGroup->id;
        $member2->user_id = $id;
        $member2->save();

        return view('talk.show',compact('dialogUser'))->with('group',$newGroup);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($groupId)
    {
        
        $group = Group::find($groupId);
        $dialogUser = User::whereIn('id',Member::where('group_id',$groupId)->where('user_id','!=',auth()->user()->id)->pluck('user_id'))->get();
        // dd($dialogUser);

        return view('talk.show',compact('group','dialogUser'));
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
    public function update(Request $request, $id)
    {
        //
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

    public function __invoke(Request $request,$id)
    {
        // トークを保存
        $conversation = new conversation;
        $conversation->user_id = auth()->user()->id;
        $conversation->group_id = Group::
        whereIn('id',Member::whereIn('user_id', Member::where('user_id',auth()->user()->id)->pluck('group_id'))
        ->where('user_id', $id)
        ->pluck('group_id'))
        ->where('type','0')->first();
        $conversation->comment = $request->comment;
        dd($conversation);
        $conversation->save();
        return redirect()->route('talk.show');

    }
}
