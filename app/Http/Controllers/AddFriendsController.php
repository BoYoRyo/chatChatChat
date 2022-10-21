<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\friend;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

//友達を追加するための処理をまとめたコントローラー
class AddFriendsController extends Controller
{
    /**
     * 友達追加画面を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends = null;
        return view('addFriends.index', compact('friends'));
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
     * 名前かIDで友達を検索し一覧表示する
     *
     * @param  int  $id
     * @return フレンド一覧
     */
    public function show(Request $request)
    {
        $friends = User::whereNotIn('id', friend::where('user_id', Auth::id())->get('follow_id'))
        // ->orWhere('name', 'like', '%' . $request->friendSerchWord . '%')
        ->where('account_id','like','%'.$request->friendSerchWord.'%')
        ->get();

        return view('addFriends.index', compact('friends'));
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
    /**
     * 検索された友達を追加するメソッド
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function connect($id)
    {
        //ユーザー一覧から指定ID（今回友達にしたい人の名前を検索）
        $addFriendName = User::find($id)->name;

        //authのidと$idを使ってfriendテーブルを検索してなければ登録実行。
        //あればその友達の詳細画面に遷移
        $friendOrNot = friend::where('user_id', '=', Auth::id())->where('follow_id', '=', $id)->get();

        //isEmpty()は空ならtrue
        // if ($friendOrNot->isEmpty()) {
            $friend = new friend();
            $friend->create([
                'user_id' => Auth::id(),
                'follow_id' => $id,
            ]);

        //     return view('addFriends.finished', compact('addFriendName'));
        // } else {

        //     return view('addFriends.connected', compact('addFriendName'));
        // }
        return redirect()->route('friend.show', $id);

    }
}
