<?php

namespace Tests\Mock\Models\Othello\Action;

use Packages\Models\Core\Action\Action;
use Packages\Models\Core\Action\ActionType;
use Packages\Models\Core\Board\Position\Position;

class ActionMock
{
    public static function setStone($row = 4, $col = 6): Action
    {
        $position = Position::make([$row, $col]);// 先行プレイヤーが1ターン目に指す場所
        return Action::make(ActionType::SET_STONE, $position);
    }

    public static function skip(): Action
    {
        return Action::make(ActionType::CONFIRM_SKIP);
    }
}
