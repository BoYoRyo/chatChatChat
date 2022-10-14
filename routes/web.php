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
    // 友達詳細画面に遷移
    Route::get('/friend/show/{id}', [App\Http\Controllers\FriendController::class, 'show'])->name('friend.show');


    // プロフィール画面に遷移
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    // プロフィール更新

    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    //フレンド検索画面に遷移
    Route::get('add/index', [AddFriendsController::class, 'index'])->name('add.index');
    //フレンド検索
    Route::post('add/show', [AddFriendsController::class, 'show'])->name('add.show');
    //フレンド追加
    Route::get('add/connect/{id}', [AddFriendsController::class, 'connect'])->name('add.connect');
    //フレンド登録完了画面に遷移
    Route::get('add/finished', [AddFriendsController::class, 'finished'])->name('add.finished');
    Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

    // トーク一覧を表示する
    Route::get('/talk/index', [App\Http\Controllers\TalkController::class, "index"])->name('talk.index');

    // トークを開始する
    // Route::get('/talk/create', [App\Http\Controllers\TalkController::class, "create"])->name('talk.create');
    Route::get('/talk/store/{id}', [App\Http\Controllers\TalkController::class, "store"])->name('talk.store');
    Route::post('/conversation/store', [App\Http\Controllers\ConversationController::class, "store"])->name('conversation.store');

    // トーク画面を表示する
    Route::get('/talk/show/{id}', [App\Http\Controllers\TalkController::class, "show"])->name('talk.show');

    // トークを非表示にする
    Route::get('/talk/update/{id}',[App\Http\Controllers\TalkController::class, "update"])->name('talk.update');

    Route::get('/friend/index', [App\Http\Controllers\FriendController::class, 'index'])->name('friend.index');
    // Route::resource('friend', FriendController::class);

});
