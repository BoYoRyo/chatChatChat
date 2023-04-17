<?php

namespace App\Http\Controllers;

use App\Models\friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddFriendsController extends Controller
{
    protected $friend;

    public function __construct(
        friend $friend
    )
    {
        $this->friend = $friend;
    }
    
    /** 
     * フレンド追加画面を表示.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = $this->getAddingFriend()->get();

        return view('addFriends.index', [
            'results' => $results,
            'addFriendName' => null,
            'search' => null
        ]);
    }

    /**
     * フレンドを検索する処理.
     *
     * @param  $request : アカウントIDまたは名前
     * @return フレンド検索画面
     */
    public function searchFriend(Request $request)
    {
        $adding_friends = $this->getAddingFriend();

        $results = $adding_friends
        ->where(function ($query) use ($request) {
            $query->where('name', 'like', "%$request->search%")
            ->orWhere('account_id', 'like', "%$request->search%");
        })
        ->get()
        ;

        return view('addFriends.index', [
            'results' => $results,
            'addFriendName' => null,
            'search' => $request['search']
        ]);
    }

    /**
     * マイフレンドに追加.
     *
     * @param  $id : 追加したいフレンドのユーザーID.
     * @return 
     */
    public function addMyFriend($id)
    {
        // マイフレンドに追加.
        $this->friend->insertFriend($id);
        
        // マイフレンドに追加したユーザの名前を取得.
        $addFriendName = DB::table('users')
        ->select('name')
        ->where('id', $id)
        ->first()
        ;

        $results = $this->getAddingFriend()->get();

        return view('addFriends.index', [
            'results' => $results,
            'addFriendName' => $addFriendName,
            'search' => null
        ]);

    }

    /**
     * 追加対象となるフレンドの取得.
     *
     * @return 追加対象となるフレンド
     */
    private function getAddingFriend()
    {
        // ログインユーザーが既にフォローしているフレンドのIDを取得.
        $following_friend_ids = DB::table('friends')
        ->select('follow_id')
        ->where('user_id', auth()->user()->id)
        ;

        // 追加対象となるフレンドの取得.
        $result = DB::table('users')
        ->select(
            'id',
            'name',
            'icon',
            'account_id',
        )
        ->whereNot('id',auth()->user()->id) // ログインユーザーは除く
        ->whereNotIn('id',$following_friend_ids)
        ;

        return $result;
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
}
