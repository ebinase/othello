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
    return view('welcome');
});

Route::group('match', function() {
    Route::name('match.')->group(function() {
        // ゲーム画面を表示
        Route::get('show', 'MatchController@show')->name('show');
        // ターンを更新する
        Route::post('process', 'MatchController@process')->name('process');
    });
});
