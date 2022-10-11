<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\friend;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateRequest;
use App\Models\Member;
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
        $groups = Member::
            whereIn('group_id',Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', '!=', auth()->user()->id)
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
        // トーク開始画面を表示
        $friends = Friend::where('user_id', auth()->user()->id)->get();
        return view('talk.create', compact('friends'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // グループを生成
        // トークを開始した側
        $group = new group;
        $group->group_id = Group::max('group_id') + 1;
        $group->user_id = auth()->user()->id;
        $group->save();

        // トークを開始された側
        $group->user_id = auth()->user()->id;
        $group->save();

        return view('talk.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 過去のトークがあれば表示

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

    public function __invoke(Request $request)
    {
        // トークを保存
        $conversation = new conversation;
        $conversation->user_id = auth()->user()->id;
        $conversation->group_id = $request->group_id;
        $conversation->comment = $request->comment;
        $conversation->save();
        return redirect()->route('talk.show');

    }
}
