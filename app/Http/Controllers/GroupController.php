<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Member;

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
        return view('/group/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // メンバーが一人以上選択されていないとエラー
        $Validator = Validator::make($request->all(), [
            'member' => ['required'],
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
        foreach($request->member_id as $memberId){
            $member = array(
                'group_id' => $group->id,
                'user_id' => $memberId,
            );
        }
        DB::table('members')->insert($member);

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
