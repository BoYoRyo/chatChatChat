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

// トークを開始する
Route::post('/sendtalk/create', [App\Http\Controllers\SendTalkController::class, "create"])->name('sendtalk.create');
Route::post('/sendtalk/store', [App\Http\Controllers\SendTalkController::class, "store"])->name('sendtalk.store');
require __DIR__ . '/auth.php';

Route::get('/friend/index', [App\Http\Controllers\FriendController::class, 'index'])->name('friend.index');
// Route::resource('friend', FriendController::class);
