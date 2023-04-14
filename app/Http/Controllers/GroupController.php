<?php

namespace App\Http\Controllers;

use App\Models\friend;
use App\Models\group;
use App\Models\Member;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class GroupController extends Controller
{
    /**
     * グループ一覧を取得する処理.
     *
     * @return グループ一覧
     */
    public function index()
    {
        // ログインユーザーが所属しているグループIDを取得.
        $login_user_group_ids = DB::table('members')
        ->select('group_id')
        ->where('user_id', auth()->user()->id)
        ;

        // グループ情報の取得.
        $groups = DB::table('groups')
        ->select(
            'groups.id',
            'groups.name',
            'groups.icon'
        )
        ->joinSub($login_user_group_ids, 'login_user_group_ids', function (JoinClause $join) {
            $join->on('login_user_group_ids.group_id', '=', 'groups.id');
        })
        // TODO const.phpでできれば管理したい
        ->where('groups.type', Group::GROUP_TYPE['グループ'])
        ->orderBy('groups.updated_at', 'DESC')
        ->get()
        ;

        return view('group.index', compact('groups'));
    }

    /**
     * グループ作成時にフレンドを取得（表示）する処理.
     *
     * @return $friend : フレンド一覧
     */
    public function create()
    {
         $friends = DB::table('friends')
         ->select(
            'users.id AS user_id',
            'users.name AS user_name',
            'users.icon  AS user_icon'
         )
         ->join('users', 'users.id', '=', 'friends.follow_id')
         ->where('friends.user_id', auth()->user()->id)
        //  TODO const.phpで管理したい
         ->where('friends.blocked', Friend::BLOCK_FLAG['非ブロック'])
         ->whereNull('users.deleted_at')
         ->get()
         ;

        return view('group.create', ['friends' => $friends]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // メンバーが一人以上選択されていない、名前が未設定だとエラー
        $Validator = Validator::make($request->all(), [
            'memberId' => ['required'],
            'groupName' => ['required'],
        ],
    [
        'memberId.required' => 'メンバーは、2人以上選択してください。',
    ]);

        if ($Validator->fails()) {
            return redirect()->route('group.create')
                ->withInput()
                ->withErrors($Validator);
        }

        // 新規グループ作成
        $group = new Group();
        $group->name = $request->groupName;
        $group->type = 1;
        $group->icon = 'default_group_icon' . random_int(1, 5) . '.png';
        // if (request('icon')) {
        //     $original = request()->file('icon')->getClientOriginalName();
        //     $name = date('Ymd_His') . '_' . $original;
        //     request()->file('icon')->move('icon', $name);
        //     $group->icon = $name;
        // } else {
        //     $group->icon = 'default_group_icon' . random_int(1, 5) . '.png';
        // }
        $group->save();

        $id = $group->id;

        // メンバーテーブルにインサート
        // 一括でインサートするために、ログインユーザーのidを配列に入れる
        $member[] = array(
            'group_id' => $id,
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        );

        // 追加したいメンバーのidを配列に入れる
        foreach ($request->memberId as $memberId) {
            $member[] = array(
                'group_id' => $id,
                'user_id' => $memberId,
                'created_at' => now(),
                'updated_at' => now(),
            );
        }

        DB::table('members')->insert($member);

        // トーク画面へ遷移
        return redirect()->route('talk.show', compact('id'));
    }

    /**
     * グループ詳細を取得する処理.
     *
     * @param  $id : グループID
     * @return $group_members : グループメンバー
     * @return $group_info : グループ情報
     */
    public function getGroupDetail($id)
    {
        // グループメンバーの取得.
        $group_members = DB::table('groups')
        ->select(
            'groups.id AS group_id',
            'groups.name AS group_name',
            'groups.icon AS group_icon',
            'users.id AS user_id',
            'users.name AS user_name',
            'users.icon AS user_icon'
        )
        ->join('members', 'members.group_id', '=', 'groups.id')
        ->join('users', 'users.id', '=', 'members.user_id')
        ->where('groups.id', $id)
        ->whereNull('users.deleted_at')
        ->get()
        ;

        // グループ情報を格納.
        $group_info = $group_members[0];

        return view('group.show', [
            'group_members' => $group_members,
            'group_info'    => $group_info
        ]);
    }

    /**
     * 既存メンバー以外を追加できるように取得(表示)する処理.
     *
     * @param  $id : グループID
     * @return $group_info : グループ情報
     * @return $adding_friends : 既存メンバー以外のフレンド
     */
    public function edit($id)
    {
        // グループ情報の取得.
        $group_info = DB::table('groups')
        ->select(
            'id',
            'name',
            'icon'
        )
        ->where('id', $id)
        ->first()
        ;
        
        // ログインユーザーのフレンドを取得
        $user_friends = DB::table('friends')
        ->select('follow_id')
        ->where('user_id', ':user_id')
        ->where('blocked', ':blocked_type')
        ->toSql()
        ;

        // グループのメンバーを取得
        $group_members = DB::table('members')
        ->select('user_id')
        ->where('group_id', $id)
        ;

        // 既にグループに追加されているフレンド以外のフレンド情報を取得
        $adding_friends = DB::table(DB::raw('('.$user_friends .') AS user_friends'))
        ->setBindings([
            ':user_id'      => auth()->user()->id,
            ':blocked_type' => friend::BLOCK_FLAG['非ブロック']
            ])
        ->select(
            'users.id AS user_id',
            'users.name AS user_name',
            'users.icon AS user_icon'
        )
        ->leftJoin('users', function ($join) {
            $join->on('users.id', '=', 'user_friends.follow_id');
        })
        ->whereNotIn('users.id', $group_members)
        ->get()
        ;

        return view('group.edit', [
            'group_info'     => $group_info,
            'adding_friends' => $adding_friends
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd($request);
        // グループにメンバーを追加
        foreach ($request->user_id as $user_id) {
            $member[] = array(
                'group_id' => $id,
                'user_id' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            );

        }

        DB::table('members')->insert($member);

        return Redirect::back();
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
