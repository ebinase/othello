<?php

namespace Packages\Models\Game;

/**
 * ゲームの結果を表す区分オブジェクト
 */
class Result
{
    // 正常決着
    const GAME_RESULT_WHITE_WINS      = '01';
    const GAME_RESULT_BLACK_WINS      = '02';
    const GAME_RESULT_DRAW_GAME       = '03';
    // 途中終了
    const GAME_RESULT_DOUBLE_SKIP     = '04';
    const GAME_RESULT_QUIT            = '05';
    const GAME_RESULT_WHITE_SURRENDER = '06';
    const GAME_RESULT_BLACK_SURRENDER = '07';
}
