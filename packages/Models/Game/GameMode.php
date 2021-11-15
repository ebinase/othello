<?php

namespace Packages\Models\Game;

/**
 * ゲームモードを表す区分オブジェクト
 */
class GameMode
{
    const GAME_MODE_VS_PLAYER = '01';
    const GAME_MODE_VS_BOT    = '02';
    const GAME_MODE_VIEWING   = '03';

    public function __construct(private string $mode)
    {
    }


}
