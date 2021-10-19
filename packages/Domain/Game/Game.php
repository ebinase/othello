<?php

namespace Packages\Domain\Game;

use Packages\Domain\Turn\Turn;

class Game
{
    private $id;
    private $whitePlayer;
    private $blackPlayer;
    private $gameStatus;
    private Turn $turn;


    public function __construct($id, $whitePlayer, $blackPlayer, $gameStatus, Turn $turn)
    {
        $this->id = $id;
        $this->whitePlayer = $whitePlayer;
        $this->blackPlayer = $blackPlayer;
        $this->gameStatus = $gameStatus;
        $this->turn = $turn;
    }

    public function process(Position $playerMove)
    {
        // TODO: 処理追加　
        // HACK: ゲームの進行とゲーム情報の分離を検討
        $this->turn = $this->turn->next($playerMove);
    }
}
