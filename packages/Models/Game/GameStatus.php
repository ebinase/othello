<?php

namespace Packages\Models\Game;

/**
 * ゲームの状態を表す区分オブジェクト
 */
class GameStatus
{
    const GAME_STATUS_PLAYING = '01';
    const GAME_STATUS_FINISHED = '02';
    const GAME_STATUS_SUSPENDED = '03';
}
