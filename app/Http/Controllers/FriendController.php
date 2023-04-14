<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
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
     * @return　$friends : フレンド情報
     */
    public function index()
    {
        // フォローしているフレンドの情報を取得.
        $friends = $this->friend->getMyFriend(auth()->user()->id)->get();

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
        $friends = DB::table('friends')
        ->select(
            'users.id',
            'users.name',
            'users.icon'
        )
        ->join('users', 'users.id', '=', 'friends.follow_id')
        ->where('user_id', auth()->user()->id)
        // TODO const.phpで管理したい
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
        $friend_detail = DB::table('friends')
        ->select(
            'users.id',
            'users.name',
            'users.icon',
            'users.introduction',
            'users.account_id',
            'friends.blocked',
        )
        ->join('users', 'users.id', '=', 'friends.follow_id')
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
     * @param  $id : フレンドのユーザーID
     * @return フレンド詳細画面
     */
    public function blockingFriend($id)
    {
        // フレンドをブロック対象へと変更
        $this->friend->updateBlockingFriend($id);

        // ログインユーザーとブロック対象となるフレンドのトークグループのIDを取得.
        $group_id = $this->getGroupIdOf1on1($id);

        // 1対1のトークグループが存在してればblockフラグを非ブロックからブロックへと変更.
        if ($group_id) {
            $this->member->updateBlockingFriend($group_id->id, $group_id->user_id);
        }

        return redirect()->route('friend.show', $id);
    }

    /**
     * フレンドのブロックを解除する処理.
     *
     * @param  $id : フレンドのユーザーID
     * @return フレンド詳細画面
     */
    public function cancelingBlockFriend($id)
    {
        // フレンドのブロックを解除.
        $this->friend->updateCancelingBlockFriend($id);

        // ログインユーザーとブロック対象となるフレンドのトークグループのIDを取得.
        $group_id = $this->getGroupIdOf1on1($id);

        // 1対1のトークグループが存在してればblockフラグをブロックから非ブロックへと変更.
        if ($group_id) {
            $this->member->updateCancelingBlockFriend($group_id->id, $group_id->user_id);
        }

        // 元いたページへ
        return Redirect::back();
    }

    /**
     * 1対1でのトークグループのIDを取得.
     *
     * @param  $id : フレンドのユーザーID
     * @return グループID
     */
    private function getGroupIdOf1on1($id)
    {
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

        return $group_id;
    }
}
