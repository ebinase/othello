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
    {}

    public function process(Position $playerMove)
    {
        // TODO: 処理追加　
        // HACK: ゲームの進行とゲーム情報の分離を検討
        $this->turn = $this->turn->next($playerMove);
    }
}
