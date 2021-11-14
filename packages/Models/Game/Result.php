<?php

namespace Packages\Models\Game;

/**
 * ゲームの結果を表す区分オブジェクト
 */
class Result
{
    const GAME_RESULT_WHITE_WINS = '01';
    const GAME_RESULT_BLACK_WINS = '02';
    const GAME_RESULT_TIE_GAME   = '03';
    const GAME_RESULT_NO_GAME    = '04';
}
