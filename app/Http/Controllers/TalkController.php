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
            return redirect()->route('talk.show',$group->id);
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

        return redirect()->route('talk.show', $group->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

        return view('talk.show', compact('group', 'groupName'));
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
