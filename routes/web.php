<?php

use Illuminate\Support\Facades\Route;

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
    return view('top.index');
})->name('top');

Route::controller(App\Http\Controllers\GameController::class)
    ->prefix('game')->name('game.')->group(function() {
        // ゲームメニューを表示
        Route::get('/',                  ['uses' =>'index',       'as' => 'index']);
        // ゲームを初期化
        Route::get('/start/{game_mode}', ['uses' => 'start',      'as' => 'start']);
        // ゲーム画面を表示
        Route::get('/show/{game_id}',    ['uses' => 'show',       'as' => 'show']);
        // ゲームの結果
        Route::get('/result/{game_id}',  ['uses' => 'showResult', 'as' => 'showResult']);
        // ターンを更新する
        Route::post('/process',          ['uses' => 'process',    'as' => 'process']);
});
