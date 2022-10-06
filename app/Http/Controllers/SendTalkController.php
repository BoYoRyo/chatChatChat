<?php

namespace App\Http\Controllers;

use App\Models\conversation;
use Illuminate\Http\Request;
use App\Models\group;

class SendTalkController extends Controller
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
        // トーク開始画面を表示
        return view('sendtalk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // グループを生成
        $group = new group;
        $group->id = $request->id;
        $group->group_id = $request->group_id;
        $group->user_id = $request->user_id;
        $group->invisible_date = $request->invisible_date;
        $group->save();

        // 会話を生成
        $conversation = new conversation;
        $conversation->sending_user_id = $request->user_id;
        $conversation->group_id = $group->group_id;
        $conversation->comment = $request->omment;
        $conversation->save();

        return redirect()->view('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // group_idが存在していれば過去のトーク履歴を表示

        // group_idが存在していなければ初期のトーク画面を表示
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
