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
});

Route::prefix('game')->group(function() {
    Route::name('game.')->group(function() {
        // ゲーム画面を表示
        Route::get('/', [
            'as' => 'index',
            'uses' => 'App\Http\Controllers\GameController@index'
        ]);
        // ゲーム画面を表示
        Route::get('/show/{game_id}', [
            'as' => 'show',
            'uses' => 'App\Http\Controllers\GameController@show'
        ]);
        // ゲームを初期化
        Route::get('/start', [
            'as' => 'start',
            'uses' => 'App\Http\Controllers\GameController@start'
        ]);
        // ターンを更新する
        Route::post('/process', [
            'as' => 'process',
            'uses' => 'App\Http\Controllers\GameController@process'
        ]);
    });
});
