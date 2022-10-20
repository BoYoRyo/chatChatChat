<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\Member;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;


class FriendController extends Controller
{
    /**
     * 友達一覧を表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends = Friend::where('user_id', auth()->user()->id)->where('blocked', 0)->get();
        return view('friend.index', compact('friends'));
    }

    /**
     * ブロック一覧を表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function blockedIndex()
    {
        $friends = Friend::where('user_id', auth()->user()->id)->where('blocked', 1)->get();
        return view('friend.blocked-index', compact('friends'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // グループ詳細から自分のアイコンをクリックした場合、自分のプロフィール画面へ
        if ($id == Auth::id()) {
            return view('user/edit')->with('user', auth()->user());
        }

        // ユーザーの詳細情報取得
        $friend = User::find($id);

        // ユーザーとの関係を取得
        $followStatus = Friend::where('user_id', Auth::id())->where('follow_id', $id)->value('blocked');
        if($followStatus === 0){
            $relationship = 'friend'; //フォローしている
        } else if($followStatus === 1){
            $relationship = 'blockedFriend'; //ブロックした
        } else {
            $relationship = 'other'; //他人
        }

        return view('friend/show', compact('friend', 'relationship'));
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
        // フレンドテーブルのブロックフラグをたてる→フレンド一覧から消える
        $friend = Friend::where('user_id', Auth::id())->where('follow_id', $id)->first();
        $friend = true;
        $friend->save();

        // １対１のトークをしていた場合、メンバーテーブルのブロックフラグをたてる→トーク一覧から消える
        $member = Member::whereIn('group_id', Group::whereIn('id', Member::whereIn('user_id', Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', $id)
            ->pluck('group_id'))
            ->where('type', '0')->get('id'))
            ->where('user_id', $id)
            ->first();

        if ($member) {
            $member = 1;
            $member->save();
        }

        return redirect()->route('friend.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelDestroy($id)
    {
        // フレンドテーブルのブロックフラグを消す→フレンド一覧に復帰
        $friend = Friend::where('user_id', Auth::id())->where('follow_id', $id)->first();
        $friend = false;
        $friend->save();

        // １対１のトークをしていた場合、メンバーテーブルのブロックフラグを消す→トーク一覧から復帰
        $member = Member::whereIn('group_id', Group::whereIn('id', Member::whereIn('user_id', Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', $id)
            ->pluck('group_id'))
            ->where('type', '0')->get('id'))
            ->where('user_id', $id)
            ->first();

        if ($member) {
            $member = 0;
            $member->save();
        }

        return redirect()->route('friend.blockedIndex');
    }
}
