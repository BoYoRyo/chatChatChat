<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    public function update(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'accountId' => ['required'],
        ]);

        if ($Validator->fails()) {
            return redirect()->route('user.edit')
                ->withInput()
                ->withErrors($Validator);
        }

        $user = User::find(auth()->id());
        $user->id = auth()->id();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->account_id = $request->accountId;
        $user->introduction = $request->introduction;
        if (request('icon')) {
            $original = request()->file('icon')->getClientOriginalName();
            $name = date('Ymd_His') . '_' . $original;
            request()->file('icon')->move('icon', $name);
            $user->icon = $name;
        } elseif (request('icon') == null) {
            $user->icon = 'default_icon' . random_int(1, 5) . '.png';
        }

        $user->save();

        return redirect()->route('user.edit')->with('message', 'プロフィールを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function softDelete()
    {
        $user = User::find(Auth::id());
        $user->name = "[unknown]";
        $user->icon = "default_icon_reset.png";
        $user->introduction = null;
        $user->save();

        $user->delete();
        return redirect()->route('login');
    }
}
