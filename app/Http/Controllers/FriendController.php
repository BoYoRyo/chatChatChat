<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class FriendController extends Controller
{   
    protected $friend;
    protected $group;
    protected $member;

    public function __construct(
        friend $friend,
        group $group,
        Member $member,
    )
    {
        $this->friend = $friend;
        $this->group = $group;
        $this->member = $member;
    }
    
    /**
     * フォローしているフレンド一覧を取得・表示
     *
     * @return
     */
    public function index()
    {
        // 非ブロックのフレンドのIDを取得.
        $follow_users = DB::table('friends')
        ->select('follow_id')
        ->where('user_id', auth()->user()->id)
        // TODO 定数をconfigで管理したい
        ->where('blocked', Friend::BLOCK_FLAG['非ブロック'])
        ;
        
        // フレンドの情報を取得.
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
        // ユーザーがブロックしているフレンドの取得.
        $friends = DB::table('friend')
        ->where('user_id', auth()->user()->id)
        // TODO 定数をconfigで管理したい
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
     * フレンドのプロフィールを取得.
     *
     * @param  int $id : ユーザーID
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // ユーザーIDがログインユーザーの場合はプロフィール画面へ遷移.
        if ($id == auth()->user()->id) {
            return view('user/edit')->with('user', auth()->user());
        }

        // フレンドのプロフィール情報を取得.
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
        ->where('friends.user_id', auth()->user()->id)
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
     * フレンドをブロックする処理.
     *
     * @param  $id : ブロック対象となるフレンドのユーザーID
     * @return フレンド詳細画面
     */
    public function blockingFriend($id)
    {
        // フレンドをブロック対象へと変更
        $this->friend->updateBlockingFriend($id);

        // ログインユーザーが所属しているグループIDを取得.
        $login_user_group_ids = DB::table('members')
        ->select('group_id')
        ->where('user_id', auth()->user()->id)
        ;
        
        // ログインユーザーとブロック対象となるフレンドが所属しているグループを取得.
        $group_ids = DB::table('members')
        ->select(
            'members.group_id',
            'members.user_id',
            'members.blocked',
        )
        ->joinSub($login_user_group_ids, 'login_user_group_ids', function (JoinClause $join) {
            $join->on('login_user_group_ids.group_id', '=', 'members.group_id');
        })
        ->where('members.user_id', $id)
        ;

        // ログインユーザーとブロック対象となるフレンドのトークグループのIDを取得.
        $group_id = DB::table('groups')
        ->select(
            'groups.id',
            'group_ids.user_id',
            'group_ids.blocked',
        )
        ->joinSub($group_ids, 'group_ids', function (JoinClause $join) {
            $join->on('group_ids.group_id', '=', 'groups.id');
        })
        // TODO マジックナンバーを定数へと変更.
        ->where('type', 0)
        ->first()
        ;

        // 1対1のトークグループが存在してればblockフラグを非ブロックからブロックへと変更.
        if ($group_id) {
            $this->member->updateBlockingFriend($group_id->id, $group_id->user_id);
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
