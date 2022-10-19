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
        if($id == Auth::id()){
            return view('user/edit')->with('user', auth()->user());
        }
        $friend = User::find($id);

        return view('friend/show', compact('friend'));
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
        $friend->blocked = '1';
        $friend->save();

        // １対１のトークをしていた場合、メンバーのレコードを削除→トーク一覧から消える
        $member = Member::whereIn('group_id', Group::whereIn('id',Member::whereIn('user_id', Member::where('user_id',auth()->user()->id)->pluck('group_id'))->where('user_id', $id)->pluck('group_id'))
        ->where('type','0')->get('id'))
        ->where('user_id', $id)
        ->first();

        $member->blocked = 1;
        $member->save();

        return redirect()->route('friend.index');
    }
}
