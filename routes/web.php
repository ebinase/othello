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

Route::controller(App\Http\Controllers\GameController::class)->prefix('game')->name('game.')->group(function() {
    // ゲームメニューを表示
    Route::get('/', [
        'as' => 'index',
        'uses' =>'index'
    ]);
    // ゲームを初期化
    Route::get('/start/{game_mode}', [
        'as' => 'start',
        'uses' => 'start'
    ]);
    // ゲーム画面を表示
    Route::get('/show/{game_id}', [
        'as' => 'show',
        'uses' => 'show'
    ]);
    // ゲームの結果
    Route::get('/result/{game_id}', [
        'as' => 'showResult',
        'uses' => 'showResult'
    ]);

    // ターンを更新する
    Route::post('/process', [
        'as' => 'process',
        'uses' => 'App\Http\Controllers\GameController@process'
    ]);
});
