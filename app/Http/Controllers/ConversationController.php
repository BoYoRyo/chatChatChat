<?php

namespace App\Http\Controllers;

use App\Models\conversation;
use App\Models\Member;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    protected $conversation;
    protected $member;

    public function __construct(
        conversation $conversation,
        Member $member
    )
    {
        $this->conversation = $conversation;
        $this->member = $member;
    }
    
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
     * トークを投稿する.
     *
     * @param  $request : トーク
     * @return \Illuminate\Http\Response
     */
    public function postConversation(Request $request)
    {
        // トークを保存
        $this->conversation->insertConversation($request);

        // そのグループに所属するmember全員のupdated_atを更新
        $this->member->updateDatetime($request->group_id);

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
