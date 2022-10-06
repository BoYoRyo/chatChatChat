<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
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
        //
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
     * 自分のプロフィール画面表示＆編集画面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('/user/edit')->with('user', auth()->user());
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
        $Validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'acount_id' => ['required', 'string'],
        ]);

        if ($Validator->fails()) {
            return redirect()->route('user.index')
                ->withInput()
                ->withErrors($Validator);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->acount_id = $request->acountId;
        $user->introduction = $request->introduction;
        // $user->icon = $request->icon;
        if(request('icon')){
            $original = request()->file('icon')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            request()->file('icon')->move('storage/images', $name);
            $user->icon = $name;
        }

        $user->save();

        return redirect()->route('user.edit')->with('message', 'プロフィールを更新しました');
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
