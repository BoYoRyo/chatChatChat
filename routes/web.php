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

// トーク一覧を表示する
Route::get('/talk/index', [App\Http\Controllers\TalkController::class, "index"])->name('talk.index');

// トークを開始する
Route::get('/talk/create', [App\Http\Controllers\talkController::class, "create"])->name('talk.create');
Route::post('/talk/store', [App\Http\Controllers\TalkController::class, "store"])->name('talk.store');

// トーク画面を表示する
Route::get('/talk/show', [App\Http\Controllers\TalkController::class, "show"])->name('talk.show');

Route::get('/friend/index', [App\Http\Controllers\FriendController::class, 'index'])->name('friend.index');
// Route::resource('friend', FriendController::class);
