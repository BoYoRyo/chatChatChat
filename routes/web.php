<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddFriendsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

// ログイン時のみ実行できるルーティング
Route::group(['middleware' => 'auth'], function () {
    // 友達一覧画面に遷移
    Route::get('/friend/index', [FriendController::class, 'index'])->name('friend.index');
    // ブロック一覧画面に遷移
    Route::get('/friend/blocked/index', [FriendController::class, 'blockedIndex'])->name('friend.blockedIndex');
    // 友達詳細画面に遷移
    Route::get('/friend/show/{id}', [FriendController::class, 'show'])->name('friend.show');
    //フレンドブロック
    Route::get('/friend/blockingFriend/{id}', [FriendController::class, 'blockingFriend'])->name('friend.blockingFriend');
    //フレンドブロック解除
    Route::get('/friend/cancel/{id}', [FriendController::class, 'cancelDestroy'])->name('friend.cancelDestroy');


    // プロフィール画面に遷移
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    // プロフィール更新
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    // アカウント削除
    Route::post('/user/softDelete', [UserController::class, 'softDelete'])->name('user.softDelete');

    //フレンド検索画面に遷移
    Route::get('add/friend', [AddFriendsController::class, 'index'])->name('add.friend');
    //フレンド検索
    Route::post('add/searchFriend', [AddFriendsController::class, 'searchFriend'])->name('add.searchFriend');
    //フレンド追加
    Route::get('add/myfriend/{id}', [AddFriendsController::class, 'addMyFriend'])->name('add.myFriend');
    //フレンド登録完了画面に遷移
    Route::get('add/finished', [AddFriendsController::class, 'finished'])->name('add.finished');

    // トーク一覧を表示する
    Route::get('/talk/index', [App\Http\Controllers\TalkController::class, "index"])->name('talk.index');
    // トークを開始する
    Route::get('/talk/store/{id}', [App\Http\Controllers\TalkController::class, "store"])->name('talk.store');
    Route::post('/conversation/store', [App\Http\Controllers\ConversationController::class, "store"])->name('conversation.store');
    // トーク画面を表示する
    Route::get('/talk/show/{id}', [App\Http\Controllers\TalkController::class, "show"])->name('talk.show');
    // トークを非表示にする
    Route::get('/talk/update/{id}',[App\Http\Controllers\TalkController::class, "update"])->name('talk.update');

    Route::get('/friend/index', [App\Http\Controllers\FriendController::class, 'index'])->name('friend.index');
    // Route::resource('friend', FriendController::class);


    // グループ作成画面を表示する
    Route::get('/group/create', [App\Http\Controllers\GroupController::class, 'create'])->name('group.create');
    // グループ作成する
    Route::get('/group/store', [App\Http\Controllers\GroupController::class, 'store'])->name('group.store');
    // グループ詳細画面へ遷移
    Route::get('/group/show/{id}', [App\Http\Controllers\GroupController::class, 'show'])->name('group.show');
    // グループ一覧画面に遷移
    Route::get('/group/index', [App\Http\Controllers\GroupController::class, 'index'])->name('group.index');
    // グループにメンバーを追加する画面へ遷移
    Route::get('/group/edit/{id}', [App\Http\Controllers\GroupController::class, 'edit'])->name('group.edit');
    // グループにメンバーを追加
    Route::post('/group/update/{id}', [App\Http\Controllers\GroupController::class, 'update'])->name('group.update');


    //いいねをつける
    Route::post('good/create/{groupId}/{conversationId}',[App\Http\Controllers\GoodController::class, 'create'])->name('good.create');
    //いいねをはずす
    Route::post('good/destroy/{conversationId}/{groupId}',[App\Http\Controllers\GoodController::class, 'destroy'])->name('good.destroy');
});
