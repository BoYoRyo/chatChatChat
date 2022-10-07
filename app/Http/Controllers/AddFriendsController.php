<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        return view('addFriends.index',compact('friends'));
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
        $friends = User::where('name','like','%'.$request->name.'%')->get();
        
        return view('addFriends.index',compact('friends'));
        
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
