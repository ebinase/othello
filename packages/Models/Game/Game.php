<?php

namespace Packages\Models\Game;

use Packages\Models\Turn\Turn;

class Game
{
    private function __construct(
        private string $id,
        private GameMode $gameMode,
        private PlayerList $playerList,
        private GameStatus $gameStatus,
        private Turn $turn,
    )
    {
    }

    public function process(?Position $playerMove = null)
    {


        $this->turn = $this->turn->next($playerMove);
    }

//    /**
//     * ゲームを終了する
//     */
//    public function terminate()
//    {
//
//    }

//    /**
//     * 一時中止する
//     */
//    public function suspend()
//    {
//
//    }
//
//    /**
//     * 一時中止していたゲームを再開する
//     */
//    public function restart()
//    {
//
//    }

    public function isGameOver(): bool
    {

    }

    public function getResult()
    {

    }
}
