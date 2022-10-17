<?php

namespace App\Http\Controllers;

use App\Models\good;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * トーク画面で押したいいね情報を反映させる
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\good  $good
     * @return \Illuminate\Http\Response
     */
    public function destroy(good $good)
    {
        //
    }
}
