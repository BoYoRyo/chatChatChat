<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\conversation;
use App\Models\Member;
use App\Models\group;
use Illuminate\Support\Facades\Redirect;

class ConversationController extends Controller
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
        // トークを保存
        $conversation = new conversation;
        $conversation->user_id = auth()->user()->id;
        $conversation->group_id = $request->group_id;
        $conversation->comment = $request->comment;
        $conversation->image = $request->image;
        if($conversation->image != null) {
            $originalName = $request->file('image')->getClientOriginalName();
            // 日時追加
            $name = date('Ymd_His').'_'.$originalName;
            $request->file('image')->move('storage/img',$name);
            $conversation->image = $name;
        }
        $conversation->save();

        // そのグループに所属するmember全員のupdated_atを更新
        Member::where('group_id', $request->group_id)->update(['updated_at' => now(),'invisible' => 0 ]);

        return redirect()->route('talk.show',$request->group_id);
        // return redirect()->route('talk.show', ['id' => $request->group_id, 'notReadCount' => 0]);
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
