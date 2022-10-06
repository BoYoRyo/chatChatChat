<?php

namespace App\Http\Controllers;

use App\Models\conversation;
use Illuminate\Http\Request;
use App\Models\group;
use App\Models\friend;

class TalkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // トーク一覧を表示
        $friends = Friend::where('user_id', auth()->user()->id)->get();
        return view('talk.index', compact('friends'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // トーク開始画面を表示
        $friends = Friend::where('user_id', auth()->user()->id)->get();
        return view('talk.create',compact('friends'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        dd($request);
        if(!$request->group_id) {
            // グループを生成
            $group = new group;
            $group->id = $request->id;
            $group->group_id = $request->group_id;
            $group->user_id = $request->user_id;
            $group->invisible_date = $request->invisible_date;
            $group->save();
        }

        // 会話を生成
        $conversation = new conversation;
        $conversation->sending_user_id = $request->user_id;
        $conversation->group_id = $request->group_id;
        $conversation->comment = $request->comment;
        $conversation->save();

        return view('talk.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 過去のトークがあれば表示
        
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
