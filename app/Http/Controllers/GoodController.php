<?php

namespace App\Http\Controllers;

use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
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
     * いいねをつける
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $good = new Good();
        $good->create([
            'conversation_id' => $request->conversationId,
            'user_id' => Auth::id(),
        ]);

        $id = $request->groupId;
        return redirect()->route('talk.show',$id);
        
    }

    /**

     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\good  $good
     * @return \Illuminate\Http\Response
     */
    public function show(good $good)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\good  $good
     * @return \Illuminate\Http\Response
     */
    public function edit(good $good)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\good  $good
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, good $good)
    {
        //
    }

    /**
     * いいねをはずす
     *
     * @param  \App\Models\good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        // dd($request->conversationId);
        $good = Good::where('conversation_id',$request->conversationId)->where('user_id',Auth::id());
        $good->delete();
        
        $id = $request->groupId;
        return redirect()->route('talk.show',$id);
    }
}
