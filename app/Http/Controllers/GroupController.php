<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\friend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $friends = Friend::where('user_id', auth()->user()->id)->get();
        return view('group.create', compact('friends'));
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
            'name' => ['required'],
        ]);

        if ($Validator->fails()) {
            return redirect()->route('group.create')
            ->withInput()
            ->withErrors($Validator);
        }

        // 新規グループ作成
        $group = new Group();
        $group->name = $request->name;
        $group->type = 1;
        if(request('icon')){
            $original = request()->file('icon')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('icon')->move('icon', $name);
            $group->icon = $name;
        } else {
            $group->icon = 'default_group_icon' . random_int(1, 5) . '.png';
        }
        $group->save();

        $id = $group->id;

        // メンバーテーブルにインサート
        // 一括でインサートするために、ログインユーザーのidを配列に入れる
        $member[] = array(
            'group_id' => $id,
            'user_id' => Auth::id(),
        );

        // 追加したいメンバーのidを配列に入れる
        foreach($request->memberId as $memberId){
            $member[] = array(
                'group_id' => $id,
                'user_id' => $memberId,
            );
        }

        DB::table('members')->insert($member);

        // トーク画面へ遷移
        return redirect()->route('talk.show', compact('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
