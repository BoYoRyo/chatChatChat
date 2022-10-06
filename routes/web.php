<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FriendController;

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
    Route::get('/friend/index', [App\Http\Controllers\FriendController::class, 'index'])->name('friend.index');

    // プロフィール画面に遷移
    Route::get('/user/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    // プロフィール更新
    Route::post('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
});
