<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Group;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class FriendController extends Controller
{   
    protected $friend;

    public function __construct(
        friend $friend
    )
    {
        $this->friend = $friend;
    }
    
    /**
     * フォローしているフレンズ一覧を取得・表示
     *
     * @return
     */
    public function index()
    {
        // 非ブロックのフレンズのIDを取得.
        $follow_users = DB::table('friends')
        ->select('follow_id')
        ->where('user_id', auth()->user()->id)
        // TODO 定数をconfigで管理したい
        ->where('blocked', Friend::BLOCK_FLAG['非ブロック'])
        ;
        
        // フレンズの情報を取得.
        $friends = DB::table('users')
        ->select(
            'users.id',
            'follow_users.follow_id',
            'users.name',
            'users.icon',
            'users.introduction',
        )
        ->JoinSub($follow_users, 'follow_users', function($join) {
            $join->on('follow_users.follow_id', '=', 'users.id');
        })
        ->where('deleted_at', null)
        ->get()
        ;

        return view('friend.index', ['friends' => $friends]);
    }

    /**
     * ブロック一覧を表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function blockedIndex()
    {
        // ユーザーがブロックしているフレンズの取得.
        $friends = DB::table('friend')
        ->where('user_id', auth()->user()->id)
        // TODO マジックナンバーから定数に置き換えたい
        ->where('blocked', Friend::BLOCK_FLAG['ブロック'])
        ->get()
        ;

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
     * フレンズのプロフィールを取得.
     *
     * @param  int $id : ユーザーID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // グループ詳細から自分のアイコンをクリックした場合、自分のプロフィール画面へ
        if ($id == Auth::id()) {
            return view('user/edit')->with('user', auth()->user());
        }

        // フレンズのプロフィール情報を取得.
        $friend_detail = DB::table('users')
        ->select(
            'users.id',
            'users.name',
            'users.icon',
            'users.introduction',
            'users.account_id',
            'friends.blocked',
        )
        ->join('friends', 'friends.follow_id', '=', 'users.id')
        ->where('friends.user_id', Auth::id())
        ->where('friends.follow_id', $id)
        ->first()
        ;

        return view('friend/show', ['friend_detail' => $friend_detail]);
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
        $friend->blocked = true;
        $friend->save();

        // １対１のトークをしていた場合、メンバーテーブルのブロックフラグをたてる→トーク一覧から消える
        $member = Member::whereIn('group_id', Group::whereIn('id', Member::whereIn('user_id', Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', $id)
            ->pluck('group_id'))
            ->where('type', '0')->get('id'))
            ->where('user_id', $id)
            ->first();

        if ($member) {
            $member->blocked = 1;
            $member->save();
        }

        return redirect()->route('friend.show', $id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelDestroy($id)
    {
        // フレンドテーブルのブロックフラグを消す -> フレンド一覧に復帰
        $friend = Friend::where('user_id', Auth::id())->where('follow_id', $id)->first();
        $friend->blocked = false;
        $friend->save();

        // １対１のトークをしていた場合、メンバーテーブルのブロックフラグを消す -> トーク一覧から復帰
        $member = Member::whereIn('group_id', Group::whereIn('id', Member::whereIn('user_id', Member::where('user_id', auth()->user()->id)->pluck('group_id'))
            ->where('user_id', $id)
            ->pluck('group_id'))
            ->where('type', '0')->get('id'))
            ->where('user_id', $id)
            ->first();

        if ($member) {
            $member->blocked = 0;
            $member->save();
        }

        // 元いたページへ
        return Redirect::back();
    }
}
